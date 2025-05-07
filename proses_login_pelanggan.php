<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari formulir
$no_telepon = $_POST['no_telepon'];
$password = $_POST['password'];

// Cek kredensial pelanggan
$sql = "SELECT * FROM pelanggan WHERE nama_pelanggan='$nama_pelanggan'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verifikasi password
    if (password_verify($password, $row['password'])) {
        $_SESSION['pelanggan_id'] = $row['id_pelanggan'];
        header("Location: index.php"); // Halaman awal pelanggan setelah login
    } else {
        echo "Password salah.";
    }
} else {
    echo "Username tidak ditemukan.";
}

$conn->close();
?>
