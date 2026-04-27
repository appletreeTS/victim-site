<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
session_start();
// [취약] 세션 검증 없이 username GET으로도 접근 가능 (IDOR)
$username = $_SESSION['username'] ?? $_GET['user'] ?? '비로그인';
$role     = $_SESSION['role']     ?? 'user';
include 'db.php';

$accounts = [];
$res = mysqli_query($conn, "SELECT * FROM accounts WHERE owner='$username'");
if ($res) { while ($row = mysqli_fetch_assoc($res)) $accounts[] = $row; }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 마이페이지</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:700px;margin:50px auto;}
.welcome{background:linear-gradient(135deg,#1a3c6e,#2196f3);color:white;padding:30px 36px;border-radius:12px;margin-bottom:24px;}
.welcome h2{font-size:22px;margin-bottom:6px;}
.welcome p{font-size:14px;opacity:0.85;}
.badge{display:inline-block;background:rgba(255,255,255,0.2);padding:3px 12px;border-radius:20px;font-size:12px;margin-left:8px;}
.acc-card{background:white;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.08);margin-bottom:18px;overflow:hidden;}
.acc-head{background:#1a3c6e;color:white;padding:14px 20px;display:flex;justify-content:space-between;align-items:center;}
.acc-head .no{font-size:15px;font-weight:600;letter-spacing:1px;}
.acc-head .type{font-size:12px;background:rgba(255,255,255,0.18);padding:3px 10px;border-radius:20px;}
.acc-body{padding:18px 20px;display:flex;gap:50px;}
.acc-body .item label{font-size:11px;color:#888;display:block;margin-bottom:4px;}
.acc-body .item span{font-size:16px;font-weight:700;color:#1a3c6e;}
.balance{color:#2e7d32 !important;}
.empty{background:white;border-radius:12px;padding:40px;text-align:center;color:#aaa;font-size:14px;}
.back{font-size:13px;margin-top:10px;} .back a{color:#2196f3;text-decoration:none;}
footer{background:#1a3c6e;color:#aaa;text-align:center;padding:20px;font-size:13px;margin-top:40px;}
</style>
</head>
<body>
<nav>
  <div class="logo">Secure<span>Bank</span></div>
  <ul>
    <li><a href="index.php">홈</a></li><li><a href="login.php">로그인</a></li>
    <li><a href="search.php">계좌조회</a></li><li><a href="xss.php">고객센터</a></li>
    <li><a href="upload.php">서류제출</a></li><li><a href="cmd.php">네트워크진단</a></li>
  </ul>
</nav>
<div class="container">
  <div class="welcome">
    <h2>👋 환영합니다, <?= htmlspecialchars($username) ?>님
      <?php if ($role === 'admin'): ?>
        <span class="badge">관리자</span>
      <?php endif; ?>
    </h2>
    <p>보유 계좌 <?= count($accounts) ?>개</p>
  </div>

  <?php if (empty($accounts)): ?>
    <div class="empty">등록된 계좌가 없습니다.</div>
  <?php else: ?>
    <?php foreach ($accounts as $acc): ?>
    <div class="acc-card">
      <div class="acc-head">
        <span class="no"><?= $acc['account_no'] ?></span>
        <span class="type"><?= $acc['account_type'] ?></span>
      </div>
      <div class="acc-body">
        <div class="item"><label>예금주</label><span><?= $acc['owner'] ?></span></div>
        <div class="item"><label>잔액</label><span class="balance">₩<?= number_format($acc['balance']) ?></span></div>
      </div>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
