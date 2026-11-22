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
    $allowed_statuses = ['pending', 'proses', 'selesai', 'diambil'];

    if (in_array($status, $allowed_statuses, true)) {
        $stmt = $conn->prepare("SELECT status FROM services WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result && $result['status'] !== $status) {
            $conn->begin_transaction();

            $update = $conn->prepare("UPDATE services SET status = ? WHERE id = ?");
            $update->bind_param("si", $status, $id);
            $update->execute();
            $update->close();

            $admin_id = (int) $_SESSION['admin_id'];
            $history = $conn->prepare("INSERT INTO service_status_history (service_id, status, changed_by) VALUES (?, ?, ?)");
            $history->bind_param("isi", $id, $status, $admin_id);
            $history->execute();
            $history->close();

            $conn->commit();
        }
    }
}

header("Location: ../admin/dashboard.php");
exit;
?>