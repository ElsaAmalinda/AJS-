<?php
session_start();
session_destroy(); // Hapus session
header("Location: login_admin.php"); // Redirect ke halaman login
exit();
?>
