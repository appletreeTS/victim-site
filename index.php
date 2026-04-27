<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>SecureBank - 안전한 금융의 시작</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f6f9;color:#333;}
nav{background:#1a3c6e;padding:15px 40px;display:flex;justify-content:space-between;align-items:center;}
nav .logo{color:white;font-size:24px;font-weight:700;letter-spacing:1px;}
nav .logo span{color:#4fc3f7;}
nav ul{list-style:none;display:flex;gap:24px;}
nav ul a{color:#ccc;text-decoration:none;font-size:14px;}
nav ul a:hover{color:white;}
.hero{background:linear-gradient(135deg,#1a3c6e,#2196f3);color:white;padding:80px 40px;text-align:center;}
.hero h1{font-size:42px;margin-bottom:15px;}
.hero p{font-size:18px;opacity:0.85;margin-bottom:30px;}
.hero a{background:#4fc3f7;color:#1a3c6e;padding:14px 36px;border-radius:30px;text-decoration:none;font-weight:700;font-size:16px;}
.services{display:flex;justify-content:center;gap:24px;padding:60px 40px;flex-wrap:wrap;}
.card{background:white;border-radius:12px;padding:28px;width:200px;text-align:center;box-shadow:0 2px 12px rgba(0,0,0,0.08);}
.card .icon{font-size:36px;margin-bottom:13px;}
.card h3{font-size:15px;color:#1a3c6e;margin-bottom:7px;}
.card p{font-size:12px;color:#777;}
.card a{display:inline-block;margin-top:13px;background:#1a3c6e;color:white;padding:7px 18px;border-radius:20px;text-decoration:none;font-size:12px;}
footer{background:#1a3c6e;color:#aaa;text-align:center;padding:20px;font-size:13px;}
</style>
</head>
<body>
<nav>
  <div class="logo">Secure<span>Bank</span></div>
  <ul>
    <li><a href="index.php">홈</a></li>
    <li><a href="login.php">로그인</a></li>
    <li><a href="search.php">계좌조회</a></li>
    <li><a href="transfer.php">계좌이체</a></li>
    <li><a href="notice.php">공지사항</a></li>
    <li><a href="xss.php">고객센터</a></li>
    <li><a href="upload.php">서류제출</a></li>
    <li><a href="cmd.php">네트워크진단</a></li>
  </ul>
</nav>
<div class="hero">
  <h1>당신의 자산을 안전하게</h1>
  <p>SecureBank와 함께 스마트한 금융 생활을 시작하세요</p>
  <a href="login.php">인터넷뱅킹 시작하기</a>
</div>
<div class="services">
  <div class="card"><div class="icon">🏦</div><h3>인터넷뱅킹</h3><p>언제 어디서나 편리하게</p><a href="login.php">로그인</a></div>
  <div class="card"><div class="icon">🔍</div><h3>계좌조회</h3><p>잔액 및 거래내역 확인</p><a href="search.php">조회하기</a></div>
  <div class="card"><div class="icon">💸</div><h3>계좌이체</h3><p>빠르고 안전한 송금</p><a href="transfer.php">이체하기</a></div>
  <div class="card"><div class="icon">📢</div><h3>공지사항</h3><p>최신 공지사항 확인</p><a href="notice.php">확인하기</a></div>
  <div class="card"><div class="icon">💬</div><h3>고객센터</h3><p>궁금한 점을 문의하세요</p><a href="xss.php">문의하기</a></div>
  <div class="card"><div class="icon">📄</div><h3>서류제출</h3><p>대출·계좌 개설 서류</p><a href="upload.php">제출하기</a></div>
  <div class="card"><div class="icon">🌐</div><h3>네트워크진단</h3><p>연결 상태를 진단하세요</p><a href="cmd.php">진단하기</a></div>
</div>
<footer>© 2026 SecureBank. All rights reserved. | 고객센터: 1588-0000</footer>
</body>
</html>
