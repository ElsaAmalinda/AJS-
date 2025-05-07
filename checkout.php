<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pemesanan_kerupuk");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika tombol checkout ditekan
if (isset($_POST['checkout'])) {
    $total_harga = $_POST['total_harga'];
    echo "<h2>Checkout</h2>";
    echo "<p>Total Pembayaran: Rp" . number_format($total_harga, 0, ',', '.') . "</p>";
    echo "<form method='POST' enctype='multipart/form-data'>
            <label for='payment_method'>Metode Pembayaran:</label>
            <select name='payment_method'>
                <option value='cash'>Cash (Bayar tunai)</option>
                <option value='bank_transfer'>Transfer Bank</option>
            </select><br><br>
            
            <div id='cash_payment' style='display:none;'>
                <label for='payment_receipt'>Upload Bukti Pembayaran (Foto):</label>
                <input type='file' name='payment_receipt' required><br><br>
            </div>
            
            <button type='submit' name='submit_checkout'>Konfirmasi Pembayaran</button>
        </form>";

    // Menampilkan form upload bukti pembayaran untuk metode cash
    echo "<script>
        document.querySelector('select[name=\"payment_method\"]').addEventListener('change', function() {
            if (this.value === 'cash') {
                document.getElementById('cash_payment').style.display = 'block';
            } else {
                document.getElementById('cash_payment').style.display = 'none';
            }
        });
    </script>";
}

// Proses checkout
if (isset($_POST['submit_checkout'])) {
    $payment_method = $_POST['payment_method'];
    $payment_receipt = NULL;

    // Simpan bukti pembayaran jika cash
    if ($payment_method == 'cash' && isset($_FILES['payment_receipt'])) {
        $payment_receipt = 'uploads/' . basename($_FILES['payment_receipt']['name']);
        move_uploaded_file($_FILES['payment_receipt']['tmp_name'], $payment_receipt);
    }

    // Simpan data pembayaran ke database
    $sql = "INSERT INTO pembayaran (payment_method, payment_receipt, payment_status) 
            VALUES ('$payment_method', '$payment_receipt', 'pending')";
    if ($conn->query($sql) === TRUE) {
        echo "Pembayaran berhasil diproses. Terima kasih!";
        // Mengosongkan keranjang setelah checkout
        $_SESSION['cart'] = [];
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
