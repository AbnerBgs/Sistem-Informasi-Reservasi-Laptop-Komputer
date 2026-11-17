<?php
require_once __DIR__ . '/../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name       = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_phone      = mysqli_real_escape_string($conn, $_POST['customer_phone']);
    $device_type         = mysqli_real_escape_string($conn, $_POST['device_type']);
    $device_brand        = mysqli_real_escape_string($conn, $_POST['device_brand']);
    $problem_description = mysqli_real_escape_string($conn, $_POST['problem_description']);

    $ticket_code = 'TK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

    $query = "INSERT INTO services (ticket_code, customer_name, customer_phone, device_type, device_brand, problem_description, status) 
              VALUES ('$ticket_code', '$customer_name', '$customer_phone', '$device_type', '$device_brand', '$problem_description', 'pending')";

    if (mysqli_query($conn, $query)) {
        // Ganti dengan nomor WA kamu (format 628xxx)
        $adminWA = '6281234567890';
        
        $message = "Halo Admin, saya ingin konfirmasi reservasi service:\n\n"
                 . "*No. Tiket:* $ticket_code\n"
                 . "*Nama:* $customer_name\n"
                 . "*Perangkat:* $device_type ($device_brand)\n"
                 . "*Kendala:* $problem_description";

        $waUrl = "https://wa.me/{$adminWA}?text=" . urlencode($message);
        
        header("Location: $waUrl");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>