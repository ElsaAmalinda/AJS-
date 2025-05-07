<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJS (Aneka Jajanan Spesial)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px;
            background: linear-gradient(90deg, #3498db, #2980b9);
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }
        .header img {
            width: 80%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 2em;
        }
        .header p {
            font-size: 1em;
            margin-top: 10px;
        }
        .slider {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 20px 0;
            margin-bottom: 30px;
            justify-content: center;
        }
        .slider-item {
            text-align: center;
        }
        .slider-item img {
            width: 200px;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .slider-item img:hover {
            transform: scale(1.05);
        }
        .slider-item p {
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
        }
        .catalog {
            margin-top: 40px;
        }
        .catalog h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }
        .catalog-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .catalog-item {
            text-align: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
        }
        .catalog-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .floating-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007BFF;
            color: white;
            padding: 12px;
            border-radius: 50%;
            font-size: 1.3em;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.2s, background-color 0.3s;
        }
        .floating-icon:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .footer button {
            font-size: 0.9em;
            padding: 6px 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        .footer button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8em;
            }
            .header img {
                width: 90%;
            }
            .slider-item img {
                width: 70%;
                height: auto;
            }
            .floating-icon {
                font-size: 1.2em;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="foto/header.jpg" alt="Foto Pabrik">
        <h1>AJS (Aneka Jajanan Spesial)</h1>
        <p>Cikole Wetan, RT.5/RW.6, Cijulang, Cihaurbeuti, KAB. CIAMIS, CIHAURBEUTI, JAWA BARAT, 46262</p>
    </div>

    <div class="slider">
        <div class="slider-item">
            <img src="foto/produk_1.jpg" alt="Produk 1">
            <p>Seblak</p>
        </div>
        <div class="slider-item">
            <img src="foto/produk_2.jpg" alt="Produk 2">
            <p>Jengkol</p>
        </div>
        <div class="slider-item">
            <img src="foto/produk_3.jpg" alt="Produk 3">
            <p>Bunga</p>
        </div>
        <div class="slider-item">
            <img src="foto/produk_4.jpg" alt="Produk 4">
            <p>Aneka Kerupuk</p>
        </div>
        <div class="slider-item">
            <img src="foto/produk_5.jpg" alt="Produk 5">
            <p>Sotong</p>
        </div>
        <div class="slider-item">
            <img src="foto/produk_6.jpg" alt="Produk 6">
            <p>Makaroni</p>
        </div>
        <div class="slider-item">
            <img src="foto/produk_7.jpg" alt="Produk 7">
            <p>Makaroni Pedas</p>
        </div>
    </div>

    <!-- Katalog Section -->
    <title>Katalog Produk AJS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
        }
        h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #3498db;
        }
        .catalog-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .catalog-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 15px;
            width: 250px;
            height: 300px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .catalog-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .catalog-item h3 {
            font-size: 1.5em;
            color: #2980b9;
            margin-bottom: 15px;
        }
        .catalog-item p {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #555;
        }
        .catalog-item .price {
            font-size: 1.5em;
            font-weight: bold;
            color: #e74c3c;
        }
        .catalog-item button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .catalog-item button:hover {
            background-color: #2980b9;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 1.2em;
        }
        .footer a {
            color: #3498db;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .catalog-item {
                width: 200px;
                height: 250px;
            }
            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>

    <h2>Katalog Aneka Jananan di AJS</h2>

    <div class="catalog-container">
        <!-- Katalog Item 1 -->
        <div class="catalog-item">
            <h3>Kerupuk Mutiara</h3>
            <p>Kerupuk lezat dengan rasa gurih yang khas, siap menemani waktu santai Anda.</p>
            <p class="price">Rp30.000</p>
            <button onclick="alert('Kerupuk Mutiara ditambahkan ke keranjang!')">Tambah ke Keranjang</button>
        </div>

        <!-- Katalog Item 2 -->
        <div class="catalog-item">
            <h3>Kerupuk Teri</h3>
            <p>Kerupuk renyah dengan tambahan teri yang membuatnya semakin nikmat.</p>
            <p class="price">Rp25.000</p>
            <button onclick="alert('Kerupuk Teri ditambahkan ke keranjang!')">Tambah ke Keranjang</button>
        </div>

        <!-- Katalog Item 3 -->
        <div class="catalog-item">
            <h3>Kerupuk Bawang</h3>
            <p>Kerupuk bawang yang crispy dan aromanya sangat menggoda selera.</p>
            <p class="price">Rp28.000</p>
            <button onclick="alert('Kerupuk Bawang ditambahkan ke keranjang!')">Tambah ke Keranjang</button>
        </div>

        <!-- Katalog Item 4 -->
        <div class="catalog-item">
            <h3>Kerupuk Pedas</h3>
            <p>Bagi penyuka pedas, kerupuk ini akan memberikan sensasi pedas yang nikmat.</p>
            <p class="price">Rp35.000</p>
            <button onclick="alert('Kerupuk Pedas ditambahkan ke keranjang!')">Tambah ke Keranjang</button>
        </div>
    </div>

        <!-- Ikon Keranjang -->
        <div class="floating-icon" id="cart-icon">
        🛒 <span id="cart-count">0</span><a href="keranjang.php">Klik</a>
    </div>

    <script>
        // Fungsi untuk menyimpan produk ke keranjang di localStorage
        function addToCart(name, price) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({ name, price });
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }

        // Fungsi untuk memperbarui jumlah produk di keranjang
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cart-count').textContent = cart.length;
        }

        // Event listener untuk tombol "Tambah ke Keranjang"
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                let name = this.getAttribute('data-name');
                let price = this.getAttribute('data-price');
                addToCart(name, price);
            });
        });

        // Perbarui jumlah produk di keranjang saat halaman dimuat
        window.onload = function() {
            updateCartCount();
        }
    </script>

    <div class="footer">
        <p>Ingin melihat lebih banyak produk? <a href="katalog.php">Lihat Semua Produk</a></p>
    </div>

</body>
</html>