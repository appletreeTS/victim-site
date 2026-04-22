<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>SecureBank 고객센터</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
nav{background:#1a3c6e;padding:15px 40px;color:white;font-size:22px;font-weight:700;}
nav span{color:#4fc3f7;}
body{background:#f4f6f9;}
.container{max-width:600px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
label{display:block;font-size:13px;color:#555;margin-bottom:5px;}
input,textarea{width:100%;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;margin-bottom:16px;}
textarea{height:120px;resize:vertical;}
button{padding:11px 28px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:14px;cursor:pointer;}
button:hover{background:#2196f3;}
.reply{background:#f0f4ff;border-left:4px solid #1a3c6e;padding:15px;border-radius:8px;margin-top:20px;}
.reply b{color:#1a3c6e;}
.footer-link{margin-top:20px;font-size:13px;} .footer-link a{color:#2196f3;text-decoration:none;}
</style>
</head><body>
<nav>Secure<span>Bank</span></nav>
<div class="container">
  <h2>고객센터 문의</h2>
  <p class="sub">불편하신 점이나 궁금한 사항을 남겨주세요</p>
  <form method="POST">
    <label>이름</label>
    <input type="text" name="name" placeholder="이름을 입력하세요">
    <label>문의 내용</label>
    <textarea name="message" placeholder="문의 내용을 입력하세요"></textarea>
    <button type="submit">문의 등록</button>
  </form>
  <?php if($_SERVER['REQUEST_METHOD']=='POST'): ?>
  <div class="reply">
    <b><?= $_POST['name'] ?></b>님의 문의가 등록되었습니다.<br><br>
    <?= $_POST['message'] ?>
  </div>
  <?php endif; ?>
  <div class="footer-link"><a href="index.php">← 홈으로</a></div>
</div>
</body></html>
