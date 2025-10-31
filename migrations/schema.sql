-- Create database (adjust name as needed)
CREATE DATABASE IF NOT EXISTS orders_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE orders_db;

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  items JSON NOT NULL,
  vip TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('active','completed') NOT NULL DEFAULT 'active',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  pickup_time DATETIME NULL,
  completed_at DATETIME NULL,
  INDEX idx_status (status),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
