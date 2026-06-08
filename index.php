<?php
require_once '../config.php';
define('ROOT', '../');
requireAdmin();
$pageTitle = 'Admin Dashboard';

$stats = [
    'subjects'  => db()->query("SELECT COUNT(*) FROM subjects")->fetchColumn(),
    'questions' => db()->query("SELECT COUNT(*) FROM questions")->fetchColumn(),
    'users'     => db()->query("SELECT COUNT(*) FROM users WHERE is_admin=0")->fetchColumn(),
    'results'   => db()->query("SELECT COUNT(*) FROM test_results")->fetchColumn(),
];
$recentResults = db()->query("SELECT tr.*,u.name as user_name,s.name as subject_name,s.icon FROM test_results tr JOIN users u ON u.id=tr.user_id JOIN subjects s ON s.id=tr.subject_id ORDER BY tr.created_at DESC LIMIT 8")->fetchAll();
$subjects = db()->query("SELECT s.*,COUNT(q.id) as q_count FROM subjects s LEFT JOIN questions q ON q.subject_id=s.id GROUP BY s.id")->fetchAll();

$flashDelay = true;
include '../includes/header.php';

function adminNav($active) {
    $links = [
        ['index.php','🏠 Dashboard'],
        ['subjects.php','📚 Fanlar'],
        ['questions.php','❓ Savollar'],
        ['users.php','👤 Foydalanuvchilar'],
    ];
    echo '<div style="display:flex;gap:8px;margin-bottom:32px;flex-wrap:wrap">';
    foreach($links as [$url,$label]) {
        $isActive = basename($_SERVER['PHP_SELF']) === $url;
        echo '<a href="' . $url . '" class="btn ' . ($isActive ? 'btn-primary' : 'btn-secondary') . '" style="font-size:13px">' . $label . '</a>';
    }
    echo '</div>';
}
?>

<div class="container page">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <div>
      <h1 style="font-size:26px;font-weight:700;color:#0F172A">Admin Panel</h1>
      <p style="color:#64748B;font-size:14px">Platformani boshqarish</p>
    </div>
    <a href="../index.php" class="btn btn-secondary btn-sm">← Saytga qaytish</a>
  </div>

  <?php adminNav('index.php'); ?>

  <!-- STATS -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:32px">
    <?php foreach([
      ['Fanlar',$stats['subjects'],'📚','#1E3A8A','#EFF6FF'],
      ['Savollar',$stats['questions'],'❓','#059669','#ECFDF5'],
      ['Foydalanuvchilar',$stats['users'],'👤','#D97706','#FFFBEB'],
      ['Testlar',$stats['results'],'📊','#7C3AED','#F5F3FF'],
    ] as [$lbl,$val,$ico,$clr,$bg]): ?>
    <div class="card" style="padding:20px">
      <div style="display:flex;justify-content:space-between;align-items:flex-start">
        <div>
          <p style="font-size:12px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:.5px"><?= $lbl ?></p>
          <p style="font-size:30px;font-weight:700;color:#0F172A;margin-top:4px"><?= number_format($val) ?></p>
        </div>
        <div style="width:40px;height:40px;border-radius:10px;background:<?= $bg ?>;display:flex;align-items:center;justify-content:center;font-size:20px"><?= $ico ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- TEZKOR HARAKATLAR -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:32px">
    <a href="subjects.php?action=create" class="card" style="padding:16px;text-decoration:none;display:flex;align-items:center;gap:12px" class="card-hover">
      <div style="width:36px;height:36px;background:#EFF6FF;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px">➕</div>
      <div><div style="font-size:13px;font-weight:600;color:#0F172A">Yangi Fan</div><div style="font-size:12px;color:#94A3B8">Fan qo'shish</div></div>
    </a>
    <a href="questions.php?action=create" class="card" style="padding:16px;text-decoration:none;display:flex;align-items:center;gap:12px">
      <div style="width:36px;height:36px;background:#ECFDF5;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px">❓</div>
      <div><div style="font-size:13px;font-weight:600;color:#0F172A">Yangi Savol</div><div style="font-size:12px;color:#94A3B8">Savol qo'shish</div></div>
    </a>
    <a href="users.php" class="card" style="padding:16px;text-decoration:none;display:flex;align-items:center;gap:12px">
      <div style="width:36px;height:36px;background:#FFFBEB;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px">👥</div>
      <div><div style="font-size:13px;font-weight:600;color:#0F172A">Foydalanuvchilar</div><div style="font-size:12px;color:#94A3B8">Ro'yxat</div></div>
    </a>
  </div>

  <!-- FANLAR VA SO'NGI NATIJALAR -->
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start" class="two-col">
    <div class="card" style="overflow:hidden">
      <div style="padding:16px 20px;border-bottom:1px solid #F1F5F9;display:flex;justify-content:space-between;align-items:center">
        <h3 style="font-size:14px;font-weight:600;color:#0F172A">Fanlar</h3>
        <a href="subjects.php" style="font-size:12px;color:#1E3A8A;text-decoration:none;font-weight:500">Barchasini ko'r</a>
      </div>
      <?php foreach($subjects as $s): ?>
      <div style="padding:12px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #F8FAFC">
        <div style="display:flex;align-items:center;gap:10px">
          <span style="font-size:20px"><?= h($s['icon']) ?></span>
          <div>
            <div style="font-size:14px;font-weight:500;color:#0F172A"><?= h($s['name']) ?></div>
            <div style="font-size:12px;color:#94A3B8"><?= $s['q_count'] ?> savol</div>
          </div>
        </div>
        <a href="subjects.php?action=edit&id=<?= $s['id'] ?>" style="font-size:12px;color:#94A3B8;text-decoration:none;padding:4px 10px;border-radius:6px;border:1px solid #E2E8F0">Tahrir</a>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="card" style="overflow:hidden">
      <div style="padding:16px 20px;border-bottom:1px solid #F1F5F9">
        <h3 style="font-size:14px;font-weight:600;color:#0F172A">So'nggi Natijalar</h3>
      </div>
      <?php if(empty($recentResults)): ?>
      <div style="padding:32px;text-align:center;color:#94A3B8;font-size:14px">Hali natijalar yo'q</div>
      <?php else: foreach($recentResults as $r):
        $g = grade($r['score']); $gc = gradeColor($g);
      ?>
      <div style="padding:12px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #F8FAFC">
        <div>
          <div style="font-size:13px;font-weight:500;color:#0F172A"><?= h($r['user_name']) ?></div>
          <div style="font-size:12px;color:#94A3B8"><?= h($r['icon']) ?> <?= h($r['subject_name']) ?></div>
        </div>
        <div style="text-align:right">
          <div style="font-size:14px;font-weight:600;color:#0F172A"><?= $r['score'] ?>/30</div>
          <div style="font-size:13px;font-weight:700;color:<?= $gc ?>"><?= $g ?></div>
        </div>
      </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</div>

<style>
@media(max-width:768px){.two-col{grid-template-columns:1fr !important}}
</style>

<?php include '../includes/footer.php'; ?>
