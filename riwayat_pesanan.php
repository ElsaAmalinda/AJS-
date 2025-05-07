<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pesanan dari database
$result = $conn->query("SELECT * FROM pesanan JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.id_pelanggan");

echo "<h2>Riwayat Pesanan</h2>";
echo "<table>";
echo "<tr><th>Nama Pelanggan</th><th>Total Harga</th><th>Status</th><th>Aksi</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['nama_pelanggan'] . "</td>";
    echo "<td>Rp" . $row['total_harga'] . "</td>";
    echo "<td>" . ($row['status'] == 1 ? 'Diterima' : 'Sedang Diproses') . "</td>";
    echo "<td>
            <form method='POST' action='konfirmasi_pesanan.php'>
                <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                <button type='submit' name='confirm'>Konfirmasi</button>
            </form>
          </td>";
    echo "</tr>";
}

echo "</table>";
$conn->close();
?>
