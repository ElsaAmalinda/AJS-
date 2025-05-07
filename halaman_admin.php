<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php"); // Redirect jika belum login
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani aksi hapus atau update produk
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $delete_query = "DELETE FROM produk WHERE id_produk = '$product_id'";
    $conn->query($delete_query);
}

if (isset($_POST['update_price'])) {
    $product_id = $_POST['product_id'];
    $new_price = $_POST['new_price'];
    $update_query = "UPDATE produk SET harga = '$new_price' WHERE id_produk = '$product_id'";
    $conn->query($update_query);
}

// Query untuk menampilkan semua produk
$query = "SELECT * FROM produk";
$result = $conn->query($query);

// Menampilkan informasi admin yang sedang login
$admin_id = $_SESSION['admin_id'];
$query_admin = "SELECT username, bio, phone_number FROM admin WHERE id_admin = '$admin_id'";
$result_admin = $conn->query($query_admin);
$admin_info = $result_admin->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px;
            margin: 10px 0;
            background-color: #3498db; /* Warna latar belakang tombol */
            border-radius: 5px; /* Membuat sudut tombol membulat */
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar {
            width: 200px;
            background-color: #2980b9;
            padding: 20px;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: sticky;
            top: 0; /* Menjaga sidebar tetap di posisi atas saat menggulir */
            left: 0;
            z-index: 100; /* Pastikan sidebar tetap di atas konten */
        }

        .sidebar a:hover {
            background-color: #2980b9; /* Warna latar belakang saat hover */
            transform: scale(1.05); /* Efek tombol sedikit membesar saat hover */
        }

        .sidebar a:active {
            background-color: #1f7fb3; /* Warna saat tombol ditekan */
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 220px; /* Memberikan ruang untuk sidebar agar tidak tumpang tindih */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .admin-info {
            margin-top: 20px;
            background-color: #3498db;
            padding: 15px;
            border-radius: 5px;
            color: white;
        }

        .admin-info h3 {
            margin: 0;
        }

        .admin-info p {
            margin: 5px 0;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #2980b9;
            color: white;
        }

        .form-update-price input {
            padding: 5px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="tambah_produk.php">Tambah Produk</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content">
    <div class="header">
        <h1>Selamat Datang, Admin!</h1>
    </div>

    <!-- Menampilkan informasi admin yang sedang login -->
    <div class="admin-info">
        <h3>Informasi Admin</h3>
        <p><strong>Username:</strong> <?php echo $admin_info['username']; ?></p>
        <p><strong>Bio:</strong> <?php echo $admin_info['bio']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $admin_info['phone_number']; ?></p>
    </div>

    <!-- Menampilkan tabel produk -->
    <div class="table-container">
        <h2>Daftar Produk</h2>
        <table>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id_produk'] . "</td>
                            <td>" . $row['nama_produk'] . "</td>
                            <td>" . $row['harga'] . "</td>
                            <td><img src='foto/" . $row['gambar_produk'] . "' width='100' height='100'></td>
                            <td>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='product_id' value='" . $row['id_produk'] . "'>
                                    <input type='text' name='new_price' value='" . $row['harga'] . "'>
                                    <input type='submit' name='update_price' value='Update Harga'>
                                </form>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='product_id' value='" . $row['id_produk'] . "'>
                                    <input type='submit' name='delete_product' value='Hapus' onclick='return confirm(\"Yakin ingin menghapus produk?\");'>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada produk di katalog.</td></tr>";
            }
            ?>
        </table>
    </div>

</div>

</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>