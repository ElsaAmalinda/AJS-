<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari formulir
$no_telepon = $_POST['no_telepon'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

// Insert pelanggan ke dalam tabel pelanggan
$sql = "INSERT INTO pelanggan (no_telepon, password) VALUES ('$no_telepon', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Pelanggan berhasil terdaftar.";
    header("Location: login.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
