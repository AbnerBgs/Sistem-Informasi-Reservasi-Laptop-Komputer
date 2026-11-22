<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$saved_email = $_COOKIE['remember_admin_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $isValid = password_verify($password, $user['password']) || ($password === $user['password']);

        if ($isValid) {
            if ($password === $user['password']) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $upd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $upd->bind_param("si", $hashed, $user['id']);
                $upd->execute();
                $upd->close();
            }

            if (isset($_POST['remember_me'])) {
                setcookie("remember_admin_email", $email, time() + (86400 * 7), "/");
            } else {
                setcookie("remember_admin_email", "", time() - 3600, "/");
            }

            $_SESSION['admin_id']   = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $stmt->close();
    $error = 'Email atau password salah!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Semoga Nyala</title>
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
            <h1 class="text-2xl font-bold text-gray-800">Login Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Semoga Nyala - Service Laptop</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4 text-center">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" required placeholder="......@example.com"
                       value="<?php echo htmlspecialchars($saved_email); ?>"
                       class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required placeholder="......"
                       class="w-full border border-gray-200 bg-brand-light/30 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember_me" id="remember_me" <?php echo $saved_email ? 'checked' : ''; ?> class="rounded">
                <label for="remember_me" class="text-xs text-gray-600">Ingat email saya (Cookie 7 hari)</label>
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