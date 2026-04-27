<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';

// [취약] 권한 검증 없음 - role 체크 안 함 → 일반 유저도 접근 가능
// 올바른 코드였다면: if($_SESSION['role'] !== 'admin') { header('Location: login.php'); exit; }

$users    = [];
$accounts = [];
$txs      = [];

$res = mysqli_query($conn, "SELECT * FROM users ORDER BY id");
if ($res) { while ($row = mysqli_fetch_assoc($res)) $users[] = $row; }

$res = mysqli_query($conn, "SELECT * FROM accounts ORDER BY user_id");
if ($res) { while ($row = mysqli_fetch_assoc($res)) $accounts[] = $row; }

$res = mysqli_query($conn, "SELECT * FROM transactions ORDER BY created_at DESC LIMIT 20");
if ($res) { while ($row = mysqli_fetch_assoc($res)) $txs[] = $row; }

// 계정 삭제 기능 (추가 취약점: CSRF 무방비)
if (isset($_GET['delete_user'])) {
    $uid = (int)$_GET['delete_user'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$uid");
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 관리자 페이지</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f0f2f5;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:1000px;margin:40px auto;padding:0 20px;}
.page-title{color:#1a3c6e;font-size:22px;font-weight:700;margin-bottom:24px;display:flex;align-items:center;gap:10px;}
.badge-admin{background:#e53935;color:white;font-size:11px;padding:3px 10px;border-radius:20px;}
.section{background:white;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.08);margin-bottom:28px;overflow:hidden;}
.section-head{background:#1a3c6e;color:white;padding:14px 22px;font-size:15px;font-weight:600;}
table{width:100%;border-collapse:collapse;font-size:13px;}
th{background:#f5f7fb;padding:11px 16px;text-align:left;color:#555;font-weight:600;border-bottom:1px solid #e8eaf0;}
td{padding:11px 16px;border-bottom:1px solid #f4f4f4;color:#444;}
tr:last-child td{border-bottom:none;}
.role-admin{color:#e53935;font-weight:700;}
.role-user{color:#2196f3;}
.type-in{color:#2e7d32;font-weight:600;}
.type-out{color:#e53935;font-weight:600;}
.del-btn{color:#e53935;font-size:12px;text-decoration:none;padding:3px 10px;border:1px solid #e53935;border-radius:4px;}
.del-btn:hover{background:#e53935;color:white;}
.vuln-banner{background:#fff3e0;border-left:4px solid #ff9800;padding:12px 18px;margin-bottom:20px;border-radius:6px;font-size:13px;color:#e65100;}
.back{font-size:13px;margin-top:4px;} .back a{color:#2196f3;text-decoration:none;}
footer{background:#1a3c6e;color:#aaa;text-align:center;padding:20px;font-size:13px;margin-top:40px;}
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
  <div class="page-title">
    🛡️ 관리자 대시보드 <span class="badge-admin">ADMIN</span>
  </div>

  <!-- [취약 포인트 안내 배너] -->
  <div class="vuln-banner">
    ⚠️ [취약] 이 페이지는 세션 role 검증이 없습니다. 로그인 없이 <b>?user=admin</b> 또는 직접 URL 접근만으로 열람 가능합니다.
  </div>

  <!-- 전체 회원 목록 -->
  <div class="section">
    <div class="section-head">👥 전체 회원 목록 (비밀번호 평문 저장)</div>
    <table>
      <thead>
        <tr><th>ID</th><th>아이디</th><th>비밀번호</th><th>권한</th><th>이메일</th><th>삭제</th></tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><b><?= $u['username'] ?></b></td>
          <td style="color:#e53935;font-family:monospace;"><?= $u['password'] ?></td>
          <td class="<?= $u['role']==='admin' ? 'role-admin':'role-user' ?>"><?= $u['role'] ?></td>
          <td><?= $u['email'] ?></td>
          <!-- [취약] CSRF 무방비 GET 삭제 -->
          <td><a href="admin.php?delete_user=<?= $u['id'] ?>" class="del-btn"
                 onclick="return confirm('삭제하시겠습니까?')">삭제</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- 전체 계좌 목록 -->
  <div class="section">
    <div class="section-head">🏦 전체 계좌 목록</div>
    <table>
      <thead>
        <tr><th>계좌번호</th><th>예금주</th><th>잔액</th><th>종류</th></tr>
      </thead>
      <tbody>
        <?php foreach ($accounts as $acc): ?>
        <tr>
          <td><?= $acc['account_no'] ?></td>
          <td><?= $acc['owner'] ?></td>
          <td style="color:#2e7d32;font-weight:600;">₩<?= number_format($acc['balance']) ?></td>
          <td><?= $acc['account_type'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- 최근 거래내역 -->
  <div class="section">
    <div class="section-head">📋 최근 거래내역 (20건)</div>
    <table>
      <thead>
        <tr><th>계좌번호</th><th>구분</th><th>금액</th><th>메모</th><th>일시</th></tr>
      </thead>
      <tbody>
        <?php foreach ($txs as $tx): ?>
        <tr>
          <td><?= $tx['account_no'] ?></td>
          <td class="<?= $tx['type']==='입금' ? 'type-in':'type-out' ?>"><?= $tx['type'] ?></td>
          <td>₩<?= number_format($tx['amount']) ?></td>
          <td><?= $tx['memo'] ?></td>
          <td><?= $tx['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
