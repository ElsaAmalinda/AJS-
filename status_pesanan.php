<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "Anda perlu login untuk melihat status pesanan.";
    exit;
}

// Ambil ID pelanggan dari sesi
$id_pelanggan = $_SESSION['user_id'];

// Ambil data pesanan dari database
$result = $conn->query("SELECT * FROM pesanan WHERE id_pelanggan = '$id_pelanggan'");

echo "<h2>Status Pesanan Anda</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID Pesanan</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Konfirmasi</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id_pesanan'] . "</td>
                <td>Rp" . $row['total_harga'] . "</td>
                <td>" . ($row['status'] == 1 ? 'Diterima' : 'Sedang Diproses') . "</td>
                <td>
                    <form method='POST' action='konfirmasi_pesanan.php'>
                        <input type='hidden' name='id_pesanan' value='" . $row['id_pesanan'] . "'>
                        <input type='submit' name='confirm_received' value='Pesanan Diterima'>
                    </form>
                </td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "Anda belum memiliki pesanan.";
}

$conn->close();
?>
