<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $upload_dir='uploads/';
    if(!is_dir($upload_dir)) mkdir($upload_dir,0777,true);
    $filename=$_FILES['file']['name'];
    $tmp_path=$_FILES['file']['tmp_name'];
    if(move_uploaded_file($tmp_path,$upload_dir.$filename)){
        $msg="<p style='color:#2e7d32'>✅ 서류가 정상적으로 제출되었습니다. ($upload_dir$filename)</p>";
    } else {
        $msg="<p style='color:#e53935'>❌ 제출에 실패했습니다. 다시 시도해주세요.</p>";
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>SecureBank 서류제출</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
nav{background:#1a3c6e;padding:15px 40px;color:white;font-size:22px;font-weight:700;}
nav span{color:#4fc3f7;}
body{background:#f4f6f9;}
.container{max-width:500px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
.upload-box{border:2px dashed #1a3c6e;border-radius:10px;padding:30px;text-align:center;margin-bottom:20px;color:#888;}
input[type=file]{margin-top:10px;}
button{width:100%;padding:13px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:15px;cursor:pointer;}
button:hover{background:#2196f3;}
.footer-link{margin-top:20px;font-size:13px;} .footer-link a{color:#2196f3;text-decoration:none;}
</style>
</head><body>
<nav>Secure<span>Bank</span></nav>
<div class="container">
  <h2>서류 제출</h2>
  <p class="sub">대출 및 계좌 개설에 필요한 서류를 제출하세요</p>
  <?php if(isset($msg)) echo $msg; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="upload-box">
      📎 파일을 선택하세요<br>
      <input type="file" name="file">
    </div>
    <button type="submit">서류 제출</button>
  </form>
  <div class="footer-link"><a href="index.php">← 홈으로</a></div>
</div>
</body></html>
