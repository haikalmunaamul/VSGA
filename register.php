<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perpustakaan";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah form registrasi telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $phone_number = $_POST['phone_number'];

    // Mencegah SQL injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $gender = stripslashes($gender);
    $phone_number = stripslashes($phone_number);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $gender = mysqli_real_escape_string($conn, $gender);
    $phone_number = mysqli_real_escape_string($conn, $phone_number);

    // Membuat hash dari password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan data pengguna ke database
    $sql = "INSERT INTO users (username, password, gender, phone_number) VALUES ('$username', '$password_hashed', '$gender', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil. Silakan <a href='login.php'>login</a>.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Form Registrasi</h2>
        <form method="post" action="">
            <label>Username:</label><br>
            <input type="text" name="username" required><br>
            <label>Password:</label><br>
            <input type="password" name="password" required><br>
            <label>Gender:</label><br>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>
            <label>Phone Number:</label><br>
            <input type="text" name="phone_number" required><br><br>
            <input type="submit" value="Register">
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p> <!-- Link untuk login -->
    </div>
</body>
</html>
