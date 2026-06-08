<?php
require_once 'config.php';
define('ROOT', '');
requireLogin();

$action = $_GET['action'] ?? (isset($_GET['start']) ? 'start' : 'question');
if(isset($_GET['start'])) $action = 'start';

// ─── TEST BOSHLASH ────────────────────────────────────────────
if($action === 'start') {
    $subjectId = (int)($_GET['start'] ?? 0);
    $subject = db()->prepare("SELECT * FROM subjects WHERE id=?");
    $subject->execute([$subjectId]);
    $subject = $subject->fetch();
    if(!$subject) redirect('index.php');

    $qCount = db()->prepare("SELECT COUNT(*) FROM questions WHERE subject_id=?");
    $qCount->execute([$subjectId]);
    if($qCount->fetchColumn() < 10) {
        flash('error', 'Bu fanda yetarli savollar yo\'q.');
        redirect('index.php');
    }

    // Eski sessiyani o'chirish
    db()->prepare("DELETE FROM test_sessions WHERE user_id=? AND subject_id=?")->execute([$_SESSION['user_id'], $subjectId]);

    // Yangi sessiya
    $stmt = db()->prepare("INSERT INTO test_sessions (user_id,subject_id,current_difficulty,question_number,correct_count,answered_ids,answers_log,started_at) VALUES (?,?,1,1,0,'[]','[]',NOW())");
    $stmt->execute([$_SESSION['user_id'], $subjectId]);
    $sessionId = db()->lastInsertId();

    redirect("test.php?session=$sessionId");
}

// ─── SESSIYANI YUKLASH ────────────────────────────────────────
$sessionId = (int)($_GET['session'] ?? $_POST['session'] ?? 0);
$sess = db()->prepare("SELECT ts.*, s.name as subject_name, s.icon FROM test_sessions ts JOIN subjects s ON s.id=ts.subject_id WHERE ts.id=? AND ts.user_id=?");
$sess->execute([$sessionId, $_SESSION['user_id']]);
$sess = $sess->fetch();
if(!$sess) redirect('index.php');

$answeredIds = json_decode($sess['answered_ids'] ?: '[]', true);
$answersLog  = json_decode($sess['answers_log']  ?: '[]', true);

// ─── JAVOB QABUL QILISH ──────────────────────────────────────
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionId = (int)($_POST['question_id'] ?? 0);
    $chosen     = $_POST['answer'] ?? '';

    if(!in_array($chosen, ['a','b','c','d']) || !$questionId) redirect("test.php?session=$sessionId");

    $q = db()->prepare("SELECT * FROM questions WHERE id=?");
    $q->execute([$questionId]);
    $q = $q->fetch();
    if(!$q) redirect("test.php?session=$sessionId");

    $correct = ($chosen === $q['correct_option']);

    // Keyingi qiyinlik
    $nextDiff = $correct
        ? min(3, $sess['current_difficulty'] + 1)
        : max(1, $sess['current_difficulty'] - 1);

    $answeredIds[] = $questionId;
    $answersLog[]  = [
        'q_id'       => $questionId,
        'chosen'     => $chosen,
        'correct'    => $correct,
        'difficulty' => (int)$q['difficulty'],
        'correct_opt'=> $q['correct_option'],
    ];

    $nextNum = $sess['question_number'] + 1;
    $newCorrect = $sess['correct_count'] + ($correct ? 1 : 0);

    db()->prepare("UPDATE test_sessions SET current_difficulty=?,question_number=?,correct_count=?,answered_ids=?,answers_log=? WHERE id=?")->execute([
        $nextDiff, $nextNum, $newCorrect,
        json_encode($answeredIds, JSON_UNESCAPED_UNICODE),
        json_encode($answersLog,  JSON_UNESCAPED_UNICODE),
        $sessionId
    ]);

    // 30 savol tugadimi?
    if($nextNum > 30) {
        // Natijani saqlash
        $easy   = count(array_filter($answersLog, fn($a) => $a['difficulty']==1 && $a['correct']));
        $medium = count(array_filter($answersLog, fn($a) => $a['difficulty']==2 && $a['correct']));
        $hard   = count(array_filter($answersLog, fn($a) => $a['difficulty']==3 && $a['correct']));
        $timeTaken = time() - strtotime($sess['started_at']);

        $ins = db()->prepare("INSERT INTO test_results (user_id,subject_id,score,easy_correct,medium_correct,hard_correct,time_taken) VALUES (?,?,?,?,?,?,?)");
        $ins->execute([$_SESSION['user_id'], $sess['subject_id'], $newCorrect, $easy, $medium, $hard, $timeTaken]);
        $resultId = db()->lastInsertId();

        db()->prepare("DELETE FROM test_sessions WHERE id=?")->execute([$sessionId]);
        redirect("test.php?result=$resultId");
    }

    // Feedback
    redirect("test.php?session=$sessionId&feedback=1&correct=" . ($correct?1:0) . "&ca=" . urlencode($q['correct_option']) . "&qnum=" . ($nextNum-1));
}

