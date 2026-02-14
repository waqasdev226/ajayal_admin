-- Run this in MySQL to fix "Database connection failed" for the admin panel.
-- Use:  mysql -u root -p < setup-mysql.sql
-- Or open in MySQL Workbench / TablePlus and run.

CREATE DATABASE IF NOT EXISTS api_ajayal_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'api_ajayal_user'@'localhost'
  IDENTIFIED BY 'StrongPassword@123';

GRANT ALL PRIVILEGES ON api_ajayal_db.* TO 'api_ajayal_user'@'localhost';
FLUSH PRIVILEGES;
