FoodHub: Food Waste Donation Platform
SIMPLE PHP PDO OOP VERSION

FILES:
- index.php
- connection.php
- handler.php
- style.css
- classes/FoodDonation.php
- database/andujar_foodhub.sql

HOW TO RUN:
1. Put this project folder inside C:\xampp\htdocs\
2. Start Apache and MySQL.
3. Open http://localhost/phpmyadmin
4. Import database/andujar_foodhub.sql
5. Open http://localhost/andujar_foodhub/

DATABASE CONFIGURATION:
Defaults: localhost:3306, database andujar_foodhub, user root, empty password.
For hosting, set DB_HOST, DB_PORT, DB_NAME, DB_USER, and DB_PASSWORD,
or create connection.local.php with PHP assignments for $host, $port,
$dbname, $username, and $password. This local file is ignored by Git.
Keep database credentials out of the repository.

FLOW:
Form -> handler.php -> FoodDonation object -> PDO query -> MySQL -> index.php

NOTE:
The fields follow the FoodDonations entity from the Prelim. DonorID is kept as a simple number field.
