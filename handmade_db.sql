CREATE DATABASE handmade_db;
GO

-- Insert admin account
INSERT INTO user (email, password, role, phone, address) 
VALUES (
    'admin@collective.com',
    SHA2('admin123', 256),
    'ADMIN',
    '09123456789',
    'Admin Office'
);

CREATE TABLE [user] (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL CHECK (role IN ('ADMIN', 'EMPLOYEE', 'CUSTOMER')),
    phone VARCHAR(20) NOT NULL UNIQUE,
    address VARCHAR(255)
);

CREATE TABLE EMPLOYEE (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    middlename VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE CUSTOMER (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    middlename VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
);