<?php
session_start();
require 'koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['user'] = $result;
        header("Location: dashboard.php");
        exit(); // Tambahkan ini agar tidak lanjut eksekusi
    } else {
        $error = "Login gagal! Username atau password salah.";
    }
}
?>

<!-- Form Login -->
<h2>Login</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>