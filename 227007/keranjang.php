<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambahkan produk ke keranjang
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id']; // Mengambil ID produk dari form input
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId; // Tambahkan ID produk ke session cart
    }
}

// Hapus produk dari keranjang
if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['product_id']; // Mengambil ID produk dari form input
    if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]); // Hapus produk dari session cart
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            font-size: 24px;
            color: #2980b9;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }

        .cart-container {
            display: flex;
            flex-wrap: wrap; /* Mengatur item untuk tampil dalam baris */
            gap: 20px; /* Memberikan jarak antar kotak */
            margin-left: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: flex-start;
            width: 30%; /* Lebar kotak dikurangi agar bisa muat 3 kotak dalam satu baris */
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-sizing: border-box; /* Menjaga padding dan border tetap menghitung dalam lebar elemen */
        }

        .cart-item:hover {
            transform: scale(1.02);
        }

        .cart-item img {
            height: 200px;
            width: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px; /* Memberikan ruang antara gambar dan informasi produk */
        }

        .item-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-left: 10px;
            flex-grow: 1;
            width: 50%;
        }

        .item-details h3 {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-details p {
            font-size: 1rem;
            color: #666;
            margin: 5px 0;
        }

        .item-details .buy-button,
        .item-details .upload-button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: 500;
            margin-top: 10px;
            width: auto; /* Menyusun lebar tombol sesuai konten */
            max-width: 150px; /* Batasi lebar tombol */
            text-align: center; /* Membuat teks di dalam tombol rata tengah */
        }

        .item-details .buy-button:hover,
        .item-details .upload-button:hover {
            background-color: #3498db;
        }
        .item-details .total-price {
            font-weight: 600;
            margin-top: 10px;
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .empty-cart {
            font-size: 1.2rem;
            color: #e74c3c;
            text-align: center;
            font-weight: 700;
        }

        .total {
            margin-top: 30px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #2980b9;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        .popup-content h3 {
            font-weight: 700;
            color: #333;
        }

        .popup-content button {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            margin-top: 10px;
        }

        .popup-content button:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>

<h2>Keranjang Belanja</h2>

<?php
if (empty($_SESSION['cart'])) {
    echo "<p class='empty-cart'>Keranjang Anda kosong.</p>";
} else {
    echo "<div class='cart-container'>";

    $totalHarga = 0;

    foreach ($_SESSION['cart'] as $id_produk) {
        $id_produk = (int)$id_produk;

        // Ambil detail produk dari database
        $result = $conn->query("SELECT * FROM produk WHERE id_produk = $id_produk");
        if ($row = $result->fetch_assoc()) {
            $harga = $row['harga'];
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

            echo "<div class='cart-item'>";
            echo "<img src='foto/" . $row['gambar_produk'] . "' alt='" . $row['nama_produk'] . "'>";
            echo "<div class='item-details'>";
            echo "<h3>" . $row['nama_produk'] . "</h3>";
            echo "<p>Rp" . number_format($harga, 0, ',', '.') . "</p>";

            // Input untuk memilih jumlah
            echo "<form method='POST' style='display:inline;'>
                    <input type='number' name='quantity' value='1' min='1' id='quantity-$id_produk' onchange='updateTotal($id_produk, $harga)' style='width: 50px;' required>
                    <input type='hidden' name='product_id' value='$id_produk'>
                    <button type='submit' name='remove_from_cart'>Hapus</button>
                  </form>";

            // Tombol Beli dan Upload Bukti Bayar
            echo "<button class='buy-button' onclick='showUploadPopup()'>Beli</button>";
            echo "<button class='upload-button' id='upload-$id_produk' onclick='uploadPayment($id_produk)'>Upload Bukti Bayar</button>";

            // Menampilkan total harga produk
            $totalHargaProduk = $harga * $quantity;
            echo "<p id='total-price-$id_produk' class='total-price'>Total: Rp" . number_format($totalHargaProduk, 0, ',', '.') . "</p>";

            echo "</div>"; // End of item-details div
            echo "</div>"; // End of cart-item div

            // Tambahkan harga produk ke total harga keranjang
            $totalHarga += $totalHargaProduk;
        } else {
            continue;
        }
    }
    echo "</div>";

    // Tampilkan total harga
    echo "<div class='total'>Total Harga: Rp" . number_format($totalHarga, 0, ',', '.') . "</div>";
}

$conn->close();
?>

<!-- Popup untuk upload bukti bayar -->
<div class="popup" id="upload-popup">
    <div class="popup-content">
        <h3>Upload Bukti Pembayaran</h3>
        <form action="upload_bukti_bayar.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="bukti_bayar" required>
            <input type="hidden" name="product_id" id="product_id" value="">
            <button type="submit">Kirim Bukti Bayar</button>
        </form>
        <button onclick="closePopup()">Tutup</button>
    </div>
</div>

<script>
    function showUploadPopup() {
        document.getElementById('upload-popup').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('upload-popup').style.display = 'none';
    }

    function uploadPayment(productId) {
        document.getElementById('product_id').value = productId;
    }

    function updateTotal(productId, hargaSatuan) {
        const quantity = document.getElementById('quantity-' + productId).value;
        const totalHarga = hargaSatuan * quantity;
        document.getElementById('total-price-' + productId).textContent = 'Total: Rp' + totalHarga.toLocaleString('id-ID');

        let totalHargaKeranjang = 0;
        const totalPrices = document.querySelectorAll('.total-price');
        totalPrices.forEach(function(priceElement) {
            totalHargaKeranjang += parseInt(priceElement.textContent.replace('Total: Rp', '').replace(/\./g, ''));
        });

        document.querySelector('.total').textContent = 'Total Harga: Rp' + totalHargaKeranjang.toLocaleString('id-ID');
    }
</script>

</body>
</html>