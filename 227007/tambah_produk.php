<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_SESSION['username']) && isset($_SESSION['phone_number'])) {
    $username = $_SESSION['username'];
    $phone_number = $_SESSION['phone_number'];
} else {
    $username = "Admin"; // Nilai default jika tidak ada session
    $phone_number = "Tidak diketahui"; // Nilai default jika tidak ada session
}

// Ambil data admin dari database
$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$admin_data = $result->fetch_assoc();
$stmt->close();

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
        // Insert data produk ke tabel produk dengan prepared statement
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, harga, berat, varian_rasa, gambar_produk) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsis", $nama_produk, $harga, $berat, $varian_rasa, $gambar_produk);

        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil ditambahkan ke katalog!'); window.location='katalog.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1; /* Warna latar belakang cerah */
            color: #34495e; /* Warna teks cerah */
            margin: 0;
            padding: 20px;
            display: flex;
            transition: background-color 0.5s ease;
        }

        .container {
            flex: 1;
            max-width: 800px;
            margin: 0;
            background-color: #ffffff; /* Latar belakang form putih */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2980b9; /* Warna judul */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-row label {
            flex: 1;
            font-weight: bold;
            margin-right: 10px;
            color: #34495e;
        }

        .form-row input[type="text"],
        .form-row input[type="number"],
        .form-row input[type="file"] {
            flex: 2;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #bdc3c7;
            background-color: #f4f6f7; /* Warna latar belakang input */
        }

        button {
            background-color: #3498db; /* Warna tombol biru cerah */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9; /* Warna tombol biru muda saat hover */
        }

        .gambar-preview {
            flex: 1;
            margin-right: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px dashed #bdc3c7;
            border-radius: 5px;
            height: 150px;
            background-color: #f4f6f7;
        }

        .gambar-preview img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 5px;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff; /* Latar belakang sidebar */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-right: 10px;
        }

        .sidebar h2 {
            text-align: center;
            color: #34495e;
        }

        .sidebar .admin-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #2980b9;
            margin: 0 auto 10px;
            background-color: #f4f6f7;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sidebar .admin-photo i {
            font-size: 30px;
            color: #2980b9;
            cursor: pointer;
        }

        .sidebar a {
            display: block;
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px 0;
        }

        .sidebar a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin</h2>
    <div class="admin-photo" id="admin-photo-placeholder">
        <?php if ($admin_data['photo']) : ?>
            <img src="foto/<?= $admin_data['photo'] ?>" alt="Admin Photo" width="80" height="80">
        <?php else : ?>
            <span id="admin-photo-placeholder-text">+</span>
        <?php endif; ?>
        <input type="file" id="admin-photo-input" style="display:none;" accept="image/*" onchange="uploadAdminPhoto(event)">
    </div>
    <p>Nama Admin: <?= htmlspecialchars($admin_data['username']) ?></p>
    <p>Nomor Handphone: <?= htmlspecialchars($admin_data['phone_number']) ?></p>

    <a href="halaman_admin.php">Halaman Admin</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Kontainer untuk form tambah produk -->
<div class="container">
    <h1>Tambah Produk</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <label for="nama_produk">Nama Produk:</label>
            <input type="text" name="nama_produk" required>
        </div>
        <div class="form-row">
            <label for="harga">Harga:</label>
            <input type="number" name="harga" required>
        </div>
        <div class="form-row">
            <label for="berat">Berat (kg):</label>
            <input type="number" name="berat" required>
        </div>
        <div class="form-row">
            <label for="varian_rasa">Varian Rasa:</label>
            <input type="text" name="varian_rasa" required>
        </div>
        <div class="form-row">
            <label for="gambar_produk">Gambar Produk:</label>
            <div class="gambar-preview" id="gambar-preview">
                Silakan upload gambar produk
            </div>
            <input type="file" name="gambar_produk" onchange="previewImage(event)" required>
        </div>
        <button type="submit">Tambah Produk</button>
    </form>
</div>

<script>
    document.getElementById('admin-photo-placeholder').onclick = function() {
        document.getElementById('admin-photo-input').click(); // Trigger file input
    };

    function previewImage(event) {
        const preview = document.getElementById('gambar-preview');
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.innerHTML = ''; // Kosongkan preview
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

    function uploadAdminPhoto(event) {
        const file = event.target.files[0];
        // Handle the photo upload for the admin
    }
</script>

</body>
</html>
