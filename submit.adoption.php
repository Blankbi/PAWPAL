USE pawpal;

CREATE TABLE adoptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  adopter_name VARCHAR(100),
  adopter_email VARCHAR(100),
  animal_name VARCHAR(100),
  adopted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
