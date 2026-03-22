-- 11. provost
CREATE TABLE IF NOT EXISTS provost (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL DEFAULT 'Provost',
    photo VARCHAR(255),
    welcome_message TEXT,
    public_message TEXT,
    community_impact TEXT,
    academic_integrity TEXT,
    quote VARCHAR(500),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO provost (name, title, photo, welcome_message, public_message, community_impact, academic_integrity, quote)
VALUES (
    'Dr. Muhammad Sani Abubakar',
    'Provost of the College',
    'provost.png',
    'Welcome to our prestigious institution. As the Provost, it is my honor to lead an academic community dedicated to the pursuit of knowledge, innovation, and societal impact. Our mission is to provide an environment where every student can thrive and achieve their fullest potential.\n\nAt the heart of our vision is a commitment to academic rigor and practical relevance. We believe that education should not only inform but also transform. Our faculty members are not just teachers; they are mentors and researchers who are at the forefront of their respective fields.\n\nAs you navigate through our programs and campus life, you will discover a vibrant ecosystem of learning. From state-of-the-art laboratories to our rich cultural initiatives, we offer a holistic experience that prepares you for the challenges of the 21st century.\n\nTo our prospective students, I invite you to join us in this exciting journey. To our current students and staff, I thank you for your continued dedication to excellence. Together, we are building a brighter future, one graduate at a time.',
    'We are committed to transparency and open communication with our stakeholders. Our institutional goals are aligned with the needs of the community we serve, ensuring that our graduates are both locally relevant and globally competitive.',
    'Through our various outreach programs and partnerships, we strive to make a positive impact on society. We believe in the power of education to drive social change and economic development.',
    'Integrity is the cornerstone of our academic pursuits. We maintain the highest standards of ethics in research, teaching, and administration, fostering an environment of trust and mutual respect.',
    'A Direct Path to Excellence'
);