// ─── NATIJA SAHIFASI ─────────────────────────────────────────
if(isset($_GET['result'])) {
    $resultId = (int)$_GET['result'];
    $result = db()->prepare("SELECT tr.*,s.name as subject_name,s.icon FROM test_results tr JOIN subjects s ON s.id=tr.subject_id WHERE tr.id=? AND tr.user_id=?");
    $result->execute([$resultId, $_SESSION['user_id']]);
    $result = $result->fetch();
    if(!$result) redirect('index.php');

    $g  = grade($result['score']);
    $gc = gradeColor($g);
    $pct = round($result['score']/30*100, 1);
    $min = floor($result['time_taken']/60);
    $sec = $result['time_taken'] % 60;

    $pageTitle = 'Test Yakunlandi';
    include 'includes/header.php';
    ?>
    <div class="container page" style="max-width:640px">
      <div style="text-align:center;margin-bottom:32px">
        <p style="font-size:13px;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">
          <?= h($result['icon']) ?> <?= h($result['subject_name']) ?>
        </p>
        <h1 style="font-size:30px;font-weight:700;color:#0F172A">Test Yakunlandi</h1>
        <p style="color:#64748B;font-size:14px;margin-top:6px">Natijalaringiz</p>
      </div>

      <!-- SCORE CARD -->
      <div class="card" style="overflow:hidden;margin-bottom:20px">
        <div style="background:#1E3A8A;padding:32px;text-align:center">
          <div style="display:flex;align-items:center;justify-content:center;gap:32px;flex-wrap:wrap">
            <!-- Donut -->
            <div style="position:relative;width:110px;height:110px">
              <svg viewBox="0 0 36 36" style="width:110px;height:110px;transform:rotate(-90deg)">
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="3"/>
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="3"
                  stroke-dasharray="<?= $pct ?> <?= 100-$pct ?>" stroke-linecap="round"/>
              </svg>
              <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center">
                <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:22px;color:#fff"><?= $g ?></div>
              </div>
            </div>
            <div style="text-align:left">
              <div style="font-size:52px;font-weight:700;color:#fff;line-height:1"><?= $result['score'] ?><span style="font-size:22px;font-weight:400;color:rgba(255,255,255,.6)">/30</span></div>
              <div style="color:rgba(255,255,255,.7);font-size:14px;margin-top:4px"><?= $pct ?>% to'g'ri</div>
              <?php if($result['time_taken']): ?>
              <div style="color:rgba(255,255,255,.5);font-size:12px;margin-top:4px">⏱ <?= $min ?>m <?= $sec ?>s</div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- BREAKDOWN -->
        <div style="padding:24px">
          <h3 style="font-size:12px;font-weight:600;color:#94A3B8;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Qiyinlik bo'yicha natijalar</h3>
          <?php foreach([['Oson','easy_correct','#059669'],["O'rta",'medium_correct','#D97706'],['Qiyin','hard_correct','#DC2626']] as [$lbl,$col,$clr]): ?>
          <div style="margin-bottom:14px">
            <div style="display:flex;justify-content:space-between;margin-bottom:6px">
              <span style="font-size:14px;font-weight:500;color:#334155"><?= $lbl ?></span>
              <span style="font-size:14px;color:#64748B"><?= $result[$col] ?> ta to'g'ri</span>
            </div>
            <div class="progress-bar-wrap">
              <div class="progress-bar-fill" style="width:<?= $result[$col]>0 ? min(100,round($result[$col]/max(1,$result['score']+1)*100)):0 ?>%;background:<?= $clr ?>"></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- XULOSA -->
        <div style="padding:0 24px 24px">
          <?php
          $msg = match(true) {
              $pct>=90 => ['#ECFDF5','#065F46','🏆 Ajoyib! Ushbu fan bo\'yicha yuqori bilim namoyish etdingiz.'],
              $pct>=70 => ['#EFF6FF','#1E3A8A','👍 Yaxshi ish! Mustahkam bilimlarga egasiz.'],
              $pct>=50 => ['#FFFBEB','#92400E','📖 O\'rtacha natija. Materialni takrorlang va qayta topshiring.'],
              default  => ['#FEF2F2','#7F1D1D','💡 Ko\'proq mashq kerak. O\'qishni davom eting.'],
          };
          ?>
          <div style="background:<?= $msg[0] ?>;color:<?= $msg[1] ?>;padding:14px 16px;border-radius:12px;font-size:14px">
            <?= $msg[2] ?>
          </div>
        </div>
      </div>

      <div style="display:flex;gap:12px">
        <a href="test.php?start=<?= $result['subject_id'] ?>" class="btn btn-primary" style="flex:1;justify-content:center;padding:13px">↺ Qayta Topshirish</a>
        <a href="index.php" class="btn btn-secondary" style="flex:1;justify-content:center;padding:13px">⊞ Barcha Fanlar</a>
      </div>
    </div>
    <?php
    include 'includes/footer.php';
    exit;
}

