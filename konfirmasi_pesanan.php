<?php
// Mulai session untuk mengambil data sebelumnya
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID pemesanan dari URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;
if ($order_id == 0) {
    die("ID pemesanan tidak ditemukan.");
}

// Ambil detail pemesanan
$order_query = "SELECT * FROM pemesanan WHERE id_pemesanan = $order_id";
$order_result = $conn->query($order_query);
if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    die("Pemesanan tidak ditemukan.");
}

// Ambil detail produk yang dipesan
$items_query = "SELECT p.nama_produk, dp.quantity, p.harga 
                FROM detail_pemesanan dp
                JOIN produk p ON dp.product_id = p.id_produk
                WHERE dp.order_id = $order_id";
$items_result = $conn->query($items_query);

// Hitung total harga
$total_harga = 0;
$cart_items = [];
while ($item = $items_result->fetch_assoc()) {
    $cart_items[] = $item;
    $total_harga += $item['harga'] * $item['quantity'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #34495e;
        }

        .order-summary {
            margin-bottom: 20px;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-summary th, .order-summary td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .order-summary th {
            background-color: #2980b9;
            color: white;
        }

        .btn-back {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            width: 100%;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Konfirmasi Pemesanan</h2>

    <div class="order-summary">
        <h3>Detail Pemesanan</h3>
        <p><strong>Nama Pelanggan:</strong> <?php echo $order['nama_pelanggan']; ?></p>
        <p><strong>Alamat Pengiriman:</strong> <?php echo $order['alamat']; ?></p>
        <p><strong>No Telepon:</strong> <?php echo $order['no_telepon']; ?></p>
        <p><strong>Metode Pembayaran:</strong> <?php echo $order['metode_pembayaran']; ?></p>
        <p><strong>Total Harga:</strong> Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></p>
    </div>

    <div class="order-items">
        <h3>Rincian Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item) { ?>
                    <tr>
                        <td><?php echo $item['nama_produk']; ?></td>
                        <td>Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>Rp<?php echo number_format($item['harga'] * $item['quantity'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <button class="btn-back" onclick="window.location.href='index.php';">Kembali ke Halaman Utama</button>
</div>

</body>
</html>
