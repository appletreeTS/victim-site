<?php header('Content-Type: text/html; charset=utf-8'); ?>
<?php
// [취약] Reflected XSS - GET 파라미터 비필터링 즉시 출력
$search = $_GET['q'] ?? '';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8"><title>SecureBank 공지사항</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:22px;font-weight:700;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:30px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.container{max-width:720px;margin:60px auto;background:white;padding:40px;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.1);}
h2{color:#1a3c6e;margin-bottom:6px;}
p.sub{color:#888;font-size:13px;margin-bottom:25px;}
.search-row{display:flex;gap:10px;margin-bottom:28px;}
.search-row input{flex:1;padding:11px 14px;border:1px solid #ddd;border-radius:8px;font-size:14px;}
.search-row button{padding:11px 24px;background:#1a3c6e;color:white;border:none;border-radius:8px;font-size:14px;cursor:pointer;}
.search-row button:hover{background:#2196f3;}
.result-box{background:#f0f4ff;border-left:4px solid #1a3c6e;padding:14px 18px;border-radius:6px;margin-bottom:20px;font-size:14px;color:#333;}
.result-box b{color:#1a3c6e;}
.notice-list{list-style:none;}
.notice-list li{padding:16px 0;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between;align-items:center;}
.notice-list li:last-child{border-bottom:none;}
.notice-list .title{font-size:14px;color:#333;}
.notice-list .date{font-size:12px;color:#aaa;}
.badge{display:inline-block;background:#1a3c6e;color:white;font-size:11px;padding:2px 8px;border-radius:4px;margin-right:8px;}
.badge.hot{background:#e53935;}
.back{margin-top:20px;font-size:13px;} .back a{color:#2196f3;text-decoration:none;}
footer{background:#1a3c6e;color:#aaa;text-align:center;padding:20px;font-size:13px;margin-top:60px;}
</style>
</head>
<body>
<nav>
  <div class="logo">Secure<span>Bank</span></div>
  <ul>
    <li><a href="index.php">홈</a></li><li><a href="login.php">로그인</a></li>
    <li><a href="search.php">계좌조회</a></li><li><a href="transfer.php">계좌이체</a></li>
    <li><a href="notice.php">공지사항</a></li><li><a href="xss.php">고객센터</a></li>
    <li><a href="upload.php">서류제출</a></li><li><a href="cmd.php">네트워크진단</a></li>
  </ul>
</nav>

<div class="container">
  <h2>공지사항</h2>
  <p class="sub">SecureBank 주요 공지사항을 확인하세요</p>

  <form method="GET">
    <div class="search-row">
      <input type="text" name="q"
             placeholder="공지사항 검색"
             value="<?= $search ?>">
      <button type="submit">검색</button>
    </div>
  </form>

  <?php if ($search !== ''): ?>
  <div class="result-box">
    <!-- [취약] Reflected XSS - $search 그대로 출력 -->
    <b>"<?= $search ?>"</b> 검색 결과입니다.
  </div>
  <?php endif; ?>

  <ul class="notice-list">
    <li>
      <span class="title"><span class="badge hot">긴급</span>인터넷뱅킹 보안 업데이트 안내</span>
      <span class="date">2026-04-20</span>
    </li>
    <li>
      <span class="title"><span class="badge">공지</span>개인정보처리방침 개정 안내</span>
      <span class="date">2026-04-15</span>
    </li>
    <li>
      <span class="title"><span class="badge">공지</span>스마트폰 뱅킹 앱 업데이트 안내</span>
      <span class="date">2026-04-10</span>
    </li>
    <li>
      <span class="title"><span class="badge">공지</span>전자금융 서비스 이용 시 주의사항</span>
      <span class="date">2026-03-28</span>
    </li>
    <li>
      <span class="title"><span class="badge">공지</span>2026년 1분기 이자율 변경 안내</span>
      <span class="date">2026-03-01</span>
    </li>
  </ul>

  <div class="back"><a href="index.php">← 홈으로</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body></html>
