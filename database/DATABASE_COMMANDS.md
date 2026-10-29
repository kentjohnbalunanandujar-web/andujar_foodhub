# FoodHub database commands

These commands were checked against `connection.php`, `classes/FoodDonation.php`, `handler.php`, `index.php`, and the original SQL file. The website uses MySQL/MariaDB through PHP PDO.

## 1. Create the database and table

Start MySQL in XAMPP. In phpMyAdmin, open the SQL tab and run the following, or import the existing `database/andujar_foodhub.sql` file instead. Choose one setup method; the original import creates the table without `IF NOT EXISTS` and inserts its sample row each time it succeeds.

```sql
CREATE DATABASE IF NOT EXISTS andujar_foodhub;
USE andujar_foodhub;

CREATE TABLE IF NOT EXISTS food_donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT,
    food_name VARCHAR(100) NOT NULL,
    quantity VARCHAR(50),
    category VARCHAR(60),
    expiration_date DATE,
    pickup_location VARCHAR(150),
    status VARCHAR(30)
);
```

This matches the supplied schema. `IF NOT EXISTS` prevents a table-already-exists error; it does not repair or migrate an existing table with different columns. Only `food_name` is explicitly non-null; the primary key is also non-null. `donor_id` is an ordinary integer, with no donors table or foreign key in this project. Quantity is text, allowing values such as `10 packs`. The interface offers `Available`, `Requested`, and `Completed`, but the database stores status as unrestricted text up to 30 characters.

## 2. Original sample data (optional)

Run once if wanted. Each run inserts another donation. The date below is the original project's sample date and is already past as of October 29, 2026.

```sql
USE andujar_foodhub;

INSERT INTO food_donations
    (donor_id, food_name, quantity, category, expiration_date, pickup_location, status)
VALUES
    (1, 'Bread', '10 packs', 'Bakery', '2026-09-01', 'Bogo City', 'Available');
```

## 3. View all donations

This is the website's exact listing query.

```sql
USE andujar_foodhub;
SELECT * FROM food_donations ORDER BY donation_id DESC;
```

## 4. Add a donation

Replace the example values as needed. Omit `donation_id` so MySQL generates it.

```sql
USE andujar_foodhub;

INSERT INTO food_donations
    (donor_id, food_name, quantity, category, expiration_date, pickup_location, status)
VALUES
    (2, 'Rice', '5 bags', 'Grains', '2026-12-31', 'Bogo City', 'Available');

SELECT LAST_INSERT_ID() AS new_donation_id;
```

`LAST_INSERT_ID()` must run in the same database session as the insert.

## 5. Update a donation

Set the ID to the record you intend to change. This matches the fields updated by the PHP method.

```sql
USE andujar_foodhub;
SET @donation_id = 1;

UPDATE food_donations
SET donor_id = 1,
    food_name = 'Bread',
    quantity = '8 packs',
    category = 'Bakery',
    expiration_date = '2026-12-01',
    pickup_location = 'Bogo City',
    status = 'Requested'
WHERE donation_id = @donation_id;
```

## 6. Delete a donation

This permanently deletes the selected record. Check its ID first.

```sql
USE andujar_foodhub;
SET @donation_id = 1;

SELECT * FROM food_donations WHERE donation_id = @donation_id;
DELETE FROM food_donations WHERE donation_id = @donation_id;
```

## 7. Search donations

This reproduces the website's search across all seven searchable fields, sorted newest first. Donation ID itself is not searched by the PHP code. `%` matches any number of characters; `_` matches one character, so these characters in a keyword act as wildcards just as they do in the website.

```sql
USE andujar_foodhub;
SET @keyword = 'Bread';
SET @pattern = CONCAT('%', @keyword, '%');

SELECT * FROM food_donations
WHERE donor_id LIKE @pattern
   OR food_name LIKE @pattern
   OR quantity LIKE @pattern
   OR category LIKE @pattern
   OR expiration_date LIKE @pattern
   OR pickup_location LIKE @pattern
   OR status LIKE @pattern
ORDER BY donation_id DESC;
```

## 8. Verify the database structure

```sql
SHOW DATABASES LIKE 'andujar_foodhub';
USE andujar_foodhub;
SHOW TABLES;
DESCRIBE food_donations;
SHOW CREATE TABLE food_donations;
SELECT COUNT(*) AS total_donations FROM food_donations;
```

## 9. Import using the XAMPP command line

Run this in PowerShell from the project folder to import the original setup file, including its sample donation:

```powershell
& 'C:\xampp\mysql\bin\mysql.exe' -u root --execute="SOURCE database/andujar_foodhub.sql"
```

The project currently connects to host `localhost`, database `andujar_foodhub`, username `root`, and an empty password. If your local root account has a password, add `-p` to the command to receive a password prompt, and update `connection.php` to match.

To open an interactive SQL session:

```powershell
& 'C:\xampp\mysql\bin\mysql.exe' -u root andujar_foodhub
```

## Application behavior notes

The PHP code uses prepared statements with `?` placeholders for inserts, updates, deletes, and searches. The examples above use concrete values or SQL variables so they can run directly in phpMyAdmin or the MySQL client; do not paste bare `?` placeholders into those tools.

For optional integer and date fields, direct SQL can use `NULL`. The current form handler passes empty strings for blank fields, which can fail for `donor_id` and `expiration_date` under strict SQL mode. Changing the database schema alone does not normalize those form values.

No database commands were executed against your running database during generation of this guide. No user, donor, login, request, or other tables are referenced by the scanned website.
