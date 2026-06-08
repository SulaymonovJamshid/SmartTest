<?php
require_once 'config.php';
define('ROOT', '');
if(isLoggedIn()) redirect('index.php');

$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if($email && $pass) {
        $stmt = db()->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin']  = $user['is_admin'];
            flash('success', 'Xush kelibsiz, ' . $user['name'] . '!');
            redirect($user['is_admin'] ? 'admin/' : 'index.php');
        } else {
            $error = 'Email yoki parol noto\'g\'ri.';
        }
    } else {
        $error = 'Barcha maydonlarni to\'ldiring.';
    }
}

$pageTitle = 'Kirish';
$flashDelay = true;
include 'includes/header.php';
?>

<div style="min-height:75vh;display:flex;align-items:center;justify-content:center;padding:40px 20px">
  <div style="width:100%;max-width:420px">
    <div style="text-align:center;margin-bottom:32px">
      <div style="width:56px;height:56px;background:#1E3A8A;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:26px;color:#fff;margin:0 auto 16px">✓</div>
      <h1 style="font-size:26px;font-weight:700;color:#0F172A">Xush kelibsiz</h1>
      <p style="color:#64748B;font-size:14px;margin-top:6px">O'rganish safaringizni davom ettirish uchun kiring</p>
    </div>

    <div class="card" style="padding:28px">
      <?php if($error): ?>
      <div class="alert alert-error"><?= h($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label class="form-label">Email manzil</label>
          <input type="email" name="email" class="form-input" placeholder="siz@example.com" value="<?= h($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Parol</label>
          <input type="password" name="password" class="form-input" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:12px">Kirish</button>
      </form>
    </div>

    <p style="text-align:center;font-size:14px;color:#64748B;margin-top:20px">
      Hisobingiz yo'qmi? <a href="register.php" style="color:#1E3A8A;font-weight:600;text-decoration:none">Ro'yxatdan o'ting</a>
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
