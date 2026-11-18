<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Web Service Laptop - Solusi Perbaikan Laptop & PC</title>
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
<body class="bg-brand-bg text-gray-700 font-sans">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-brand-medium">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold text-gray-800 tracking-tight">
                Project Web <span class="bg-brand-dark px-2 py-0.5 rounded-md">Service Laptop</span>
            </a>
            <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                <a href="#layanan" class="hover:text-gray-900 transition">Layanan</a>
                <a href="#reservasi" class="hover:text-gray-900 transition">Reservasi</a>
                <a href="tracking.php" class="hover:text-gray-900 transition">Cek Status Tiket</a>
                <a href="admin/login.php" class="bg-brand-light hover:bg-brand-medium text-gray-800 px-4 py-2 rounded-lg transition">
                    Users
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="py-16 md:py-24 px-6 bg-gradient-to-b from-brand-light/60 to-brand-bg">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block bg-brand-medium text-gray-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                Cepat • Transparan • Terpercaya
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-800 leading-tight mb-4">
                Solusi Perbaikan Laptop & PC Tanpa Ribet
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                Reservasi servis secara online dari rumah, dapatkan kode tiket unik, dan pantau progres perbaikan perangkat Anda secara real-time.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#reservasi" class="bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-semibold px-8 py-3.5 rounded-xl shadow-sm transition">
                    Buat Reservasi Sekarang
                </a>
                <a href="tracking.php" class="bg-white hover:bg-brand-light text-gray-700 font-semibold px-8 py-3.5 rounded-xl border border-brand-medium transition">
                    Lacak Status Servis →
                </a>
            </div>
        </div>
    </header>

    <!-- SECTION LAYANAN -->
    <section id="layanan" class="py-12 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-800">Layanan Kami</h2>
            <p class="text-sm text-gray-500 mt-1">Penanganan profesional untuk berbagai jenis kerusakan perangkat</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-brand-medium shadow-sm">
                <div class="w-10 h-10 bg-brand-light rounded-lg flex items-center justify-center font-bold text-gray-800 mb-4">01</div>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Perbaikan Hardware</h3>
                <p class="text-sm text-gray-600">Ganti LCD, keyboard, baterai, engsel patah, hingga perbaikan motherboard mati total.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-brand-medium shadow-sm">
                <div class="w-10 h-10 bg-brand-light rounded-lg flex items-center justify-center font-bold text-gray-800 mb-4">02</div>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Install Ulang & Software</h3>
                <p class="text-sm text-gray-600">Instalasi Windows/macOS, aplikasi pendukung kerja, pembersihan virus, dan optimasi sistem.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-brand-medium shadow-sm">
                <div class="w-10 h-10 bg-brand-light rounded-lg flex items-center justify-center font-bold text-gray-800 mb-4">03</div>
                <h3 class="font-bold text-lg text-gray-800 mb-2">Upgrade & Maintenance</h3>
                <p class="text-sm text-gray-600">Upgrade RAM & SSD untuk performa maksimal serta pembersihan debu & ganti thermal paste.</p>
            </div>
        </div>
    </section>

    <!-- SECTION FORM RESERVASI -->
    <section id="reservasi" class="py-14 px-6">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-brand-medium">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Form Reservasi Servis</h2>
                <p class="text-sm text-gray-500 mt-1">Isi data di bawah untuk mendapatkan kode tiket & terhubung ke WhatsApp Admin</p>
            </div>
            
            <form action="proses/simpan_reservasi.php" method="POST" class="space-y-4">
                <div>
                    <label class="block font-medium text-sm mb-1">Nama Lengkap</label>
                    <input type="text" name="customer_name" required placeholder="Masukkan nama Anda"
                        class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark transition">
                </div>
                <div>
                    <label class="block font-medium text-sm mb-1">Nomor WhatsApp</label>
                    <input type="text" name="customer_phone" placeholder="08123456789" required 
                        class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-sm mb-1">Jenis Perangkat</label>
                        <select name="device_type" class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark transition">
                            <option value="Laptop">Laptop</option>
                            <option value="PC">PC / Desktop</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-sm mb-1">Merk / Spesifikasi</label>
                        <input type="text" name="device_brand" placeholder="Asus / Custom PC" required 
                            class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark transition">
                    </div>
                </div>
                <div>
                    <label class="block font-medium text-sm mb-1">Deskripsi Keluhan / Kerusakan</label>
                    <textarea name="problem_description" rows="3" placeholder="Jelaskan kendala laptop/PC Anda..." required 
                        class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark transition"></textarea>
                </div>
                <button type="submit" 
                    class="w-full bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-semibold py-3 rounded-lg shadow-sm transition duration-200 mt-2">
                    Kirim Reservasi & Hubungi WA Admin
                </button>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-brand-medium py-6 text-center text-xs text-gray-500 mt-10">
        &copy; <?php echo date('Y'); ?> Project Web Service Laptop. All rights reserved.
    </footer>

</body>
</html>