<?php
require 'koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_plain = $_POST['password'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    // Validasi sederhana
    if (empty($username) || empty($password_plain) || empty($foto)) {
        echo "Semua kolom harus diisi!";
    } else {
        // Hash password
        $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

        // Upload foto ke folder uploads/
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto);
        move_uploaded_file($tmp, $target_file);

        // Simpan ke database
        $sql = "INSERT INTO users (username, password, foto) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password_hashed, $foto);

       if ($stmt->execute()) {
            // Redirect ke dashboard setelah berhasil
            header("Location: dashboard.php");
            exit();
        } else {
            echo "❌ Gagal menambahkan user: " . $stmt->error;
        }
    }
}
?>

<!-- Form Tambah User -->
<h2>Tambah User</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Foto Profil:</label><br>
    <input type="file" name="foto" accept="image/*" required><br><br>

    <button type="submit">Tambah</button>
</form>