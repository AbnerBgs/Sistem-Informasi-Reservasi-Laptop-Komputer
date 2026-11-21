<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$statuses = [
    'pending' => 'Antrean Masuk (Pending)',
    'proses'  => 'Sedang Dikerjakan (Proses)',
    'selesai' => 'Selesai Servis',
    'diambil' => 'Sudah Diambil'
];

$services_by_status = ['pending' => [], 'proses' => [], 'selesai' => [], 'diambil' => []];

$sql = "SELECT services.*, categories.category_name 
        FROM services 
        LEFT JOIN categories ON services.category_id = categories.id 
        ORDER BY services.created_at DESC";
$query = $conn->query($sql);

while ($row = $query->fetch_assoc()) {
    $services_by_status[$row['status']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Semoga Nyala</title>
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
<body class="bg-brand-bg min-h-screen text-gray-700">
    <nav class="bg-white border-b border-brand-medium px-6 py-4 flex justify-between items-center">
        <div>
            <h1 class="font-bold text-lg text-gray-800">Dashboard Servis Admin - Semoga Nyala</h1>
            <p class="text-xs text-gray-500">Halo, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></p>
        </div>
        <div class="flex items-center gap-4">
            <a href="../index.php" target="_blank" class="text-sm text-gray-600 hover:underline">Lihat Web</a>
            <a href="logout.php" class="bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium px-4 py-2 rounded-lg transition">Logout</a>
        </div>
    </nav>

    <main class="p-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ($statuses as $key => $label): ?>
                <div class="bg-brand-light/50 border border-brand-medium rounded-2xl p-4 flex flex-col">
                    <div class="flex justify-between items-center mb-4 pb-2 border-b border-brand-medium">
                        <h2 class="font-bold text-sm text-gray-800"><?php echo $label; ?></h2>
                        <span class="bg-white text-xs font-bold px-2.5 py-0.5 rounded-full border border-brand-medium">
                            <?php echo count($services_by_status[$key]); ?>
                        </span>
                    </div>

                    <div class="space-y-3 flex-1">
                        <?php foreach ($services_by_status[$key] as $item): ?>
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-brand-medium/70 space-y-2 text-sm">
                                <div class="flex justify-between items-start">
                                    <span class="font-mono text-xs font-bold bg-brand-light px-2 py-0.5 rounded text-gray-800">
                                        <?php echo htmlspecialchars($item['ticket_code']); ?>
                                    </span>
                                    <a href="../proses/hapus_tiket.php?id=<?php echo $item['id']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus tiket ini?')"
                                       class="text-xs text-red-400 hover:text-red-600">Hapus</a>
                                </div>

                                <div>
                                    <p class="font-bold text-gray-800"><?php echo htmlspecialchars($item['customer_name']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($item['device_type'] . ' - ' . $item['device_brand']); ?></p>
                                    
                                    <?php if (!empty($item['category_name'])): ?>
                                        <span class="inline-block mt-1 text-[11px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded">
                                            <?php echo htmlspecialchars($item['category_name']); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php 
                                        $wa_pelanggan = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $item['customer_phone']));
                                        $pesan_admin  = urlencode("Halo " . $item['customer_name'] . ", update servis tiket *" . $item['ticket_code'] . "* dari Semoga Nyala: status perangkat kamu saat ini *" . strtoupper($item['status']) . "*.");
                                    ?>
                                    <a href="https://wa.me/<?php echo $wa_pelanggan; ?>?text=<?php echo $pesan_admin; ?>" 
                                       target="_blank" 
                                       class="inline-flex items-center gap-1 mt-1 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-0.5 rounded-md transition">
                                        <span>WA: <?php echo htmlspecialchars($item['customer_phone']); ?></span>
                                    </a>
                                </div>

                                <p class="text-xs bg-brand-bg p-2 rounded text-gray-600">
                                    <?php echo htmlspecialchars($item['problem_description']); ?>
                                </p>

                                <?php if (!empty($item['damage_photo'])): ?>
                                    <a href="../uploads/<?php echo htmlspecialchars($item['damage_photo']); ?>" target="_blank" class="block">
                                        <img src="../uploads/<?php echo htmlspecialchars($item['damage_photo']); ?>" 
                                             alt="Foto Kerusakan" 
                                             class="w-full h-28 object-cover rounded-lg border border-gray-200 hover:opacity-90 transition">
                                    </a>
                                <?php endif; ?>

                                <form action="../proses/update_status.php" method="POST" class="pt-2 flex gap-1.5">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <select name="status" class="flex-1 text-xs border border-gray-200 rounded-lg p-1.5 bg-brand-light/20">
                                        <option value="pending" <?php echo $item['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="proses" <?php echo $item['status'] == 'proses' ? 'selected' : ''; ?>>Proses</option>
                                        <option value="selesai" <?php echo $item['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                        <option value="diambil" <?php echo $item['status'] == 'diambil' ? 'selected' : ''; ?>>Diambil</option>
                                    </select>
                                    <button type="submit" class="bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-lg">
                                        Simpan
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($services_by_status[$key])): ?>
                            <p class="text-xs text-center text-gray-400 py-6">Tidak ada tiket</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>