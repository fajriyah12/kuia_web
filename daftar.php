<?php
session_start();
require 'koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $foto = $_FILES['foto']['name'];

    // Cek apakah username sudah ada
    $cek = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $hasil = $cek->get_result();

    if ($hasil->num_rows > 0) {
        $error = "Username sudah digunakan. Silakan pilih yang lain.";
    } else {
        // Upload foto
        $target = "uploads/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);

        // Insert user baru
        $stmt = $conn->prepare("INSERT INTO users (username, password, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $foto);

        if ($stmt->execute()) {
            header("Location: index.php?success=1");
            exit();
        } else {
            $error = "Gagal mendaftar: " . $stmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-box {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="register-box">
        <h4 class="text-center mb-4">Daftar Akun Baru</h4>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Foto Profil</label>
                <input type="file" name="foto" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>

        <div class="text-center mt-3">
            Sudah punya akun? <a href="index.php">Login di sini</a>
        </div>
    </div>
</body>
</html>
