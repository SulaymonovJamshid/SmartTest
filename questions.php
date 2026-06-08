<?php
require_once '../config.php';
define('ROOT', '../');
requireAdmin();

$action = $_GET['action'] ?? 'list';
$msg = '';
$subjects = db()->query("SELECT * FROM subjects ORDER BY name")->fetchAll();

// O'chirish
if($action==='delete' && isset($_GET['id'])) {
    db()->prepare("DELETE FROM questions WHERE id=?")->execute([(int)$_GET['id']]);
    flash('success', 'Savol o\'chirildi.');
    header('Location: questions.php'); exit;
}

// Saqlash
if($_SERVER['REQUEST_METHOD']==='POST') {
    $subjectId = (int)($_POST['subject_id'] ?? 0);
    $qtext  = trim($_POST['question_text'] ?? '');
    $oa = trim($_POST['option_a'] ?? '');
    $ob = trim($_POST['option_b'] ?? '');
    $oc = trim($_POST['option_c'] ?? '');
    $od = trim($_POST['option_d'] ?? '');
    $correct = $_POST['correct_option'] ?? '';
    $diff = (int)($_POST['difficulty'] ?? 1);

    if(!$subjectId || !$qtext || !$oa || !$ob || !$oc || !$od || !in_array($correct,['a','b','c','d'])) {
        $msg = 'Barcha maydonlarni to\'ldiring.';
    } else {
        if(!empty($_POST['id'])) {
            db()->prepare("UPDATE questions SET subject_id=?,question_text=?,option_a=?,option_b=?,option_c=?,option_d=?,correct_option=?,difficulty=? WHERE id=?")->execute([$subjectId,$qtext,$oa,$ob,$oc,$od,$correct,$diff,(int)$_POST['id']]);
            flash('success', 'Savol yangilandi.');
        } else {
            db()->prepare("INSERT INTO questions (subject_id,question_text,option_a,option_b,option_c,option_d,correct_option,difficulty) VALUES (?,?,?,?,?,?,?,?)")->execute([$subjectId,$qtext,$oa,$ob,$oc,$od,$correct,$diff]);
            flash('success', 'Savol qo\'shildi.');
        }
        header('Location: questions.php'); exit;
    }
}

// Filter
$filterSubject = (int)($_GET['subject_id'] ?? 0);
$filterDiff    = (int)($_GET['difficulty'] ?? 0);
$page = max(1,(int)($_GET['page'] ?? 1));
$perPage = 20;

$where = []; $params = [];
if($filterSubject) { $where[] = 'q.subject_id=?'; $params[] = $filterSubject; }
if($filterDiff)    { $where[] = 'q.difficulty=?';  $params[] = $filterDiff; }
$whereStr = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$total = db()->prepare("SELECT COUNT(*) FROM questions q $whereStr");
$total->execute($params);
$total = $total->fetchColumn();
$pages = ceil($total / $perPage);
$offset = ($page - 1) * $perPage;

