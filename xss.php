<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name']    ?? '';
    $message = $_POST['message'] ?? '';
    // [취약] Stored XSS - 입력값 그대로 DB 저장
    $q = "INSERT INTO inquiries (name, message) VALUES ('$name', '$message')";
    mysqli_query($conn, $q);
}

$list = [];
$res  = mysqli_query($conn, "SELECT * FROM inquiries ORDER BY created_at DESC");
if ($res) { while ($row = mysqli_fetch_assoc($res)) $list[] = $row; }
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 고객센터</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;color:#333;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:680px;margin:50px auto;}
.box{background:white;padding:36px 40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.09);margin-bottom:30px;}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:22px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input,textarea{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;}
textarea{height:110px;resize:vertical;}
button{padding:11px 28px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:14px;cursor:pointer;}
button:hover{background:#2196f3;}
h3{color:#1a3c6e;margin-bottom:16px;font-size:16px;}
.card{border:1px solid #e8edf5;border-radius:8px;padding:16px 20px;margin-bottom:14px;background:#fafbfe;}
.card .meta{font-size:12px;color:#aaa;margin-bottom:8px;}
.card .author{font-weight:700;color:#1a3c6e;font-size:14px;}
.card .content{font-size:14px;color:#444;line-height:1.6;}
.empty{color:#aaa;text-align:center;padding:20px 0;font-size:14px;}
.back{font-size:13px;margin-top:14px;} .back a{color:#2196f3;text-decoration:none;}
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
  <div class="box">
    <h2>고객센터 문의</h2>
    <p class="sub">불편하신 점이나 궁금한 사항을 남겨주세요</p>
    <form method="POST">
      <label>이름</label>
      <input type="text" name="name" placeholder="이름을 입력하세요">
      <label>문의 내용</label>
      <textarea name="message" placeholder="문의 내용을 입력하세요"></textarea>
      <button type="submit">문의 등록</button>
    </form>
    <div class="back"><a href="index.php">← 홈으로</a></div>
  </div>
  <div class="box">
    <h3>📋 등록된 문의 목록</h3>
    <?php if (empty($list)): ?>
      <p class="empty">등록된 문의가 없습니다.</p>
    <?php else: ?>
      <?php foreach ($list as $item): ?>
      <div class="card">
        <div class="meta">
          <span class="author"><?= $item['name'] ?></span> · <?= $item['created_at'] ?>
        </div>
        <!-- [취약] Stored XSS - 비필터링 출력 -->
        <div class="content"><?= $item['message'] ?></div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
