<?php
// Memulai sesi
session_start();

// Memeriksa apakah pengguna telah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perpustakaan";

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk membaca semua buku
function readBooks($conn) {
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk menambahkan buku
function createBook($conn, $title, $author, $category, $published_year) {
    $sql = "INSERT INTO books (title, author, category, published_year) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $author, $category, $published_year);
    return $stmt->execute();
}

// Fungsi untuk memperbarui buku
function updateBook($conn, $id, $title, $author, $category, $published_year) {
    $sql = "UPDATE books SET title=?, author=?, category=?, published_year=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $title, $author, $category, $published_year, $id);
    return $stmt->execute();
}

// Fungsi untuk menghapus buku
function deleteBook($conn, $id) {
    $sql = "DELETE FROM books WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Handle Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $published_year = $_POST['published_year'];
    createBook($conn, $title, $author, $category, $published_year);
}

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $published_year = $_POST['published_year'];
    updateBook($conn, $id, $title, $author, $category, $published_year);
}

// Handle Delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    deleteBook($conn, $id);
}

$books = readBooks($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi - Perpustakaan Bersama</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>Perpustakaan Bersama</h1>
    </header>
    <nav>
        <ul>
            <li><a href="beranda.php">Beranda</a></li>
            <li><a href="layanan.php">Layanan</a></li>
            <li><a href="koleksi.php">Koleksi</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <aside>
            <h2>Kategori Buku</h2>
            <ul>
                <li><a href="kategori/fiksi.php"><i class="fas fa-book"></i> Fiksi</a></li>
                <li><a href="kategori/non-fiksi.php"><i class="fas fa-book-open"></i> Non-Fiksi</a></li>
                <li><a href="kategori/anak.php"><i class="fas fa-child"></i> Anak</a></li>
                <li><a href="kategori/remaja.php"><i class="fas fa-user-graduate"></i> Remaja</a></li>
                <li><a href="kategori/dewasa.php"><i class="fas fa-user"></i> Dewasa</a></li>
            </ul>
        </aside>
        <main>
            <h2>Koleksi Buku</h2>
            <form method="post" action="koleksi.php">
                <h3>Tambah Buku Baru</h3>
                <input type="text" name="title" placeholder="Judul Buku" required>
                <input type="text" name="author" placeholder="Penulis" required>
                <select name="category" required>
                    <option value="Fiksi">Fiksi</option>
                    <option value="Non-Fiksi">Non-Fiksi</option>
                    <option value="Anak">Anak</option>
                    <option value="Remaja">Remaja</option>
                    <option value="Dewasa">Dewasa</option>
                </select>
                <input type="number" name="published_year" placeholder="Tahun Terbit" required>
                <button type="submit" name="create">Tambah Buku</button>
            </form>
            <hr>
            <h3>Daftar Buku</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo $book['id']; ?></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['author']; ?></td>
                        <td><?php echo $book['category']; ?></td>
                        <td><?php echo $book['published_year']; ?></td>
                        <td>
                            <form method="post" action="koleksi.php" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                                <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
                                <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
                                <select name="category" required>
                                    <option value="Fiksi" <?php if ($book['category'] == 'Fiksi') echo 'selected'; ?>>Fiksi</option>
                                    <option value="Non-Fiksi" <?php if ($book['category'] == 'Non-Fiksi') echo 'selected'; ?>>Non-Fiksi</option>
                                    <option value="Anak" <?php if ($book['category'] == 'Anak') echo 'selected'; ?>>Anak</option>
                                    <option value="Remaja" <?php if ($book['category'] == 'Remaja') echo 'selected'; ?>>Remaja</option>
                                    <option value="Dewasa" <?php if ($book['category'] == 'Dewasa') echo 'selected'; ?>>Dewasa</option>
                                </select>
                                <input type="number" name="published_year" value="<?php echo $book['published_year']; ?>" required>
                                <button type="submit" name="update">Update</button>
                            </form>
                            <form method="post" action="koleksi.php" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Perpustakaan Bersama. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
