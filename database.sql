-- Create database and switch to it
CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- 1. institution
CREATE TABLE IF NOT EXISTS institution (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255),
    motto VARCHAR(255),
    description TEXT,
    address TEXT,
    phone VARCHAR(50),
    email VARCHAR(100),
    website VARCHAR(100),
    facebook VARCHAR(100),
    twitter VARCHAR(100),
    instagram VARCHAR(100),
    map_embed TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. departments
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    hod VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. programs
CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT,
    name VARCHAR(255) NOT NULL,
    duration VARCHAR(50),
    description TEXT,
    requirements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

-- 4. staff
CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    department_id INT,
    position VARCHAR(100),
    qualification VARCHAR(255),
    bio TEXT,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
);

-- 5. news
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    summary TEXT,
    content TEXT,
    image VARCHAR(255),
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. events
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME,
    venue VARCHAR(255),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 7. gallery
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50),  -- e.g., 'Campus', 'Events', 'Facilities', 'Students'
    image VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. downloads
CREATE TABLE IF NOT EXISTS downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. contact_messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 10. admin_users
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- INSERT SAMPLE DATA

INSERT INTO institution (name, motto, description, address, phone, email) 
VALUES ('Global Excellence College', 'Empowering the Future', 'A premier institution dedicated to academic excellence.', '123 University Avenue, Tech City', '+1 555 123 4567', 'info@gec.edu');

INSERT INTO admin_users (email, password, name) 
VALUES ('admin@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator'); 
-- Password is 'password'

INSERT INTO departments (name, description, hod) VALUES 
('Computer Science', 'Leading tech department', 'Dr. Alan Turing'),
('Business Admin', 'Nurturing future leaders', 'Prof. M. Porter');

INSERT INTO programs (department_id, name, duration, description, requirements) VALUES 
(1, 'B.Sc. Computer Science', '4 Years', 'Comprehensive degree in CS.', 'High school diploma with math.'),
(2, 'BBA', '3 Years', 'Bachelor of Business Administration.', 'High school diploma.');

INSERT INTO news (title, slug, summary, content, published_at) VALUES 
('Welcome to the New Academic Year', 'welcome-new-year', 'Welcome all new and returning students.', 'Full content about the reopening of the school...', NOW());

INSERT INTO events (title, description, event_date, venue) VALUES 
('Technology Symposium 2026', 'Annual tech event for students.', DATE_ADD(NOW(), INTERVAL 14 DAY), 'Main Auditorium');
