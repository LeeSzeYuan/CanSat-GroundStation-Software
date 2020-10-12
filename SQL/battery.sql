CREATE TABLE battery (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    percent VARCHAR(10),
    reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)