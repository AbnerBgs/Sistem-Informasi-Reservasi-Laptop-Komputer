<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Hapus file foto jika ada
    $cek = $conn->prepare("SELECT damage_photo FROM services WHERE id = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $res = $cek->get_result()->fetch_assoc();
    $cek->close();

    if ($res && !empty($res['damage_photo'])) {
        $filePath = __DIR__ . '/../uploads/' . $res['damage_photo'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../admin/dashboard.php");
exit;
?>