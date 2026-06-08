<?php
require_once '../config.php';
define('ROOT', '../');
requireAdmin();

$action = $_GET['action'] ?? 'list';
$msg = '';

// O'chirish
if($action==='delete' && isset($_GET['id'])) {
    db()->prepare("DELETE FROM subjects WHERE id=?")->execute([(int)$_GET['id']]);
    flash('success', 'Fan o\'chirildi.');
    header('Location: subjects.php'); exit;
}

// Yaratish / Yangilash
if($_SERVER['REQUEST_METHOD']==='POST') {
    $name = trim($_POST['name'] ?? '');
    $icon = trim($_POST['icon'] ?? '📚');
    $desc = trim($_POST['description'] ?? '');
    if(!$name) { $msg = 'Fan nomini kiriting.'; }
    else {
        if(!empty($_POST['id'])) {
            db()->prepare("UPDATE subjects SET name=?,icon=?,description=? WHERE id=?")->execute([$name,$icon,$desc,(int)$_POST['id']]);
            flash('success', 'Fan yangilandi.');
        } else {
            db()->prepare("INSERT INTO subjects (name,icon,description) VALUES (?,?,?)")->execute([$name,$icon,$desc]);
            flash('success', 'Fan qo\'shildi.');
        }
        header('Location: subjects.php'); exit;
    }
}

$subjects = db()->query("SELECT s.*,COUNT(q.id) as q_count, SUM(q.difficulty=1) as easy_q, SUM(q.difficulty=2) as medium_q, SUM(q.difficulty=3) as hard_q FROM subjects s LEFT JOIN questions q ON q.subject_id=s.id GROUP BY s.id ORDER BY s.id")->fetchAll();

$editSubject = null;
if($action==='edit' && isset($_GET['id'])) {
    $st = db()->prepare("SELECT * FROM subjects WHERE id=?");
    $st->execute([(int)$_GET['id']]);
    $editSubject = $st->fetch();
}

$pageTitle = 'Fanlar';
$flashDelay = true;
include '../includes/header.php';
?>
<div class="container page">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <div>
      <h1 style="font-size:26px;font-weight:700;color:#0F172A">Fanlar</h1>
      <p style="color:#64748B;font-size:14px">Fan kategoriyalarini boshqarish</p>
    </div>
    <div style="display:flex;gap:8px">
      <a href="index.php" class="btn btn-secondary btn-sm">← Dashboard</a>
      <a href="?action=create" class="btn btn-primary btn-sm">➕ Yangi Fan</a>
    </div>
  </div>

  <?php if($action==='create' || $action==='edit'): ?>
  <div class="card" style="padding:28px;max-width:500px;margin-bottom:28px">
    <h3 style="font-size:16px;font-weight:600;color:#0F172A;margin-bottom:20px">
      <?= $action==='edit' ? 'Fanni Tahrirlash' : 'Yangi Fan Qo\'shish' ?>
    </h3>
    <?php if($msg): ?><div class="alert alert-error"><?= h($msg) ?></div><?php endif; ?>
    <form method="POST">
      <?php if($editSubject): ?><input type="hidden" name="id" value="<?= $editSubject['id'] ?>"><?php endif; ?>
      <div class="form-group">
        <label class="form-label">Fan nomi *</label>
        <input type="text" name="name" class="form-input" placeholder="Matematika" value="<?= h($editSubject['name'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Belgi (emoji)</label>
        <input type="text" name="icon" class="form-input" placeholder="📚" maxlength="10" value="<?= h($editSubject['icon'] ?? '📚') ?>">
      </div>
      <div class="form-group">
        <label class="form-label">Tavsif</label>
        <textarea name="description" class="form-textarea" placeholder="Fan haqida qisqacha..."><?= h($editSubject['description'] ?? '') ?></textarea>
      </div>
      <div style="display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><?= $action==='edit' ? 'Saqlash' : 'Qo\'shish' ?></button>
        <a href="subjects.php" class="btn btn-secondary">Bekor qilish</a>
      </div>
    </form>
  </div>
  <?php endif; ?>

  <div class="card" style="overflow:hidden">
    <table class="table">
      <thead><tr>
        <th>Fan</th><th>Savollar</th><th>Qiyinlik</th><th>Holat</th><th></th>
      </tr></thead>
      <tbody>
      <?php foreach($subjects as $s): ?>
      <tr>
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <span style="font-size:22px"><?= h($s['icon']) ?></span>
            <div>
              <div style="font-weight:600;color:#0F172A"><?= h($s['name']) ?></div>
              <div style="font-size:12px;color:#94A3B8;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h($s['description'] ?? '') ?></div>
            </div>
          </div>
        </td>
        <td><span style="font-weight:600"><?= (int)$s['q_count'] ?></span> <span style="color:#94A3B8;font-size:12px">jami</span></td>
        <td>
          <div style="display:flex;gap:5px;flex-wrap:wrap">
            <span class="badge badge-easy"><?= (int)$s['easy_q'] ?> O</span>
            <span class="badge badge-medium"><?= (int)$s['medium_q'] ?> O'</span>
            <span class="badge badge-hard"><?= (int)$s['hard_q'] ?> Q</span>
          </div>
        </td>
        <td>
          <?php if($s['q_count']>=30): ?>
          <span style="background:#ECFDF5;color:#065F46;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">✓ Tayyor</span>
          <?php else: ?>
          <span style="background:#FFFBEB;color:#92400E;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600">⚠ Kam</span>
          <?php endif; ?>
        </td>
        <td>
          <div style="display:flex;gap:6px">
            <a href="?action=edit&id=<?= $s['id'] ?>" class="btn btn-secondary btn-sm">Tahrir</a>
            <a href="?action=delete&id=<?= $s['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?= h($s['name']) ?> fani va barcha savollarini o\'chirasizmi?')">O'chir</a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
