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
$query = mysqli_query($conn, "SELECT * FROM services ORDER BY created_at DESC");
while ($row = mysqli_fetch_assoc($query)) {
    $services_by_status[$row['status']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard Admin - Project Web Service Laptop</title>
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
            <h1 class="font-bold text-lg text-gray-800">Dashboard Servis Admin</h1>
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
                                </div>

                                <p class="text-xs bg-brand-bg p-2 rounded text-gray-600">
                                    <?php echo htmlspecialchars($item['problem_description']); ?>
                                </p>

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