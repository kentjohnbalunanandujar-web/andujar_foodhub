CREATE DATABASE IF NOT EXISTS andujar_foodhub;

USE andujar_foodhub;

CREATE TABLE food_donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT,
    food_name VARCHAR(100) NOT NULL,
    quantity VARCHAR(50),
    category VARCHAR(60),
    expiration_date DATE,
    pickup_location VARCHAR(150),
    status VARCHAR(30)
);

INSERT INTO food_donations
(donor_id, food_name, quantity, category, expiration_date, pickup_location, status)
VALUES
(1, 'Bread', '10 packs', 'Bakery', '2026-09-01', 'Bogo City', 'Available');
