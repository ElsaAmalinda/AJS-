<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8; /* Warna latar belakang */
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #2980b9; /* Warna biru */
            text-align: center; /* Pusatkan judul */
            margin-bottom: 30px; /* Jarak bawah lebih besar */
            font-size: 24px; /* Ukuran font lebih besar */
        }

        .form-container {
            background: #fff; /* Warna putih untuk form */
            padding: 30px; /* Ruang dalam form */
            border-radius: 10px; /* Sudut membulat */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan yang lebih halus */
            max-width: 400px; /* Lebar maksimum form */
            margin: 0 auto; /* Pusatkan form */
            transition: box-shadow 0.3s ease; /* Transisi untuk bayangan */
        }

        .form-container:hover {
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2); /* Bayangan lebih kuat saat hover */
        }

        input[type="text"], input[type="password"] {
            width: 90%; /* Lebar penuh */
            padding: 12px; /* Ruang dalam yang lebih besar */
            margin: 10px 10px; /* Jarak vertikal */
            border: 1px solid #ddd; /* Garis tepi */
            border-radius: 15px; /* Sudut membulat */
            font-size: 16px; /* Ukuran font lebih besar */
            transition: border-color 0.3s, box-shadow 0.3s; /* Transisi untuk warna border dan bayangan */
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #3498db; /* Ubah warna border saat fokus */
            outline: none; /* Hilangkan outline default */
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5); /* Tambahkan bayangan saat fokus */
        }

        button[type="submit"] {
            background-color: #34495e; /* Warna biru gelap */
            color: white; /* Warna teks putih */
            border: none; /* Tanpa border */
            padding: 12px; /* Ruang dalam */
            margin: 16px 0; /* Jarak vertikal */
            border-radius: 40px; /* Sudut membulat */
            cursor: pointer; /* Kursor tangan */
            font-size: 16px; /* Ukuran font */
            transition: background-color 0.3s, transform 0.3s; /* Transisi untuk warna latar belakang dan efek hover */
            width: 100%; /* Lebar penuh tombol */
        }

        button[type="submit"]:hover {
            background-color: #2c3e50; /* Warna biru gelap lebih gelap untuk hover */
            transform: translateY(-2px); /* Efek angkat saat hover */
        }

        button[type="submit"]:active {
            transform: translateY(0); /* Mengembalikan posisi saat ditekan */
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login Admin</h2>
    <form action="proses_login_admin.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>