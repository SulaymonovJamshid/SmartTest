<?php
require_once 'config.php';
define('ROOT', '');
if(isLoggedIn()) redirect('index.php');

$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';

    if(!$name || !$email || !$pass) {
        $error = 'Barcha maydonlarni to\'ldiring.';
    } elseif(strlen($pass) < 6) {
        $error = 'Parol kamida 6 ta belgi bo\'lishi kerak.';
    } elseif($pass !== $pass2) {
        $error = 'Parollar mos kelmadi.';
    } else {
        $check = db()->prepare("SELECT id FROM users WHERE email=?");
        $check->execute([$email]);
        if($check->fetch()) {
            $error = 'Bu email allaqachon ro\'yxatdan o\'tgan.';
        } else {
            $stmt = db()->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
            $id = db()->lastInsertId();
            $_SESSION['user_id']   = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['is_admin']  = 0;
            flash('success', 'Hisob muvaffaqiyatli yaratildi!');
            redirect('index.php');
        }
    }
}

$pageTitle = "Ro'yxatdan o'tish";
$flashDelay = true;
include 'includes/header.php';
?>

<div style="min-height:75vh;display:flex;align-items:center;justify-content:center;padding:40px 20px">
  <div style="width:100%;max-width:420px">
    <div style="text-align:center;margin-bottom:32px">
      <div style="width:56px;height:56px;background:#1E3A8A;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;color:#fff;margin:0 auto 16px">👤</div>
      <h1 style="font-size:26px;font-weight:700;color:#0F172A">Hisob yaratish</h1>
      <p style="color:#64748B;font-size:14px;margin-top:6px">Adaptiv o'rganish tajribasini boshlang</p>
    </div>

    <div class="card" style="padding:28px">
      <?php if($error): ?>
      <div class="alert alert-error"><?= h($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label class="form-label">To'liq ism</label>
          <input type="text" name="name" class="form-input" placeholder="Ism Familiya" value="<?= h($_POST['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email manzil</label>
          <input type="email" name="email" class="form-input" placeholder="siz@example.com" value="<?= h($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Parol</label>
          <input type="password" name="password" class="form-input" placeholder="Kamida 6 ta belgi" required>
        </div>
        <div class="form-group">
          <label class="form-label">Parolni tasdiqlang</label>
          <input type="password" name="password2" class="form-input" placeholder="Parolni takrorlang" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">Hisob yaratish</button>
      </form>
    </div>

    <p style="text-align:center;font-size:14px;color:#64748B;margin-top:20px">
      Hisobingiz bormi? <a href="login.php" style="color:#1E3A8A;font-weight:600;text-decoration:none">Kirish</a>
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
