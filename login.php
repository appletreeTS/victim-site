<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>로그인 성공</title>
        <style>*{margin:0;padding:0;font-family:Segoe UI,sans-serif;}
        nav{background:#1a3c6e;padding:15px 40px;color:white;font-size:22px;font-weight:700;}
        nav span{color:#4fc3f7;}
        .box{max-width:500px;margin:80px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.1);text-align:center;}
        h2{color:#1a3c6e;margin-bottom:15px;} p{color:#555;} a{color:#2196f3;}
        </style></head><body>
        <nav>Secure<span>Bank</span></nav>
        <div class="box">
        <h2>✅ 로그인 성공</h2>
        <p>환영합니다, <b>' . $user['username'] . '</b>님!</p><br>
        <p><a href="index.php">홈으로 돌아가기</a></p>
        </div></body></html>';
        exit;
    } else {
        $error = '아이디 또는 비밀번호가 올바르지 않습니다.';
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>SecureBank 로그인</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
nav{background:#1a3c6e;padding:15px 40px;color:white;font-size:22px;font-weight:700;}
nav span{color:#4fc3f7;}
body{background:#f4f6f9;}
.container{max-width:420px;margin:80px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;font-size:24px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;font-weight:600;}
button:hover{background:#2196f3;}
.error{color:#e53935;font-size:13px;margin-bottom:12px;}
.footer-link{text-align:center;margin-top:20px;font-size:13px;color:#888;}
.footer-link a{color:#2196f3;text-decoration:none;}
</style>
</head><body>
<nav>Secure<span>Bank</span></nav>
<div class="container">
  <h2>인터넷뱅킹 로그인</h2>
  <p class="sub">SecureBank 계정으로 로그인하세요</p>
  <?php if($error) echo "<p class='error'>⚠️ $error</p>"; ?>
  <form method="POST">
    <label>아이디</label>
    <input type="text" name="username" placeholder="아이디를 입력하세요">
    <label>비밀번호</label>
    <input type="password" name="password" placeholder="비밀번호를 입력하세요">
    <button type="submit">로그인</button>
  </form>
  <div class="footer-link"><a href="index.php">← 홈으로</a></div>
</div>
</body></html>
