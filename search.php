<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';

$results    = [];
$tx_results = [];
$searched   = false;
$error      = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searched = true;
    $keyword  = $_POST['keyword'] ?? '';

    // [취약 포인트] SQL Injection - 입력값 미검증
    $query = "SELECT * FROM accounts WHERE owner='$keyword' OR account_no='$keyword'";
    $res   = mysqli_query($conn, $query);

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $results[] = $row;
        }
        foreach ($results as $acc) {
            $acc_no   = $acc['account_no'];
            $tx_query = "SELECT * FROM transactions WHERE account_no='$acc_no' ORDER BY created_at DESC";
            $tx_res   = mysqli_query($conn, $tx_query);
            if ($tx_res) {
                while ($tx = mysqli_fetch_assoc($tx_res)) {
                    $tx_results[$acc_no][] = $tx;
                }
            }
        }
    } else {
        $error = mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>SecureBank 계좌조회</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
body { background:#f4f6f9; color:#333; }
nav { background:#1a3c6e; padding:15px 40px; display:flex; justify-content:space-between; align-items:center; }
nav .logo { color:white; font-size:22px; font-weight:700; }
nav .logo span { color:#4fc3f7; }
nav ul { list-style:none; display:flex; gap:30px; }
nav ul a { color:#ccc; text-decoration:none; font-size:14px; }
nav ul a:hover { color:white; }
.container { max-width:760px; margin:50px auto; background:white; padding:40px; border-radius:12px; box-shadow:0 2px 16px rgba(0,0,0,0.1); }
h2 { color:#1a3c6e; margin-bottom:6px; }
p.sub { color:#888; font-size:13px; margin-bottom:25px; }
.search-row { display:flex; gap:10px; margin-bottom:20px; }
.search-row input { flex:1; padding:11px 14px; border:1px solid #ddd; border-radius:8px; font-size:14px; }
.search-row button { padding:11px 28px; background:#1a3c6e; color:white; border:none; border-radius:8px; font-size:14px; cursor:pointer; }
.search-row button:hover { background:#2196f3; }
.error-box { background:#fff3f3; border-left:4px solid #e53935; padding:12px 16px; border-radius:6px; color:#c62828; font-size:13px; margin-bottom:16px; font-family:monospace; word-break:break-all; }
.no-result { color:#888; text-align:center; padding:30px 0; font-size:14px; }
.acc-card { border:1px solid #e0e6ef; border-radius:10px; margin-bottom:28px; overflow:hidden; }
.acc-header { background:#1a3c6e; color:white; padding:14px 20px; display:flex; justify-content:space-between; align-items:center; }
.acc-header .acc-no { font-size:15px; font-weight:600; letter-spacing:1px; }
.acc-header .acc-type { font-size:12px; background:rgba(255,255,255,0.18); padding:3px 10px; border-radius:20px; }
.acc-body { padding:16px 20px; display:flex; gap:50px; border-bottom:1px solid #f0f0f0; }
.acc-body .item label { font-size:11px; color:#888; display:block; margin-bottom:4px; }
.acc-body .item span { font-size:15px; font-weight:600; color:#1a3c6e; }
.acc-body .item .balance { color:#2e7d32; font-size:18px; }
.tx-table { width:100%; border-collapse:collapse; font-size:13px; }
.tx-table thead tr { background:#f5f7fb; }
.tx-table th { padding:10px 16px; text-align:left; color:#555; font-weight:600; border-bottom:1px solid #e8eaf0; }
.tx-table td { padding:10px 16px; border-bottom:1px solid #f4f4f4; }
.tx-table tr:last-child td { border-bottom:none; }
.type-in  { color:#2e7d32; font-weight:600; }
.type-out { color:#e53935; font-weight:600; }
.footer-link { margin-top:24px; font-size:13px; }
.footer-link a { color:#2196f3; text-decoration:none; }
footer { background:#1a3c6e; color:#aaa; text-align:center; padding:20px; font-size:13px; margin-top:60px; }
</style>
</head>
<body>
<nav>
  <div class="logo">Secure<span>Bank</span></div>
  <ul>
    <li><a href="index.php">홈</a></li>
    <li><a href="login.php">로그인</a></li>
    <li><a href="search.php">계좌조회</a></li>
    <li><a href="xss.php">고객센터</a></li>
    <li><a href="upload.php">서류제출</a></li>
    <li><a href="cmd.php">네트워크진단</a></li>
  </ul>
</nav>

<div class="container">
  <h2>계좌 조회</h2>
  <p class="sub">예금주 이름 또는 계좌번호로 조회하세요</p>

  <form method="POST">
    <div class="search-row">
      <input type="text" name="keyword"
             placeholder="예금주 이름 또는 계좌번호 입력"
             value="<?= htmlspecialchars($_POST['keyword'] ?? '') ?>">
      <button type="submit">조회</button>
    </div>
  </form>

  <?php if ($error): ?>
    <div class="error-box">⚠️ <?= $error ?></div>
  <?php endif; ?>

  <?php if ($searched && empty($results) && !$error): ?>
    <p class="no-result">🔍 조회 결과가 없습니다.</p>
  <?php endif; ?>

  <?php foreach ($results as $acc): ?>
  <div class="acc-card">
    <div class="acc-header">
      <span class="acc-no"><?= $acc['account_no'] ?></span>
      <span class="acc-type"><?= $acc['account_type'] ?></span>
    </div>
    <div class="acc-body">
      <div class="item">
        <label>예금주</label>
        <span><?= $acc['owner'] ?></span>
      </div>
      <div class="item">
        <label>잔액</label>
        <span class="balance">₩<?= number_format($acc['balance']) ?></span>
      </div>
    </div>
    <?php if (!empty($tx_results[$acc['account_no']])): ?>
    <table class="tx-table">
      <thead>
        <tr><th>구분</th><th>금액</th><th>메모</th><th>일시</th></tr>
      </thead>
      <tbody>
        <?php foreach ($tx_results[$acc['account_no']] as $tx): ?>
        <tr>
          <td class="<?= $tx['type']==='입금' ? 'type-in':'type-out' ?>"><?= $tx['type'] ?></td>
          <td>₩<?= number_format($tx['amount']) ?></td>
          <td><?= $tx['memo'] ?></td>
          <td><?= $tx['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>

  <div class="footer-link"><a href="index.php">← 홈으로</a></div>
</div>

<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body>
</html>
