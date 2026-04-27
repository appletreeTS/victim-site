-- =============================================
--  SecureBank 실습환경 DB 초기화
--  사용법: mysql -u root -p < setup.sql
-- =============================================
 
CREATE DATABASE IF NOT EXISTS victim_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE victim_db;
 
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS inquiries;
DROP TABLE IF EXISTS users;
 
CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL,
    password VARCHAR(100) NOT NULL,
    role     VARCHAR(20)  DEFAULT 'user',
    email    VARCHAR(100)
);
 
INSERT INTO users (username, password, role, email) VALUES
('admin',   'admin1234',  'admin', 'admin@securebank.local'),
('alice',   'alice2025',  'user',  'alice@example.com'),
('bob',     'qwerty123',  'user',  'bob@example.com'),
('charlie', 'password',   'user',  'charlie@example.com');
 
CREATE TABLE accounts (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT           NOT NULL,
    account_no   VARCHAR(20)   NOT NULL UNIQUE,
    owner        VARCHAR(50)   NOT NULL,
    balance      DECIMAL(15,2) DEFAULT 0.00,
    account_type VARCHAR(20)   DEFAULT '입출금'
);
 
INSERT INTO accounts (user_id, account_no, owner, balance, account_type) VALUES
(2, '110-123-456789', 'alice',   15230000.00, '입출금'),
(2, '110-987-112233', 'alice',    3000000.00, '적금'),
(3, '110-555-667788', 'bob',      8750000.00, '입출금'),
(4, '110-222-334455', 'charlie',   450000.00, '입출금'),
(1, '110-000-000001', 'admin',   99999999.99, '관리자');
 
CREATE TABLE transactions (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    account_no VARCHAR(20)   NOT NULL,
    type       VARCHAR(10)   NOT NULL,
    amount     DECIMAL(15,2),
    memo       VARCHAR(100),
    created_at DATETIME DEFAULT NOW()
);
 
INSERT INTO transactions (account_no, type, amount, memo) VALUES
('110-123-456789', '입금', 5000000,  '급여'),
('110-123-456789', '출금',   50000,  '카페'),
('110-123-456789', '출금', 1200000,  '카드대금'),
('110-555-667788', '입금', 3000000,  '이체'),
('110-555-667788', '출금',  250000,  '공과금');
 
CREATE TABLE inquiries (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(50),
    message    TEXT,
    created_at DATETIME DEFAULT NOW()
);
 
CREATE USER IF NOT EXISTS 'victim'@'localhost' IDENTIFIED BY 'victim';
CREATE USER IF NOT EXISTS 'victim'@'127.0.0.1' IDENTIFIED BY 'victim';
GRANT ALL PRIVILEGES ON victim_db.* TO 'victim'@'localhost';
GRANT ALL PRIVILEGES ON victim_db.* TO 'victim'@'127.0.0.1';
FLUSH PRIVILEGES;
 
SELECT '✅ SecureBank DB 초기화 완료' AS result;
