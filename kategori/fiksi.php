<?php
session_start();

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Fiksi - Perpustakaan Bersama</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>Perpustakaan Bersama</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../index.php">Beranda</a></li>
            <li><a href="#">Layanan</a></li>
            <li><a href="#">Koleksi</a></li>
            <li><a href="#">Info</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <aside>
            <h2>Kategori Buku</h2>
            <ul>
                <li><a href="fiksi.php"><i class="fas fa-book"></i> Fiksi</a></li>
                <li><a href="non-fiksi.php"><i class="fas fa-book-open"></i> Non-Fiksi</a></li>
                <li><a href="anak.php"><i class="fas fa-child"></i> Anak</a></li>
                <li><a href="remaja.php"><i class="fas fa-user-graduate"></i> Remaja</a></li>
                <li><a href="dewasa.php"><i class="fas fa-user"></i> Dewasa</a></li>
            </ul>
        </aside>
        <main>
            <h2>Kategori Fiksi</h2>
            <p>Di sini adalah koleksi buku fiksi yang tersedia di perpustakaan kami:</p>
            <ul>
                <li>Judul Buku 1</li>
                <li>Judul Buku 2</li>
                <!-- Masukkan daftar buku fiksi lainnya sesuai kebutuhan -->
            </ul>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan Bersama. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
