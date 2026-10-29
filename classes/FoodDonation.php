<?php

class FoodDonation {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {

        $query = "SELECT * FROM food_donations ORDER BY donation_id DESC";

        $stmt = $this->conn->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($donor_id, $food_name, $quantity, $category, $expiration_date, $pickup_location, $status) {

        $query = "INSERT INTO food_donations
                  (donor_id, food_name, quantity, category, expiration_date, pickup_location, status)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $donor_id,
            $food_name,
            $quantity,
            $category,
            $expiration_date,
            $pickup_location,
            $status
        ]);
    }

    public function update($donation_id, $donor_id, $food_name, $quantity, $category, $expiration_date, $pickup_location, $status) {

        $query = "UPDATE food_donations
                  SET donor_id = ?,
                      food_name = ?,
                      quantity = ?,
                      category = ?,
                      expiration_date = ?,
                      pickup_location = ?,
                      status = ?
                  WHERE donation_id = ?";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            $donor_id,
            $food_name,
            $quantity,
            $category,
            $expiration_date,
            $pickup_location,
            $status,
            $donation_id
        ]);
    }

    public function delete($donation_id) {

        $query = "DELETE FROM food_donations WHERE donation_id = ?";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([$donation_id]);
    }

    public function search($keyword) {

        $keyword = "%" . $keyword . "%";

        $query = "SELECT * FROM food_donations
                  WHERE donor_id LIKE ?
                  OR food_name LIKE ?
                  OR quantity LIKE ?
                  OR category LIKE ?
                  OR expiration_date LIKE ?
                  OR pickup_location LIKE ?
                  OR status LIKE ?
                  ORDER BY donation_id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
