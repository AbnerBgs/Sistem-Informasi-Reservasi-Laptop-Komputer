<?php
require_once 'config/koneksi.php';

$service = null;
$ticket_code = '';

if (isset($_GET['ticket_code']) && !empty(trim($_GET['ticket_code']))) {
    $ticket_code = mysqli_real_escape_string($conn, trim($_GET['ticket_code']));
    $query = "SELECT * FROM services WHERE ticket_code = '$ticket_code' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $service = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Web Service Laptop - Cek Status Servis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#C4DFDF',
                            medium: '#D2E9E9',
                            light: '#E3F4F4',
                            bg: '#F8F6F4'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-bg min-h-screen p-6 text-gray-700 flex flex-col justify-between">
    <div class="max-w-xl mx-auto w-full bg-white p-8 rounded-2xl shadow-sm border border-brand-medium my-auto">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Project Web Service Laptop</h1>
            <p class="text-sm text-gray-500 mt-1">Lacak status pengerjaan perangkat Anda secara real-time</p>
        </div>
        
        <form action="tracking.php" method="GET" class="flex gap-2 mb-6">
            <input type="text" name="ticket_code" placeholder="Masukkan Kode Tiket (Contoh: TK-20261117-XXXX)" value="<?php echo htmlspecialchars($ticket_code); ?>" 
                class="flex-1 border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark transition text-sm">
            <button type="submit" class="bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 px-5 py-2.5 rounded-lg font-semibold text-sm transition shadow-sm">
                Cari Tiket
            </button>
        </form>

        <?php if (!empty($ticket_code)): ?>
            <?php if ($service): ?>
                <div class="border border-brand-medium bg-brand-light/20 p-5 rounded-xl space-y-3 text-sm">
                    <div class="flex justify-between items-center border-b border-brand-medium/50 pb-2">
                        <span class="text-gray-500">Kode Tiket</span>
                        <span class="font-mono font-bold text-gray-800 bg-white px-2 py-0.5 rounded border border-brand-medium"><?php echo htmlspecialchars($service['ticket_code']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama Pelanggan</span>
                        <span class="font-medium text-gray-800"><?php echo htmlspecialchars($service['customer_name']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Perangkat</span>
                        <span class="font-medium text-gray-800"><?php echo htmlspecialchars($service['device_type'] . ' (' . $service['device_brand'] . ')'); ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500 block mb-1">Deskripsi Kendala</span>
                        <p class="bg-white p-2.5 rounded border border-gray-100 text-gray-700"><?php echo htmlspecialchars($service['problem_description']); ?></p>
                    </div>
                    
                    <div class="mt-4 pt-2">
                        <div class="p-3 bg-brand-medium/60 text-gray-800 rounded-lg font-semibold text-center tracking-wide">
                            STATUS: <span class="uppercase font-bold text-gray-900"><?php echo htmlspecialchars($service['status']); ?></span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-4 bg-red-50 text-red-600 rounded-lg text-center text-sm">
                    Kode tiket <strong><?php echo htmlspecialchars($ticket_code); ?></strong> tidak ditemukan. Silakan periksa kembali kode Anda.
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="mt-6 text-center border-t border-brand-light pt-4">
            <a href="index.php" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">
                ← Kembali ke Form Reservasi
            </a>
        </div>
    </div>

    <footer class="text-center text-xs text-gray-400 mt-6">
        &copy; <?php echo date('Y'); ?> Project Web Service Laptop. All rights reserved.
    </footer>
</body>
</html>