
CREATE DATABASE attendance_db;
USE attendance_db;


(i) Users Table

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('student', 'teacher', 'admin'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

(ii) Attendance Table

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    date DATE,
    status ENUM('Present', 'Absent'),
    recorded_by INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (recorded_by) REFERENCES users(id)
);

iii)students table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

Create a teachers Table to store teacher details.
 
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);