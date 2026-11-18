<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' LIMIT 1");
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            $_SESSION['admin_id']   = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = 'Email atau password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Project Web Service Laptop</title>
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
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-sm border border-brand-medium">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Login</h1>
            <p class="text-sm text-gray-500 mt-1">Project Web Service Laptop</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4 text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" required placeholder="........"
                    class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required placeholder="........"
                    class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark">
            </div>
            <button type="submit" class="w-full bg-brand-dark hover:bg-[#b0d2d2] text-gray-800 font-semibold py-2.5 rounded-lg transition">
                Masuk Dashboard
            </button>
        </form>

        <div class="mt-6 text-center border-t border-brand-light pt-4">
            <a href="../index.php" class="text-xs text-gray-500 hover:text-gray-800">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>