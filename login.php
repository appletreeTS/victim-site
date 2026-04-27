<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
mysqli_report(MYSQLI_REPORT_OFF);
include 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    // [취약] SQL Injection - 입력값 미검증
    $query  = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        header("Location: mypage.php");
        exit;
    } else {
        $error = '아이디 또는 비밀번호가 올바르지 않습니다.';
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 로그인</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:420px;margin:80px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;font-size:24px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;font-weight:600;}
button:hover{background:#2196f3;}
.error{color:#e53935;font-size:13px;margin-bottom:12px;background:#fff3f3;padding:10px 14px;border-radius:6px;border-left:3px solid #e53935;}
.back{text-align:center;margin-top:18px;font-size:13px;} .back a{color:#2196f3;text-decoration:none;}
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
  <h2>인터넷뱅킹 로그인</h2>
  <p class="sub">SecureBank 계정으로 로그인하세요</p>
  <?php if ($error) echo "<div class='error'>⚠️ $error</div>"; ?>
  <form method="POST">
    <label>아이디</label>
    <input type="text" name="username" placeholder="아이디를 입력하세요">
    <label>비밀번호</label>
    <input type="password" name="password" placeholder="비밀번호를 입력하세요">
    <button type="submit">로그인</button>
  </form>
  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
