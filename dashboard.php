<?php
session_start();
include 'koneksi/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        img.profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="container py-5">
    <h2>Dashboard</h2>
    <a href="tambah.php" class="btn btn-success mb-3">Tambah User</a>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

    <div class="row">
    <?php
    $result = $conn->query("SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
        $fotoPath = 'uploads/' . $row['foto'];
        if (empty($row['foto']) || !file_exists($fotoPath)) {
            $fotoPath = 'uploads/default.jpg'; 
        }

        echo "<div class='col-md-4'>
                <div class='card mb-3'>
                    <div class='card-body text-center'>
                        <img src='$fotoPath' class='profile-img' alt='Foto Profil'>
                        <h5>" . htmlspecialchars($row['username']) . "</h5>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                    </div>
                </div>
              </div>";
    }
    ?>
    </div>
</body>
</html>