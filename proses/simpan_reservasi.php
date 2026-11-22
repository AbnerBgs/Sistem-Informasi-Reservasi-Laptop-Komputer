<?php
require_once __DIR__ . '/../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

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

if (!$stmt->execute()) {
    die("Gagal menyimpan data: " . $conn->error);
}
$service_id = $stmt->insert_id;
$stmt->close();

$historyStmt = $conn->prepare("INSERT INTO service_status_history (service_id, status, changed_by) VALUES (?, 'pending', NULL)");
$historyStmt->bind_param("i", $service_id);
$historyStmt->execute();
$historyStmt->close();

$adminWA = '6282310276459';
$message = "Halo Admin Semoga Nyala, saya ingin konfirmasi reservasi servis:\n\n"
         . "*No. Tiket:* $ticket_code\n"
         . "*Nama:* $customer_name\n"
         . "*Perangkat:* $device_type ($device_brand)\n"
         . "*Kendala:* $problem_description";

$waUrl = "https://wa.me/{$adminWA}?text=" . urlencode($message);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Berhasil - Semoga Nyala</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { dark: '#C4DFDF', medium: '#D2E9E9', light: '#E3F4F4', bg: '#F8F6F4' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg min-h-screen flex items-center justify-center p-4 sm:p-6 text-gray-700">
    <div class="max-w-lg w-full bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-brand-medium text-center">
        <!-- Ikon Sukses -->
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Reservasi Anda Berhasil Dibuat!</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1.5">
            Simpan nomor tiket di bawah ini untuk melacak progres perbaikan perangkat Anda secara berkala.
        </p>

        <!-- Kotak Kode Tiket + Tombol Salin -->
        <div class="mt-6 bg-brand-light/50 border border-brand-medium rounded-xl p-4">
            <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Nomor Tiket Anda</span>
            <div class="flex items-center justify-center gap-2">
                <span id="kode-tiket" class="font-mono text-lg sm:text-xl font-bold text-gray-800">
                    <?php echo htmlspecialchars($ticket_code); ?>
                </span>
                <button type="button" onclick="salinTiket()" id="btn-salin"
                        class="bg-white border border-brand-medium hover:bg-brand-light text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-lg transition">
                    Salin
                </button>
            </div>
        </div>

        <!-- Ringkasan Singkat -->
        <div class="mt-4 text-left bg-gray-50 rounded-xl p-4 text-xs sm:text-sm space-y-1.5 border border-gray-100">
            <p><span class="text-gray-500">Nama:</span> <strong><?php echo htmlspecialchars($customer_name); ?></strong></p>
            <p><span class="text-gray-500">Perangkat:</span> <strong><?php echo htmlspecialchars($device_type . ' - ' . $device_brand); ?></strong></p>
            <p><span class="text-gray-500">Keluhan:</span> <?php echo htmlspecialchars($problem_description); ?></p>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 space-y-2.5">
            <a href="<?php echo htmlspecialchars($waUrl); ?>" target="_blank" rel="noopener noreferrer"
               class="w-full flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-sm">
                <span>Kirim Reservasi ke WhatsApp Admin</span>
            </a>

            <a href="../tracking.php?kode=<?php echo urlencode($ticket_code); ?>"
               class="w-full block bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-semibold py-2.5 px-4 rounded-xl text-sm transition">
                Lacak Status Servis
            </a>
        </div>

        <div class="mt-6 pt-4 border-t border-brand-light">
            <a href="../index.php" class="text-xs text-gray-500 hover:text-gray-800">← Kembali ke Halaman Utama</a>
        </div>
    </div>

    <script>
        function salinTiket() {
            const kode = document.getElementById("kode-tiket").textContent.trim();
            const btn  = document.getElementById("btn-salin");
            navigator.clipboard.writeText(kode).then(function () {
                btn.textContent = "Tersalin!";
                setTimeout(function () {
                    btn.textContent = "Salin";
                }, 2000);
            });
        }
    </script>
</body>
</html>