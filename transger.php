<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';

$msg   = '';
$color = '';

// [취약] CSRF - 토큰 검증 없이 POST 요청만으로 이체 실행
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_account = $_POST['from_account'] ?? '';
    $to_account   = $_POST['to_account']   ?? '';
    $amount       = (int)($_POST['amount'] ?? 0);

    if ($amount > 0 && $from_account && $to_account) {
        // 출금 계좌 잔액 확인
        $res = mysqli_query($conn, "SELECT * FROM accounts WHERE account_no='$from_account'");
        $from = $res ? mysqli_fetch_assoc($res) : null;

        if ($from && $from['balance'] >= $amount) {
            // 출금 처리
            mysqli_query($conn, "UPDATE accounts SET balance = balance - $amount WHERE account_no='$from_account'");
            // 입금 처리
            mysqli_query($conn, "UPDATE accounts SET balance = balance + $amount WHERE account_no='$to_account'");
            // 거래내역 기록
            mysqli_query($conn, "INSERT INTO transactions (account_no, type, amount, memo) VALUES ('$from_account', '출금', $amount, '인터넷이체')");
            mysqli_query($conn, "INSERT INTO transactions (account_no, type, amount, memo) VALUES ('$to_account',   '입금', $amount, '인터넷이체')");

            $msg   = "✅ 이체가 완료되었습니다. (₩" . number_format($amount) . ")";
            $color = "#2e7d32";
        } else {
            $msg   = "❌ 잔액이 부족하거나 계좌 정보가 올바르지 않습니다.";
            $color = "#e53935";
        }
    } else {
        $msg   = "❌ 입력값을 확인해주세요.";
        $color = "#e53935";
    }
}

// 로그인된 사용자 계좌 목록
$my_accounts = [];
$username = $_SESSION['username'] ?? '';
if ($username) {
    $res = mysqli_query($conn, "SELECT * FROM accounts WHERE owner='$username'");
    if ($res) { while ($row = mysqli_fetch_assoc($res)) $my_accounts[] = $row; }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 계좌이체</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:520px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input,select{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;background:white;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;font-weight:600;}
button:hover{background:#2196f3;}
.msg{padding:12px 16px;border-radius:8px;font-size:14px;margin-bottom:18px;border-left:4px solid;}
.divider{border:none;border-top:1px solid #eee;margin:20px 0;}
.acc-info{background:#f5f7ff;border-radius:8px;padding:14px 16px;margin-bottom:16px;font-size:13px;color:#444;}
.acc-info b{color:#1a3c6e;}
.back{margin-top:18px;font-size:13px;} .back a{color:#2196f3;text-decoration:none;}
footer{background:#1a3c6e;color:#aaa;text-align:center;padding:20px;font-size:13px;margin-top:60px;}
</style>
</head>
<body>
<nav>
  <div class="logo">Secure<span>Bank</span></div>
  <ul>
    <li><a href="index.php">홈</a></li><li><a href="login.php">로그인</a></li>
    <li><a href="search.php">계좌조회</a></li><li><a href="transfer.php">계좌이체</a></li>
    <li><a href="xss.php">고객센터</a></li><li><a href="upload.php">서류제출</a></li>
    <li><a href="cmd.php">네트워크진단</a></li>
  </ul>
</nav>
<div class="container">
  <h2>계좌 이체</h2>
  <p class="sub">안전하게 송금하세요</p>

  <?php if ($msg): ?>
    <div class="msg" style="color:<?= $color ?>;border-color:<?= $color ?>;background:<?= $color === '#2e7d32' ? '#f0fff4' : '#fff3f3' ?>">
      <?= $msg ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($my_accounts)): ?>
    <?php foreach ($my_accounts as $acc): ?>
    <div class="acc-info">
      <b><?= $acc['account_no'] ?></b> &nbsp;|&nbsp;
      잔액: <b>₩<?= number_format($acc['balance']) ?></b>
    </div>
    <?php endforeach; ?>
    <hr class="divider">
  <?php endif; ?>

  <!-- [취약] CSRF - 폼에 CSRF 토큰 없음 → 외부에서 위조 요청 가능 -->
  <form method="POST">
    <label>출금 계좌번호</label>
    <input type="text" name="from_account" placeholder="예) 110-123-456789">

    <label>입금 계좌번호</label>
    <input type="text" name="to_account" placeholder="예) 110-555-667788">

    <label>이체 금액 (원)</label>
    <input type="number" name="amount" placeholder="예) 100000">

    <button type="submit">이체하기</button>
  </form>
  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
