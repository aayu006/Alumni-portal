-- Create database and tables
CREATE DATABASE IF NOT EXISTS alumni_portal;
USE alumni_portal;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    batch VARCHAR(50) DEFAULT NULL,
    skills TEXT DEFAULT NULL,
    linkedin VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Jobs Table (Career Updates)
CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    company VARCHAR(100),
    location VARCHAR(100),
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Jobs
INSERT INTO jobs (title, company, location, link) VALUES
('Software Engineer', 'Google', 'Bengaluru', 'https://careers.google.com'),
('Data Analyst', 'TCS', 'Mumbai', 'https://www.tcs.com/careers'),
('Web Developer Intern', 'Infosys', 'Pune', 'https://www.infosys.com/careers');
