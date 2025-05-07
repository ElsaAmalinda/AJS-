<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

// Cek koneksi ke database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek apakah ada ID pemesanan yang diteruskan lewat URL
if (isset($_GET['id_pemesanan'])) {
    $id_pemesanan = $_GET['id_pemesanan'];
} else {
    die("ID Pemesanan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['bukti_bayar'])) {
    $file = $_FILES['bukti_bayar'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    if ($fileError === 0) {
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

        // Mengecek apakah ekstensi file sesuai
        if (in_array($fileExt, $allowedExt)) {
            // Mengecek ukuran file, misalnya maksimal 5MB
            if ($fileSize <= 5 * 1024 * 1024) {
                // Membuat nama file yang unik
                $newFileName = uniqid('', true) . '.' . $fileExt;
                $fileDestination = 'uploads/' . $newFileName;

                // Mengecek apakah folder uploads ada
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0777, true);
                }

                // Pindahkan file ke folder uploads
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Update nama file bukti bayar di tabel pemesanan
                    $stmt = $conn->prepare("UPDATE pemesanan SET bukti_bayar = ? WHERE id_pemesanan = ?");
                    $stmt->bind_param("si", $newFileName, $id_pemesanan);
                    $stmt->execute();

                    echo "Bukti bayar berhasil diunggah.";
                } else {
                    echo "Gagal mengunggah file.";
                }
            } else {
                echo "Ukuran file terlalu besar. Maksimal 5MB.";
            }
        } else {
            echo "Ekstensi file tidak diizinkan. Hanya gambar yang diperbolehkan.";
        }
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}

$result = $conn->query("SELECT * FROM pemesanan WHERE id_pemesanan = $id_pemesanan");

if ($row = $result->fetch_assoc()) {
    echo "<h3>Bukti Pembayaran:</h3>";
    if ($row['bukti_bayar']) {
        echo "<img src='foto/" . $row['bukti_bayar'] . "' alt='Bukti Bayar' width='200'>";
    } else {
        echo "<p>Belum ada bukti pembayaran.</p>";
    }
}

?>

<!-- Form upload bukti bayar -->
<form action="upload_bukti_bayar.php?id_pemesanan=<?php echo $id_pemesanan; ?>" method="POST" enctype="multipart/form-data">
    <label for="bukti_bayar">Upload Bukti Pembayaran</label>
    <input type="file" name="bukti_bayar" required>
    <input type="hidden" name="id_pemesanan" value="<?php echo $id_pemesanan; ?>">
    <button type="submit">Kirim Bukti Bayar</button>
</form>