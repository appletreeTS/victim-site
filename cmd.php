<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
$output='';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $target=$_POST['target'];
    $output=shell_exec('ping -c 4 '.$target);
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>SecureBank 네트워크 진단</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
nav{background:#1a3c6e;padding:15px 40px;color:white;font-size:22px;font-weight:700;}
nav span{color:#4fc3f7;}
body{background:#f4f6f9;}
.container{max-width:550px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;}
button:hover{background:#2196f3;}
pre{background:#1e1e1e;color:#00e676;padding:20px;border-radius:8px;font-size:13px;margin-top:20px;overflow-x:auto;}
.footer-link{margin-top:20px;font-size:13px;} .footer-link a{color:#2196f3;text-decoration:none;}
</style>
</head><body>
<nav>Secure<span>Bank</span></nav>
<div class="container">
  <h2>네트워크 연결 진단</h2>
  <p class="sub">인터넷뱅킹 연결 상태를 진단합니다</p>
  <form method="POST">
    <label>서버 IP 또는 도메인</label>
    <input type="text" name="target" placeholder="예) 192.168.0.1">
    <button type="submit">진단 시작</button>
  </form>
  <?php if($output): ?>
  <pre><?= $output ?></pre>
  <?php endif; ?>
  <div class="footer-link"><a href="index.php">← 홈으로</a></div>
</div>
</body></html>