// ─── FEEDBACK SAHIFASI ───────────────────────────────────────
if(isset($_GET['feedback'])) {
    $wasCorrect = $_GET['correct'] == '1';
    $correctAns = strtoupper($_GET['ca'] ?? '');
    $qNum = (int)($_GET['qnum'] ?? 0);

    $pageTitle = $wasCorrect ? "To'g'ri!" : "Noto'g'ri";
    include 'includes/header.php';
    ?>
    <div style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:40px 20px">
      <div style="width:100%;max-width:420px;text-align:center">

        <div style="width:80px;height:80px;border-radius:50%;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;
          background:<?= $wasCorrect ? '#ECFDF5' : '#FEF2F2' ?>;
          border:2px solid <?= $wasCorrect ? '#6EE7B7' : '#FECACA' ?>">
          <span style="font-size:36px"><?= $wasCorrect ? '✓' : '✗' ?></span>
        </div>

        <h2 style="font-size:26px;font-weight:700;color:<?= $wasCorrect ? '#059669' : '#DC2626' ?>;margin-bottom:8px">
          <?= $wasCorrect ? "To'g'ri!" : "Noto'g'ri" ?>
        </h2>

        <?php if(!$wasCorrect): ?>
        <p style="color:#64748B;font-size:14px;margin-bottom:16px">To'g'ri javob:</p>
        <div style="display:inline-flex;align-items:center;gap:10px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;padding:10px 20px;margin-bottom:20px">
          <span style="width:28px;height:28px;background:#1E3A8A;color:#fff;font-size:13px;font-weight:700;border-radius:7px;display:flex;align-items:center;justify-content:center"><?= $correctAns ?></span>
          <span style="font-size:14px;color:#334155">Variant <?= $correctAns ?></span>
        </div>
        <?php else: ?>
        <p style="color:#64748B;font-size:14px;margin-bottom:20px">Keyingi savol qiyinroq bo'ladi.</p>
        <?php endif; ?>

        <div class="card" style="padding:16px;margin-bottom:24px">
          <div style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:8px">
            <span style="color:#64748B">Keyingi savol</span>
            <span style="font-weight:600;color:#0F172A"><?= ($qNum+1) ?> / 30</span>
          </div>
          <div class="progress-bar-wrap">
            <div class="progress-bar-fill" style="width:<?= round($qNum/30*100) ?>%"></div>
          </div>
        </div>

        <a href="test.php?session=<?= $sessionId ?>" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px">
          Davom etish →
        </a>
      </div>
    </div>
    <?php
    include 'includes/footer.php';

    // Auto-redirect
    echo "<script>setTimeout(()=>location.href='test.php?session=$sessionId',2500)</script>";
    exit;
}

// ─── SAVOL SAHIFASI ──────────────────────────────────────────
if($sess['question_number'] > 30) redirect('index.php');

// Keyingi savolni olish
$answeredIds = json_decode($sess['answered_ids'] ?: '[]', true);
$placeholders = count($answeredIds) ? implode(',', array_fill(0, count($answeredIds), '?')) : '0';

$sql = "SELECT * FROM questions WHERE subject_id=? AND difficulty=? AND id NOT IN ($placeholders) ORDER BY RAND() LIMIT 1";
$params = array_merge([$sess['subject_id'], $sess['current_difficulty']], $answeredIds);
$qstmt = db()->prepare($sql);
$qstmt->execute($params);
$question = $qstmt->fetch();

// Fallback — boshqa qiyinlikdan
if(!$question) {
    foreach([1,2,3] as $d) {
        if($d == $sess['current_difficulty']) continue;
        $sql2 = "SELECT * FROM questions WHERE subject_id=? AND difficulty=? AND id NOT IN ($placeholders) ORDER BY RAND() LIMIT 1";
        $q2 = db()->prepare($sql2);
        $q2->execute($params);
        $question = $q2->fetch();
        if($question) break;
    }
}
if(!$question) redirect('index.php');

$progress = round(($sess['question_number']-1)/30*100);
$pageTitle = 'Savol ' . $sess['question_number'];
include 'includes/header.php';
?>

<!-- PROGRESS BAR -->
<div style="position:fixed;top:64px;left:0;right:0;z-index:50;height:4px;background:#E2E8F0">
  <div style="height:100%;background:#1E3A8A;transition:width .6s;width:<?= $progress ?>%"></div>
