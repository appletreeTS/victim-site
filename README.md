# victim-site
SecureBank — 보안 실습 환경
의도적으로 취약하게 제작된 금융 웹 애플리케이션입니다.
VMware 내부 실습 환경 전용 — 외부 네트워크에 절대 노출 금지

빠른 시작 (VMware 세팅)
1. 저장소 클론
bashcd /var/www/html
git clone https://github.com/<your-repo>/securebank.git .
2. DB 초기화 (한 번만 실행)
bashmysql -u root -p < setup.sql
3. 업로드 디렉토리 권한
bashmkdir -p uploads
chmod 777 uploads
4. PHP + Apache 확인
bashsudo systemctl start apache2
sudo systemctl start mysql
5. 접속
http://localhost/

계정 정보
아이디비밀번호권한adminadmin1234관리자alicealice2025일반bobqwerty123일반charliepassword일반

취약점 목록
페이지취약점시나리오login.phpSQL Injection (인증 우회)' OR '1'='1search.phpSQL Injection (데이터 덤프)' OR '1'='1 / UNIONxss.phpStored XSS<script>alert(1)</script>upload.php파일 업로드 무검증.php 웹쉘 업로드cmd.phpOS Command Injection; whoami, ; cat /etc/passwdmypage.phpIDOR?user=admin

파일 구조
securebank/
├── db.php          # DB 연결 설정
├── index.php       # 메인 페이지
├── login.php       # 로그인 (SQL Injection)
├── search.php      # 계좌조회 (SQL Injection)
├── xss.php         # 고객센터 (Stored XSS)
├── upload.php      # 서류제출 (파일 업로드)
├── cmd.php         # 네트워크진단 (Command Injection)
├── mypage.php      # 마이페이지 (IDOR)
├── setup.sql       # DB 초기화 스크립트
└── uploads/        # 업로드 파일 저장 디렉토리
