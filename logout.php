<?php
// Memulai sesi
session_start();

// Menghancurkan semua data sesi
session_destroy();

// Redirect ke halaman login
header("Location: index.php");
exit();
?>
