<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int) $_POST['id'];
    $status = trim($_POST['status']);

    $stmt = $conn->prepare("UPDATE services SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../admin/dashboard.php");
exit;
?>