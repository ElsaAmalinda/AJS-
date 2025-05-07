<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari form pemesanan
$nama_pelanggan = $_POST['nama_pelanggan'];
$no_telepon = $_POST['no_telepon'];
$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];

// Insert data pelanggan ke tabel pelanggan
$conn->query("INSERT INTO pelanggan (nama_pelanggan, no_telepon) VALUES ('$nama_pelanggan', '$no_telepon')");
$id_pelanggan = $conn->insert_id;

// Tangkap data alamat dari dropdown
$dusun = $_POST['dusun'];
$desa = $_POST['desa'];
$kecamatan = $_POST['kecamatan'];
$kabupaten = $_POST['kabupaten'];

// Simpan alamat ke dalam tabel alamat_pelanggan
$sql = "INSERT INTO alamat_pelanggan (dusun, desa, kecamatan, kabupaten) VALUES ('$dusun', '$desa', '$kecamatan', '$kabupaten')";
$conn->query($sql);

// Insert data pesanan ke tabel pesanan
$total_harga = 0;
for ($i = 0; $i < count($produk); $i++) {
    $result_produk = $conn->query("SELECT harga FROM produk WHERE id_produk = " . $produk[$i]);
    $row_produk = $result_produk->fetch_assoc();
    $total_harga += $row_produk['harga'] * $jumlah[$i];
}

$conn->query("INSERT INTO pesanan (id_pelanggan, total_harga, status) VALUES ('$id_pelanggan', '$total_harga', 0)");
$id_pesanan = $conn->insert_id;

// Insert detail pesanan
for ($i = 0; $i < count($produk); $i++) {
    $result_produk = $conn->query("SELECT harga FROM produk WHERE id_produk = " . $produk[$i]);
    $row_produk = $result_produk->fetch_assoc();
    $harga = $row_produk['harga'];

    $conn->query("INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga) VALUES ('$id_pesanan', '$produk[$i]', '$jumlah[$i]', '$harga')");
}

// Menampilkan pesan konfirmasi
echo "Pesanan berhasil dibuat. Total harga: Rp$total_harga<br>";
echo "<a href='status_pesanan.php'>Cek Status Pesanan</a>"; // Tautan untuk memeriksa status pesanan

if (isset($_POST['confirm_received'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $conn->query("UPDATE pesanan SET status = 1 WHERE id_pesanan = '$id_pesanan'");
    echo "Pesanan ID: $id_pesanan telah dikonfirmasi diterima.";
}

$conn->close();
?>
