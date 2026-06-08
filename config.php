<?php
// ============================================================
// SmartTest — Konfiguratsiya
// config.php da faqat quyidagilarni o'zgartiring:
// ============================================================

define('DB_HOST',    'localhost');
define('DB_NAME',    'smarttest');
define('DB_USER',    'root');
define('DB_PASS',    '');          // <-- Parolingiz
define('DB_CHARSET', 'utf8mb4');

define('SITE_NAME', 'SmartTest');

// Session boshlash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ─── Database ulanish ────────────────────────────────────────
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST, DB_NAME, DB_CHARSET
            );
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('
<div style="font-family:system-ui;max-width:560px;margin:60px auto;padding:32px;
            background:#FEF2F2;border:1px solid #FECACA;border-radius:16px">
  <h2 style="color:#DC2626;margin:0 0 12px">❌ Database ulanmadi</h2>
  <p style="color:#7F1D1D;margin:0 0 8px">Xato: ' . htmlspecialchars($e->getMessage()) . '</p>
  <p style="color:#991B1B;margin:0;font-size:14px">
    <b>config.php</b> faylidagi DB_HOST, DB_NAME, DB_USER, DB_PASS ni tekshiring.
  </p>
</div>');
        }
    }
    return $pdo;
}

// ─── Yordamchi funksiyalar ───────────────────────────────────
function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool {
    return !empty($_SESSION['user_id']);
}

function isAdmin(): bool {
    return isLoggedIn() && !empty($_SESSION['is_admin']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        flash('error', 'Davom etish uchun tizimga kiring.');
        redirect((defined('ROOT') ? ROOT : '') . 'login.php');
    }
}

function requireAdmin(): void {
    if (!isAdmin()) {
        flash('error', 'Bu sahifaga kirish huquqingiz yo\'q.');
        redirect((defined('ROOT') ? ROOT : '') . 'index.php');
    }
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function flash(string $key, string $msg): void {
    $_SESSION['flash'][$key] = $msg;
}

function getFlash(string $key): string {
    $msg = $_SESSION['flash'][$key] ?? '';
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function grade(int $score): string {
    $pct = ($score / 30) * 100;
    if ($pct >= 90) return 'A+';
    if ($pct >= 80) return 'A';
    if ($pct >= 70) return 'B';
    if ($pct >= 60) return 'C';
    if ($pct >= 50) return 'D';
    return 'F';
}

function gradeColor(string $grade): string {
    return match($grade) {
        'A+', 'A' => '#059669',
        'B'       => '#2563EB',
        'C', 'D'  => '#D97706',
        default   => '#DC2626',
    };
}

function diffLabel(int $d): string {
    return match($d) {
        1 => 'Oson',
        2 => "O'rta",
        3 => 'Qiyin',
        default => ''
    };
}

function diffColor(int $d): string {
    return match($d) {
        1 => '#059669',
        2 => '#D97706',
        3 => '#DC2626',
        default => '#64748B'
    };
}

function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return 'Hozirgina';
    if ($diff < 3600)   return floor($diff/60) . ' daqiqa oldin';
    if ($diff < 86400)  return floor($diff/3600) . ' soat oldin';
    return date('d.m.Y', strtotime($datetime));
}
