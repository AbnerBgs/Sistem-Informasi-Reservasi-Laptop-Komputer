<?php
require_once __DIR__ . '/../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name       = trim($_POST['customer_name']);
    $customer_phone      = trim($_POST['customer_phone']);
    $category_id         = (int) $_POST['category_id'];
    $device_type         = trim($_POST['device_type']);
    $device_brand        = trim($_POST['device_brand']);
    $problem_description = trim($_POST['problem_description']);
    $status              = 'pending';

    $ticket_code = 'TK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

    $damage_photo = null;
    if (isset($_FILES['damage_photo']) && $_FILES['damage_photo']['error'] === UPLOAD_ERR_OK) {
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['damage_photo']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowedExt)) {
            $newFileName = $ticket_code . '.' . $ext;
            $uploadDir   = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            if (move_uploaded_file($_FILES['damage_photo']['tmp_name'], $uploadDir . $newFileName)) {
                $damage_photo = $newFileName;
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO services (ticket_code, customer_name, customer_phone, category_id, device_type, device_brand, problem_description, damage_photo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssss", $ticket_code, $customer_name, $customer_phone, $category_id, $device_type, $device_brand, $problem_description, $damage_photo, $status);

    if ($stmt->execute()) {
        $stmt->close();
        $adminWA = '6282310276459';
        $message = "Halo Admin Semoga Nyala, saya ingin konfirmasi reservasi servis:\n\n"
                 . "*No. Tiket:* $ticket_code\n"
                 . "*Nama:* $customer_name\n"
                 . "*Perangkat:* $device_type ($device_brand)\n"
                 . "*Kendala:* $problem_description";

        header("Location: https://wa.me/{$adminWA}?text=" . urlencode($message));
        exit;
    } else {
        echo "Gagal menyimpan data: " . $conn->error;
    }
}
?>