$stmt = db()->prepare("SELECT q.*,s.name as subject_name FROM questions q JOIN subjects s ON s.id=q.subject_id $whereStr ORDER BY q.id DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$questions = $stmt->fetchAll();

$editQ = null;
if($action==='edit' && isset($_GET['id'])) {
    $st = db()->prepare("SELECT * FROM questions WHERE id=?");
    $st->execute([(int)$_GET['id']]);
    $editQ = $st->fetch();
}

$pageTitle = 'Savollar';
$flashDelay = true;
include '../includes/header.php';
?>
<div class="container page">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <div>
      <h1 style="font-size:26px;font-weight:700;color:#0F172A">Savollar</h1>
      <p style="color:#64748B;font-size:14px">Savol bankini boshqarish — jami <?= $total ?> ta savol</p>
    </div>
    <div style="display:flex;gap:8px">
      <a href="index.php" class="btn btn-secondary btn-sm">← Dashboard</a>
      <a href="?action=create" class="btn btn-primary btn-sm">➕ Yangi Savol</a>
    </div>
  </div>

  <?php if($action==='create' || $action==='edit'): ?>
  <div class="card" style="padding:28px;margin-bottom:28px">
    <h3 style="font-size:16px;font-weight:600;color:#0F172A;margin-bottom:20px">
      <?= $action==='edit' ? 'Savolni Tahrirlash' : 'Yangi Savol Qo\'shish' ?>
    </h3>
    <?php if($msg): ?><div class="alert alert-error"><?= h($msg) ?></div><?php endif; ?>
    <form method="POST">
      <?php if($editQ): ?><input type="hidden" name="id" value="<?= $editQ['id'] ?>"><?php endif; ?>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div class="form-group">
          <label class="form-label">Fan *</label>
          <select name="subject_id" class="form-select" required>
            <option value="">Fan tanlang...</option>
            <?php foreach($subjects as $s): ?>
            <option value="<?= $s['id'] ?>" <?= ($editQ['subject_id']??'')==$s['id']?'selected':'' ?>><?= h($s['icon']) ?> <?= h($s['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Qiyinlik *</label>
          <select name="difficulty" class="form-select">
            <option value="1" <?= ($editQ['difficulty']??1)==1?'selected':'' ?>>🟢 Oson (1)</option>
            <option value="2" <?= ($editQ['difficulty']??0)==2?'selected':'' ?>>🟡 O'rta (2)</option>
            <option value="3" <?= ($editQ['difficulty']??0)==3?'selected':'' ?>>🔴 Qiyin (3)</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Savol matni *</label>
        <textarea name="question_text" class="form-textarea" placeholder="Savolingizni yozing..." required><?= h($editQ['question_text']??'') ?></textarea>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
        <?php foreach(['a','b','c','d'] as $opt): ?>
        <div class="form-group">
          <label class="form-label">
            <span style="display:inline-flex;width:22px;height:22px;background:#1E3A8A;color:#fff;font-size:11px;font-weight:700;border-radius:5px;align-items:center;justify-content:center;margin-right:6px"><?= strtoupper($opt) ?></span>
            Variant <?= strtoupper($opt) ?> *
          </label>
          <input type="text" name="option_<?= $opt ?>" class="form-input" placeholder="Variant <?= strtoupper($opt) ?>" value="<?= h($editQ['option_'.$opt]??'') ?>" required>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="form-group">
        <label class="form-label">To'g'ri javob *</label>
        <div style="display:flex;gap:12px">
          <?php foreach(['a','b','c','d'] as $opt): ?>
          <label style="display:flex;align-items:center;gap:6px;cursor:pointer">
            <input type="radio" name="correct_option" value="<?= $opt ?>" <?= ($editQ['correct_option']??'')===$opt?'checked':'' ?> required>
            <span style="width:30px;height:30px;border:2px solid #E2E8F0;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#64748B"><?= strtoupper($opt) ?></span>
          </label>
          <?php endforeach; ?>
        </div>
      </div>
      <div style="display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><?= $action==='edit' ? 'Saqlash' : 'Qo\'shish' ?></button>
        <a href="questions.php" class="btn btn-secondary">Bekor qilish</a>
      </div>
    </form>
  </div>
  <?php endif; ?>

  <!-- FILTER -->
  <form method="GET" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap">
    <select name="subject_id" class="form-select" style="width:auto" onchange="this.form.submit()">
      <option value="">Barcha fanlar</option>
      <?php foreach($subjects as $s): ?>
      <option value="<?= $s['id'] ?>" <?= $filterSubject==$s['id']?'selected':'' ?>><?= h($s['icon']) ?> <?= h($s['name']) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="difficulty" class="form-select" style="width:auto" onchange="this.form.submit()">
      <option value="">Barcha darajalar</option>
      <option value="1" <?= $filterDiff==1?'selected':'' ?>>🟢 Oson</option>
      <option value="2" <?= $filterDiff==2?'selected':'' ?>>🟡 O'rta</option>
      <option value="3" <?= $filterDiff==3?'selected':'' ?>>🔴 Qiyin</option>
    </select>
    <?php if($filterSubject||$filterDiff): ?>
    <a href="questions.php" class="btn btn-secondary btn-sm" style="align-self:center">✕ Tozalash</a>
    <?php endif; ?>
  </form>

  <div class="card" style="overflow:hidden;margin-bottom:16px">
    <table class="table">
      <thead><tr>
        <th>Savol</th><th>Fan</th><th>Qiyinlik</th><th>Javob</th><th></th>
      </tr></thead>
      <tbody>
      <?php if(empty($questions)): ?>
      <tr><td colspan="5" style="text-align:center;padding:40px;color:#94A3B8">Savollar topilmadi. <a href="?action=create" style="color:#1E3A8A">Qo'shish</a>.</td></tr>
      <?php else: foreach($questions as $q): ?>
      <tr>
        <td style="max-width:320px">
          <p style="font-size:14px;font-weight:500;color:#0F172A;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical"><?= h($q['question_text']) ?></p>
        </td>
        <td style="font-size:13px;color:#64748B;white-space:nowrap"><?= h($q['subject_name']) ?></td>
        <td>
          <span class="badge <?= ['','badge-easy','badge-medium','badge-hard'][$q['difficulty']] ?>">
            <?= diffLabel($q['difficulty']) ?>
          </span>
        </td>
        <td>
          <span style="width:26px;height:26px;background:#1E3A8A;color:#fff;font-size:12px;font-weight:700;border-radius:6px;display:inline-flex;align-items:center;justify-content:center">
            <?= strtoupper($q['correct_option']) ?>
          </span>
        </td>
        <td>
          <div style="display:flex;gap:6px">
            <a href="?action=edit&id=<?= $q['id'] ?>" class="btn btn-secondary btn-sm">Tahrir</a>
            <a href="?action=delete&id=<?= $q['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Savolni o\'chirasizmi?')">O'chir</a>
          </div>
        </td>
      </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <!-- PAGINATION -->
  <?php if($pages > 1): ?>
  <div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap">
    <?php for($i=1;$i<=$pages;$i++): ?>
    <a href="?page=<?= $i ?>&subject_id=<?= $filterSubject ?>&difficulty=<?= $filterDiff ?>" class="btn <?= $i==$page?'btn-primary':'btn-secondary' ?> btn-sm"><?= $i ?></a>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
