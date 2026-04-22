<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';
$result = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search'];
    $query = "SELECT * FROM users WHERE username LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>SecureBank 계좌조회</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
nav{background:#1a3c6e;padding:15px 40px;color:white;font-size:22px;font-weight:700;}
nav span{color:#4fc3f7;}
body{background:#f4f6f9;}
.container{max-width:600px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
.search-box{display:flex;gap:10px;margin-bottom:25px;}
input{flex:1;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;}
button{padding:11px 24px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:14px;cursor:pointer;}
button:hover{background:#2196f3;}
table{width:100%;border-collapse:collapse;font-size:14px;}
th{background:#1a3c6e;color:white;padding:11px;text-align:left;}
td{padding:11px;border-bottom:1px solid #eee;}
tr:hover td{background:#f0f4ff;}
.no-result{color:#888;text-align:center;padding:20px;}
.footer-link{margin-top:20px;font-size:13px;} .footer-link a{color:#2196f3;text-decoration:none;}
</style>
</head><body>
<nav>Secure<span>Bank</span></nav>
<div class="container">
  <h2>고객 계좌 조회</h2>
  <p class="sub">고객명을 입력하여 계좌 정보를 조회하세요</p>
  <form method="POST">
    <div class="search-box">
      <input type="text" name="search" placeholder="고객명 입력">
      <button type="submit">조회</button>
    </div>
  </form>
  <?php if($result): ?>
    <?php if(mysqli_num_rows($result) > 0): ?>
    <table>
      <tr><th>고객번호</th><th>고객명</th><th>이메일</th></tr>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
      <tr><td><?=$row['id']?></td><td><?=$row['username']?></td><td><?=$row['email']?></td></tr>
      <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p class="no-result">검색 결과가 없습니다.</p>
    <?php endif; ?>
  <?php endif; ?>
  <div class="footer-link"><a href="index.php">← 홈으로</a></div>
</div>
</body></html>
