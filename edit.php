<?php
include 'koneksi/db.php';

$id = $_GET['id'];

// Mengambil data user berdasarkan ID
$result = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    // Cek apakah password diubah
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Update username dan password
        $conn->query("UPDATE users SET username='$username', password='$password' WHERE id=$id");
    } else {
        // Update hanya username jika password tidak diubah
        $conn->query("UPDATE users SET username='$username' WHERE id=$id");
    }

    // Redirect ke dashboard setelah berhasil
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit User</title>
</head>
<body class="container py-5">
    <h2>Edit User</h2>
    <form method="POST">
        <div class="mb-2">
            <label>username</label>
            <input type="text" username="username" class="form-control" value="<?= $user['username'] ?>" required>
        </div>
        
        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</body>
</html>