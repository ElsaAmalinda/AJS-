<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penambahan produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $berat = $_POST['berat'];
    $varian_rasa = $_POST['varian_rasa'];
    $gambar_produk = $_FILES['gambar_produk']['name'];
    $target_dir = "foto/"; // Direktori untuk menyimpan gambar
    $target_file = $target_dir . basename($gambar_produk);

    // Pindahkan file gambar ke direktori
    if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $target_file)) {
        // Insert data produk ke tabel produk
        $sql = "INSERT INTO produk (nama_produk, harga, berat, varian_rasa, gambar_produk) 
                VALUES ('$nama_produk', '$harga', '$berat', '$varian_rasa', '$gambar_produk')";

        if ($conn->query($sql) === TRUE) {
            // Redirect ke halaman katalog setelah berhasil menambahkan produk
            header("Location: katalog.php");
            exit(); // Hentikan eksekusi script setelah redirect
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
