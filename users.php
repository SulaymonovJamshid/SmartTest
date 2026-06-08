<?php
require_once '../config.php';
define('ROOT', '../');
requireAdmin();

$users = db()->query("SELECT u.*, COUNT(tr.id) as test_count FROM users u LEFT JOIN test_results tr ON tr.user_id=u.id WHERE u.is_admin=0 GROUP BY u.id ORDER BY u.created_at DESC")->fetchAll();

$pageTitle = 'Foydalanuvchilar';
include '../includes/header.php';
?>
<div class="container page">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <div>
      <h1 style="font-size:26px;font-weight:700;color:#0F172A">Foydalanuvchilar</h1>
      <p style="color:#64748B;font-size:14px">Barcha ro'yxatdan o'tgan foydalanuvchilar — jami <?= count($users) ?> ta</p>
    </div>
    <a href="index.php" class="btn btn-secondary btn-sm">← Dashboard</a>
  </div>

  <div class="card" style="overflow:hidden">
    <table class="table">
      <thead><tr>
        <th>Ism</th><th>Email</th><th>Testlar</th><th>Qo'shilgan</th>
      </tr></thead>
      <tbody>
      <?php if(empty($users)): ?>
      <tr><td colspan="4" style="text-align:center;padding:40px;color:#94A3B8">Hali foydalanuvchilar yo'q</td></tr>
      <?php else: foreach($users as $u): ?>
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:34px;height:34px;background:#EFF6FF;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#1E3A8A;font-size:13px">
              <?= strtoupper(mb_substr($u['name'],0,2)) ?>
            </div>
            <span style="font-weight:500;color:#0F172A"><?= h($u['name']) ?></span>
          </div>
        </td>
        <td style="color:#64748B;font-size:13px"><?= h($u['email']) ?></td>
        <td>
          <span style="font-weight:600;color:#0F172A"><?= $u['test_count'] ?></span>
          <span style="color:#94A3B8;font-size:12px"> test</span>
        </td>
        <td style="color:#94A3B8;font-size:13px"><?= date('d.m.Y', strtotime($u['created_at'])) ?></td>
      </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