</div>

<div class="container page" style="max-width:680px;padding-top:56px">

  <!-- META -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <div>
      <p style="font-size:12px;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:.5px">
        <?= h($sess['icon']) ?> <?= h($sess['subject_name']) ?>
      </p>
      <p style="font-size:14px;font-weight:600;color:#334155;margin-top:2px">
        Savol <?= $sess['question_number'] ?> / 30
      </p>
    </div>
    <div style="display:flex;gap:10px;align-items:center">
      <!-- Qiyinlik -->
      <div style="display:flex;align-items:center;gap:6px;background:#fff;border:1px solid #E2E8F0;border-radius:10px;padding:8px 12px">
        <?php for($i=1;$i<=3;$i++): ?>
        <div style="width:8px;height:8px;border-radius:50%;background:<?= $i<=$question['difficulty'] ? diffColor($question['difficulty']) : '#E2E8F0' ?>"></div>
        <?php endfor; ?>
        <span style="font-size:12px;font-weight:500;color:#64748B;margin-left:4px"><?= diffLabel($question['difficulty']) ?></span>
      </div>
      <!-- Ball -->
      <div style="background:#fff;border:1px solid #E2E8F0;border-radius:10px;padding:8px 14px;text-align:center">
        <div style="font-size:18px;font-weight:700;color:#1E3A8A;line-height:1"><?= $sess['correct_count'] ?></div>
        <div style="font-size:11px;color:#94A3B8">to'g'ri</div>
      </div>
    </div>
  </div>

  <!-- STEPS -->
  <div style="display:flex;gap:3px;margin-bottom:28px">
    <?php for($i=1;$i<=30;$i++): ?>
    <div style="flex:1;height:4px;border-radius:2px;background:<?= $i<$sess['question_number'] ? '#1E3A8A' : ($i==$sess['question_number'] ? '#93C5FD' : '#E2E8F0') ?>"></div>
    <?php endfor; ?>
  </div>

  <!-- SAVOL CARD -->
  <div class="card">
    <div style="padding:24px 24px 0">
      <p style="font-size:17px;font-weight:600;color:#0F172A;line-height:1.6">
        <?= $sess['question_number'] ?>. <?= h($question['question_text']) ?>
      </p>
    </div>

    <form method="POST" id="answerForm" style="padding:20px 24px 24px">
      <input type="hidden" name="session" value="<?= $sessionId ?>">
      <input type="hidden" name="question_id" value="<?= $question['id'] ?>">

      <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px">
        <?php foreach(['a','b','c','d'] as $opt): ?>
        <label style="display:flex;align-items:flex-start;gap:14px;padding:14px 16px;border:2px solid #E2E8F0;border-radius:14px;cursor:pointer;transition:all .15s;background:#fff" class="opt-label" id="lbl-<?= $opt ?>">
          <input type="radio" name="answer" value="<?= $opt ?>" style="display:none" onchange="selectOpt('<?= $opt ?>')">
          <span style="width:32px;height:32px;flex-shrink:0;border:2px solid #CBD5E1;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#64748B;transition:all .15s" id="opt-<?= $opt ?>">
            <?= strtoupper($opt) ?>
          </span>
          <span style="font-size:15px;color:#334155;padding-top:4px;line-height:1.5"><?= h($question['option_' . $opt]) ?></span>
        </label>
        <?php endforeach; ?>
      </div>

      <button type="submit" id="submitBtn" disabled class="btn btn-primary" style="width:100%;justify-content:center;padding:13px;opacity:.35;cursor:not-allowed">
        Javobni Tasdiqlash →
      </button>
    </form>
  </div>

  <p style="text-align:center;font-size:13px;color:#94A3B8;margin-top:16px">
    To'g'ri javob keyingi savolni qiyinlashtiradi
  </p>
</div>

<style>
.opt-label:hover{border-color:#93C5FD;background:#F8FAFC}
.opt-label.selected{border-color:#1E3A8A;background:#EFF6FF}
.opt-label.selected span[id^="opt-"]{background:#1E3A8A;border-color:#1E3A8A;color:#fff}
</style>
<script>
function selectOpt(opt) {
  document.querySelectorAll('.opt-label').forEach(l => l.classList.remove('selected'));
  document.getElementById('lbl-' + opt).classList.add('selected');
  const btn = document.getElementById('submitBtn');
  btn.disabled = false;
  btn.style.opacity = '1';
  btn.style.cursor = 'pointer';
}
document.getElementById('answerForm').addEventListener('submit', function() {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.textContent = 'Yuborilmoqda...';
});
</script>

<?php include 'includes/footer.php'; ?>
