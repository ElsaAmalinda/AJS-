<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Validasi data
    if (empty($nama_pelanggan) || empty($alamat) || empty($no_telepon) || empty($metode_pembayaran)) {
        echo "Semua data harus diisi.";
        exit();
    }

    // Hitung total harga dari produk yang ada di keranjang
    $total_harga = 0;
    foreach ($_SESSION['cart'] as $product_id) {
        $result = $conn->query("SELECT harga FROM produk WHERE id_produk = $product_id");
        if ($row = $result->fetch_assoc()) {
            $total_harga += $row['harga'];
        }
    }

    // Simpan data pemesanan ke tabel pemesanan
    $query = "INSERT INTO pemesanan (nama_pelanggan, alamat, no_telepon, total_harga, metode_pembayaran)
              VALUES ('$nama_pelanggan', '$alamat', '$no_telepon', '$total_harga', '$metode_pembayaran')";
    
    if ($conn->query($query) === TRUE) {
        // Ambil ID pemesanan yang baru saja disimpan
        $order_id = $conn->insert_id;

        // Simpan detail produk yang dipesan ke tabel detail_pemesanan
        foreach ($_SESSION['cart'] as $product_id) {
            $conn->query("INSERT INTO detail_pemesanan (order_id, product_id, quantity) 
                          VALUES ('$order_id', '$product_id', 1)");
        }

        // Kosongkan keranjang setelah pemesanan
        unset($_SESSION['cart']);

        // Redirect ke halaman konfirmasi
        header("Location: konfirmasi.php?order_id=$order_id");
        exit();
    } else {
        echo "Gagal memproses pemesanan: " . $conn->error;
    }
}
?>
