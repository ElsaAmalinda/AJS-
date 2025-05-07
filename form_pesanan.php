<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil daftar produk dari database
$result_produk = $conn->query("SELECT * FROM produk");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Produk</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { text-align: center; }
        form { max-width: 600px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; }
        .form-group button { padding: 10px 20px; background-color: orange; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h2>Form Pemesanan Produk Kerupuk</h2>

<form action="proses_pesanan.php" method="POST">
    <div class="form-group">
        <label for="nama_pelanggan">Nama Pelanggan:</label>
        <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>
    </div>
    
    <div class="form-group">
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>
    </div>

    <div class="form-group">
        <label for="no_telepon">Nomor Telepon:</label>
        <input type="text" id="no_telepon" name="no_telepon" required>
    </div>

    <div class="form-group">
        <label for="produk">Pilih Produk:</label>
        <select id="produk" name="produk[]" multiple required>
            <?php while($row = $result_produk->fetch_assoc()): ?>
                <option value="<?= $row['id_produk']; ?>"><?= $row['nama_produk']; ?> - Rp<?= $row['harga']; ?> (<?= $row['berat']; ?> gr)</option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="jumlah">Jumlah Produk:</label>
        <input type="number" id="jumlah" name="jumlah[]" min="1" required>
    </div>

    <div class="form-group">
        <button type="submit">Pesan Sekarang</button>
    </div>
</form>

</body>
</html>
