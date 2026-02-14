-- Run as MySQL root when switching admin panel from SQLite to MySQL
CREATE DATABASE IF NOT EXISTS ajayal_admin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'ajayal_admin'@'localhost' IDENTIFIED BY 'your_password_here';
GRANT ALL PRIVILEGES ON ajayal_admin.* TO 'ajayal_admin'@'localhost';
FLUSH PRIVILEGES;
