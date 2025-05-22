<?php
require 'koneksi/db.php';

$id = $_GET['id'];

// Ambil nama file foto sebelum hapus
$sql = "SELECT foto FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$foto = $result['foto'];

// Hapus data
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Hapus foto dari folder
    if (file_exists("uploads/$foto")) {
        unlink("uploads/$foto");
    }
    echo "✅ User berhasil dihapus! <a href='dashboard.php'>Kembali</a>";
} else {
    echo "❌ Gagal menghapus user.";
}
?>