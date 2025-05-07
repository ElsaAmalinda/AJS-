<?php
session_start(); // Mulai session

// Cek apakah id_produk ada di POST
if (isset($_POST['id_produk'])) {
    $id_produk = $_POST['id_produk'];

    // Jika session keranjang belum ada, inisialisasi
    if (!isset($_SESSION['keranjang.php'])) {
        $_SESSION['keranjang.php'] = array();
    }

    // Tambahkan produk ke keranjang
    $_SESSION['keranjang.php'][] = $id_produk;

    echo "Produk berhasil ditambahkan ke keranjang!";
} else {
    echo "Tidak ada produk yang ditambahkan.";
}
?>
