<!DOCTYPE html>
<html lang="uz">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?? 'SmartTest' ?> — SmartTest</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'DM Sans',sans-serif;background:#F8FAFC;color:#0F172A;min-height:100vh}
h1,h2,h3,h4{font-family:'Sora',sans-serif}

/* NAV */
.nav{background:#fff;border-bottom:1px solid #E2E8F0;position:sticky;top:0;z-index:100;padding:0 24px}
.nav-inner{max-width:1200px;margin:0 auto;height:64px;display:flex;align-items:center;justify-content:space-between;gap:16px}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo-icon{width:34px;height:34px;background:#1E3A8A;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;flex-shrink:0}
.nav-logo span{font-family:'Sora',sans-serif;font-weight:700;font-size:18px;color:#1E3A8A;letter-spacing:-0.3px}
.nav-links{display:flex;align-items:center;gap:24px}
.nav-links a{text-decoration:none;font-size:14px;font-weight:500;color:black;transition:color .2s}
.nav-links a:hover{color:blue}
.nav-links .admin-link{color:#D97706;font-weight:600}
.btn{display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;border:none;cursor:pointer;transition:all .2s}
.btn-primary{background:#1E3A8A;color:#fff}
.btn-primary:hover{background:#1D4ED8;box-shadow:0 4px 12px rgba(30,58,138,.25)}
.btn-secondary{background:#fff;color:#334155;border:1.5px solid #E2E8F0}
.btn-secondary:hover{background:#F8FAFC}
.btn-danger{background:#DC2626;color:#fff}
.btn-danger:hover{background:#B91C1C}
.btn-sm{padding:6px 14px;font-size:13px;border-radius:8px}

/* ALERTS */
.alert{padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.alert-success{background:#ECFDF5;border:1px solid #6EE7B7;color:#065F46}
.alert-error{background:#FEF2F2;border:1px solid #FECACA;color:#7F1D1D}
.alert-info{background:#EFF6FF;border:1px solid #BFDBFE;color:#1E3A8A}

/* CARDS */
.card{background:#fff;border-radius:18px;border:1px solid #E2E8F0;box-shadow:0 1px 3px rgba(0,0,0,.06)}
.card-hover{transition:all .2s}
.card-hover:hover{box-shadow:0 8px 24px rgba(0,0,0,.1);transform:translateY(-2px)}

/* FORM */
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:6px}
.form-input,.form-select,.form-textarea{width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14px;font-family:'DM Sans',sans-serif;color:#0F172A;background:#fff;transition:border-color .2s,box-shadow .2s;outline:none}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:#1E3A8A;box-shadow:0 0 0 3px rgba(30,58,138,.1)}
.form-textarea{resize:vertical;min-height:90px}

/* BADGES */
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600}
.badge-easy{background:#ECFDF5;color:#065F46;border:1px solid #6EE7B7}
.badge-medium{background:#FFFBEB;color:#92400E;border:1px solid #FCD34D}
.badge-hard{background:#FEF2F2;color:#7F1D1D;border:1px solid #FCA5A5}

/* TABLE */
.table{width:100%;border-collapse:collapse;font-size:14px}
.table th{text-align:left;padding:12px 16px;font-size:12px;font-weight:600;color:#64748B;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #E2E8F0}
.table td{padding:13px 16px;border-bottom:1px solid #F1F5F9;color:#334155;vertical-align:middle}
.table tr:hover td{background:#F8FAFC}
.table tr:last-child td{border-bottom:none}

/* CONTAINER */
.container{max-width:1200px;margin:0 auto;padding:0 24px}
.page{padding:40px 0 80px}

/* PROGRESS BAR */
.progress-bar-wrap{height:4px;background:#E2E8F0;border-radius:4px;overflow:hidden}
.progress-bar-fill{height:100%;background:#1E3A8A;border-radius:4px;transition:width .6s cubic-bezier(.4,0,.2,1)}

/* FLASH */
.fixed-top{position:fixed;top:72px;left:50%;transform:translateX(-50%);z-index:200;min-width:320px;max-width:520px}
</style>
</head>
<body>

<nav class="nav">
  <div class="nav-inner">
    <a href="<?= ROOT ?>index.php" class="nav-logo">
      <div class="nav-logo-icon">✓</div>
      <span>SmartTest</span>
    </a>
    <div class="nav-links">
      <a href="<?= ROOT ?>index.php">Fanlar</a>
      <?php if(isLoggedIn()): ?>
        <?php if(isAdmin()): ?>
          <a href="<?= ROOT ?>admin/" class="admin-link">Admin Panel</a>
        <?php endif; ?>
        <a href="<?= ROOT ?>logout.php" class="btn btn-secondary btn-sm">Chiqish</a>
      <?php else: ?>
        <a href="<?= ROOT ?>login.php">Kirish</a>
        <a href="<?= ROOT ?>register.php" class="btn btn-primary btn-sm">Ro'yxatdan o'tish</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<?php
$s = getFlash('success');
$e = getFlash('error');
if($s): ?>
<div class="fixed-top"><div class="alert alert-success">✓ <?= h($s) ?></div></div>
<?php endif;
if($e): ?>
<div class="fixed-top"><div class="alert alert-error">✗ <?= h($e) ?></div></div>
<?php endif; ?>
