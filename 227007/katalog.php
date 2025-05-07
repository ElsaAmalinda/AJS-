<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika ada permintaan untuk menambahkan produk ke keranjang
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];

    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Tambahkan produk ke keranjang (jika belum ada)
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId;
        echo "<script>alert('Produk berhasil ditambahkan ke keranjang!');</script>";
    } else {
        echo "<script>alert('Produk sudah ada di keranjang!');</script>";
    }
}

// Ambil data produk dari database
$result = $conn->query("SELECT * FROM produk");

echo "<h2>Katalog Produk</h2>";
echo "<div class='katalog'>";

// Loop untuk menampilkan produk
while ($row = $result->fetch_assoc()) {
    echo "<div class='produk'>";
    echo "<img src='foto/" . $row['gambar_produk'] . "' alt='" . $row['nama_produk'] . "' class='gambar-produk'>";
    echo "<h3>" . $row['nama_produk'];
    echo "<p>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>";
    
    // Formulir untuk menambahkan produk ke keranjang
    echo "<form method='POST' action=''>";
    echo "<input type='hidden' name='product_id' value='" . $row['id_produk'] . "'>";
    echo "<button type='submit' name='add_to_cart'>Tambah ke Keranjang <i class='fas fa-shopping-cart'></i></button>"; // Ikon ditambahkan di sini
    echo "</form>";
    
    echo "</div>";
}

echo "</div>";

$conn->close();
?>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5; /* Putih abu-abu */
    margin: 0;
    padding: 20px;
    color: #333; /* Warna teks abu-abu gelap */
}

h2 {
    text-align: center;
    color: #2980b9; /* Warna biru */
}

.katalog {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* Menampilkan 9 produk dalam satu baris */
    gap: 20px; /* Mengatur jarak antar produk */
    justify-items: center;
    padding: 0 20px;
}

.produk {
    background-color: #fff; /* Latar belakang produk putih */
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 15px;
    text-align: center;
    width: 100%; /* Lebar produk */
    max-width: 220px; /* Batas maksimal lebar */
    transition: transform 0.2s;
}

.produk:hover {
    transform: scale(1.05); /* Efek hover */
}

.gambar-produk {
    width: 100%;
    height: 150px; /* Tinggi seragam */
    object-fit: cover; /* Memastikan gambar proporsional */
    border-radius: 8px; /* Sudut membulat */
}

h3 {
    font-size: 16px;
    color: #2980b9; /* Warna biru */
    margin: 10px 0;
    font-weight: bold;
}

p {
    color: #2980b9; /* Warna biru */
    font-size: 18px;
    font-weight: bold;
    margin: 5px 0;
}

button {
    background-color: #2980b9; /* Warna biru tombol */
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%;
    font-size: 14px;
    margin-top: 10px;
}

button:hover {
    background-color: #1a6089; /* Warna biru lebih gelap saat hover */
}

@media (max-width: 1200px) {
    .katalog {
        grid-template-columns: repeat(6, 1fr); /* 6 produk per baris pada layar lebih kecil */
    }
}

@media (max-width: 992px) {
    .katalog {
        grid-template-columns: repeat(4, 1fr); /* 4 produk per baris pada layar lebih kecil */
    }
}

@media (max-width: 768px) {
    .katalog {
        grid-template-columns: repeat(2, 1fr); /* 2 produk per baris pada layar lebih kecil */
    }
}

@media (max-width: 480px) {
    .katalog {
        grid-template-columns: 1fr; /* 1 produk per baris pada layar sangat kecil */
    }
}

</style>

<!-- Ikon Keranjang dengan Tombol -->
    <a href="keranjang.php">
        <button class="cart-button">
            <i class="fas fa-shopping-cart"></i>  <!-- Ikon belanja -->
        </button>
    </a>
</div>

<!-- Tambahkan link Font Awesome di bagian <head> -->
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>