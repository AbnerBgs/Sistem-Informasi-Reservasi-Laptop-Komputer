<?php
require_once __DIR__ . '/config/koneksi.php';

$ticket = null;
$searched = false;

if (isset($_GET['kode']) && trim($_GET['kode']) !== '') {
    $searched = true;
    $kode = trim($_GET['kode']);

    $stmt = $conn->prepare("SELECT services.*, categories.category_name, categories.estimated_cost 
                            FROM services 
                            LEFT JOIN categories ON services.category_id = categories.id 
                            WHERE services.ticket_code = ? LIMIT 1");
    $stmt->bind_param("s", $kode);
    $stmt->execute();
    $ticket = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Status Servis - Semoga Nyala</title>
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
<body class="bg-brand-bg min-h-screen flex items-center justify-center p-6 text-gray-700">
    <div class="max-w-lg w-full bg-white p-8 rounded-2xl shadow-sm border border-brand-medium">
        <h1 class="text-xl font-bold text-gray-800 mb-1">Lacak Status Servis</h1>
        <p class="text-xs text-gray-500 mb-6">Masukkan kode tiket Anda (contoh: TK-20261118-7A0C)</p>

        <form method="GET" class="flex gap-2 mb-6">
            <input type="text" name="kode" required placeholder="Masukkan kode tiket..."
                   value="<?php echo isset($_GET['kode']) ? htmlspecialchars($_GET['kode']) : ''; ?>"
                   class="flex-1 border border-gray-200 bg-brand-light/20 p-2.5 rounded-lg text-sm">
            <button type="submit" class="bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-semibold px-5 py-2.5 rounded-lg text-sm">
                Cek
            </button>
        </form>

        <?php if ($searched): ?>
            <?php if ($ticket): ?>
                <div class="bg-brand-light/40 border border-brand-medium rounded-xl p-5 space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-mono font-bold text-gray-800"><?php echo htmlspecialchars($ticket['ticket_code']); ?></span>
                        <span class="bg-brand-dark text-gray-800 text-xs font-bold uppercase px-3 py-1 rounded-full">
                            <?php echo htmlspecialchars($ticket['status']); ?>
                        </span>
                    </div>
                    <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($ticket['customer_name']); ?></p>
                    <p><strong>Perangkat:</strong> <?php echo htmlspecialchars($ticket['device_type'] . ' - ' . $ticket['device_brand']); ?></p>
                    <?php if (!empty($ticket['category_name'])): ?>
                        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($ticket['category_name']); ?> (Estimasi: <?php echo htmlspecialchars($ticket['estimated_cost']); ?>)</p>
                    <?php endif; ?>
                    <p><strong>Keluhan:</strong> <?php echo htmlspecialchars($ticket['problem_description']); ?></p>
                    <?php if (!empty($ticket['damage_photo'])): ?>
                        <div class="pt-2">
                            <p class="text-xs font-semibold mb-1">Foto Kondisi Awal:</p>
                            <img src="uploads/<?php echo htmlspecialchars($ticket['damage_photo']); ?>" alt="Foto Kerusakan" class="w-full h-40 object-cover rounded-lg border">
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="bg-red-50 text-red-600 text-sm p-4 rounded-xl text-center">
                    Kode tiket tidak ditemukan. Pastikan penulisan huruf dan angka sudah benar.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="mt-6 text-center border-t border-brand-light pt-4">
            <a href="index.php" class="text-xs text-gray-500 hover:text-gray-800">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>