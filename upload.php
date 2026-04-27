<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $filename = $_FILES['file']['name'];
    $tmp      = $_FILES['file']['tmp_name'];
    // [취약] 확장자·MIME 타입 무검증 - 모든 파일 업로드 허용
    if (move_uploaded_file($tmp, $upload_dir . $filename)) {
        $msg = "<p style='color:#2e7d32'>✅ 서류가 제출되었습니다. 
                (<a href='{$upload_dir}{$filename}' target='_blank'>{$upload_dir}{$filename}</a>)</p>";
    } else {
        $msg = "<p style='color:#e53935'>❌ 제출에 실패했습니다. 다시 시도해주세요.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 서류제출</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:500px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
.upload-box{border:2px dashed #b0c4de;border-radius:10px;padding:30px;text-align:center;margin-bottom:20px;color:#888;background:#f9fbff;}
input[type=file]{margin-top:10px;font-size:13px;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;}
button:hover{background:#2196f3;}
.msg{margin-bottom:16px;font-size:14px;}
.back{margin-top:18px;font-size:13px;} .back a{color:#2196f3;text-decoration:none;}
footer{background:#1a3c6e;color:#aaa;text-align:center;padding:20px;font-size:13px;margin-top:60px;}
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
  <h2>서류 제출</h2>
  <p class="sub">대출 및 계좌 개설에 필요한 서류를 제출하세요</p>
  <?php if ($msg) echo "<div class='msg'>$msg</div>"; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="upload-box">
      📎 파일을 선택하세요<br>
      <input type="file" name="file">
    </div>
    <button type="submit">서류 제출</button>
  </form>
  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
