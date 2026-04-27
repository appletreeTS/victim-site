<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
$output = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target = $_POST['target'] ?? '';
    // [취약] OS Command Injection - 입력값 그대로 shell 실행
    $output = shell_exec('ping -c 4 ' . $target . ' 2>&1');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 네트워크진단</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:560px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;}
button:hover{background:#2196f3;}
pre{background:#1e1e1e;color:#00e676;padding:20px;border-radius:8px;font-size:13px;margin-top:20px;overflow-x:auto;white-space:pre-wrap;word-break:break-all;}
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
  <h2>네트워크 연결 진단</h2>
  <p class="sub">인터넷뱅킹 연결 상태를 진단합니다</p>
  <form method="POST">
    <label>서버 IP 또는 도메인</label>
    <input type="text" name="target"
           placeholder="예) 192.168.0.1"
           value="<?= htmlspecialchars($_POST['target'] ?? '') ?>">
    <button type="submit">진단 시작</button>
  </form>
  <?php if ($output): ?>
    <pre><?= htmlspecialchars($output) ?></pre>
  <?php endif; ?>
  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
