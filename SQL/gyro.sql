CREATE TABLE gyro (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    angX VARCHAR(10),
    angY VARCHAR(10),
    angZ VARCHAR(10),
    accX VARCHAR(10),
    accY VARCHAR(10),
    accZ VARCHAR(10),
    reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)