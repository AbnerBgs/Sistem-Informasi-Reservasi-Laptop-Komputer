<?php
require_once __DIR__ . '/config/koneksi.php';
$categories = $conn->query("SELECT * FROM categories ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semoga Nyala - Solusi Perbaikan Laptop & PC Tanpa Ribet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { dark: '#C4DFDF', medium: '#D2E9E9', light: '#E3F4F4', bg: '#F8F6F4' }
                    }
                }
            }
        }
    </script>
    <style>
        body { transition: background-color 0.3s ease, color 0.3s ease; }
    </style>
</head>
<body id="main-body" class="bg-brand-bg text-gray-700 dark:bg-slate-900 dark:text-slate-200 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-slate-800 border-b border-brand-medium dark:border-slate-700 px-6 py-4 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="index.php" class="font-bold text-lg text-gray-800 dark:text-white flex items-center gap-2">
                <span>Semoga Nyala</span>
                <span class="bg-brand-dark text-gray-800 text-xs px-2.5 py-1 rounded-md">Service Laptop</span>
            </a>
            <div class="flex items-center gap-5 text-sm">
                <a href="#layanan" class="hover:text-gray-900 dark:hover:text-white hidden sm:inline">Layanan</a>
                <a href="#reservasi" class="hover:text-gray-900 dark:hover:text-white hidden sm:inline">Reservasi</a>
                <a href="tracking.php" class="hover:text-gray-900 dark:hover:text-white">Cek Status Tiket</a>
                <button id="btn-tema" type="button" class="bg-brand-light dark:bg-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium">
                    Mode Gelap
                </button>
                <a href="admin/login.php" class="bg-brand-dark text-gray-800 font-semibold px-3.5 py-1.5 rounded-lg hover:bg-[#b0d2d2] transition">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="py-16 px-6 text-center max-w-3xl mx-auto">
        <span class="inline-block bg-brand-light dark:bg-slate-800 text-xs font-semibold tracking-wider uppercase px-3 py-1 rounded-full mb-4">
            Cepat • Transparan • Terpercaya
        </span>
        <h1 class="text-3xl md:text-5xl font-bold text-gray-800 dark:text-white leading-tight">
            Solusi Perbaikan Laptop & PC Tanpa Ribet
        </h1>
        <p class="mt-4 text-gray-600 dark:text-slate-400">
            Reservasi servis secara online dari rumah, dapatkan kode tiket unik, dan pantau progres perbaikan perangkat Anda secara real-time.
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="#reservasi" class="bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-semibold px-6 py-3 rounded-xl transition">
                Buat Reservasi Sekarang
            </a>
            <a href="tracking.php" class="bg-white dark:bg-slate-800 border border-brand-medium dark:border-slate-700 font-semibold px-6 py-3 rounded-xl hover:bg-brand-light/40 transition">
                Lacak Status Servis →
            </a>
        </div>
    </header>

    <!-- Layanan -->
    <section id="layanan" class="py-12 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Layanan Kami</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Penanganan profesional untuk berbagai jenis kerusakan perangkat</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-brand-medium dark:border-slate-700 shadow-sm">
                <span class="inline-block bg-brand-light text-gray-800 font-bold text-xs px-2.5 py-1 rounded-md mb-3">01</span>
                <h3 class="font-bold text-gray-800 dark:text-white mb-2">Perbaikan Hardware</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Ganti LCD, keyboard, baterai, engsel patah, hingga perbaikan motherboard mati total.</p>
            </div>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-brand-medium dark:border-slate-700 shadow-sm">
                <span class="inline-block bg-brand-light text-gray-800 font-bold text-xs px-2.5 py-1 rounded-md mb-3">02</span>
                <h3 class="font-bold text-gray-800 dark:text-white mb-2">Install Ulang & Software</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Instalasi Windows/macOS, aplikasi pendukung kerja, pembersihan virus, dan optimasi sistem.</p>
            </div>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-brand-medium dark:border-slate-700 shadow-sm">
                <span class="inline-block bg-brand-light text-gray-800 font-bold text-xs px-2.5 py-1 rounded-md mb-3">03</span>
                <h3 class="font-bold text-gray-800 dark:text-white mb-2">Upgrade & Maintenance</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">Upgrade RAM & SSD untuk performa maksimal serta pembersihan debu & ganti thermal paste.</p>
            </div>
        </div>
    </section>

    <!-- Form Reservasi -->
    <section id="reservasi" class="py-12 px-6 max-w-2xl mx-auto">
        <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-brand-medium dark:border-slate-700 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-1">Form Reservasi Servis</h2>
            <p class="text-xs text-gray-500 dark:text-slate-400 mb-6">Lengkapi data di bawah ini untuk mendapatkan nomor tiket antrean.</p>

            <form id="form-reservasi" action="proses/simpan_reservasi.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Nama Lengkap</label>
                        <input type="text" name="customer_name" id="customer_name" required placeholder="Contoh: Budi Santoso"
                               class="w-full border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2.5 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Nomor WhatsApp</label>
                        <input type="text" name="customer_phone" id="customer_phone" required placeholder="081234567890"
                               class="w-full border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2.5 rounded-lg text-sm">
                        <p id="error-phone" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Jenis Perangkat</label>
                        <select name="device_type" required class="w-full border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2.5 rounded-lg text-sm">
                            <option value="Laptop">Laptop</option>
                            <option value="PC / Komputer">PC / Komputer</option>
                            <option value="MacBook">MacBook</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Merk & Tipe</label>
                        <input type="text" name="device_brand" required placeholder="Contoh: Asus ROG / Lenovo ThinkPad"
                               class="w-full border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2.5 rounded-lg text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Kategori Layanan</label>
                    <select name="category_id" required class="w-full border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2.5 rounded-lg text-sm">
                        <?php while ($cat = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $cat['id']; ?>">
                                <?php echo htmlspecialchars($cat['category_name'] . ' (' . $cat['estimated_cost'] . ')'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Detail Keluhan / Kerusakan</label>
                    <textarea name="problem_description" rows="3" required placeholder="Jelaskan kendala perangkat Anda..."
                              class="w-full border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2.5 rounded-lg text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Foto Kondisi Perangkat (Opsional - JPG/PNG)</label>
                    <input type="file" name="damage_photo" id="damage_photo" accept="image/*"
                           class="w-full text-xs border border-gray-200 dark:border-slate-600 bg-brand-light/20 dark:bg-slate-700 p-2 rounded-lg">
                    <p id="file-info" class="text-xs text-emerald-600 mt-1 hidden"></p>
                </div>

                <button type="submit" class="w-full bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-bold py-3 rounded-xl transition">
                    Kirim Reservasi & Konfirmasi WA
                </button>
            </form>
        </div>
    </section>

    <footer class="text-center text-xs text-gray-400 py-8 border-t border-brand-medium dark:border-slate-800 mt-12">
        &copy; 2026 Semoga Nyala - Project Web Service Laptop
    </footer>

    <script>
        const btnTema = document.querySelector("#btn-tema");
        const htmlEl  = document.documentElement;
        
        // toggle mode
        btnTema.addEventListener("click", function () {
            htmlEl.classList.toggle("dark");
            btnTema.textContent = htmlEl.classList.contains("dark") ? "Mode Terang" : "Mode Gelap";
        });

        const formReservasi = document.querySelector("#form-reservasi");
        const inputPhone    = document.querySelector("#customer_phone");
        const errorPhone    = document.querySelector("#error-phone");
        
        // validasi nomor wa 
        inputPhone.addEventListener("input", function () {
            const val = inputPhone.value.trim();
            if (val !== "" && (!/^[0-9]+$/.test(val) || val.length < 10)) {
                errorPhone.textContent = "Nomor WA harus berupa angka minimal 10 digit.";
                errorPhone.classList.remove("hidden");
            } else {
                errorPhone.classList.add("hidden");
            }
        });

        formReservasi.addEventListener("submit", function (e) {
            const val = inputPhone.value.trim();
            if (!/^[0-9]+$/.test(val) || val.length < 10) {
                e.preventDefault();
                errorPhone.textContent = "Periksa kembali nomor WhatsApp Anda sebelum mengirim!";
                errorPhone.classList.remove("hidden");
                inputPhone.focus();
            }
        });

        // preview nama file foto
        const inputFoto = document.querySelector("#damage_photo");
        const fileInfo  = document.querySelector("#file-info");

        inputFoto.addEventListener("change", function () {
            if (inputFoto.files.length > 0) {
                fileInfo.textContent = `File siap diunggah: ${inputFoto.files[0].name}`;
                fileInfo.classList.remove("hidden");
            } else {
                fileInfo.classList.add("hidden");
            }
        });
    </script>
</body>
</html>