<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari formulir
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

// Insert admin ke dalam tabel admin
$sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Admin berhasil terdaftar.";
    header("Location: login_admin.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
