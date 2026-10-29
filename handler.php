<?php

require_once("connection.php");
require_once("classes/FoodDonation.php");

$record = new FoodDonation($conn);

if (isset($_POST["add_record"])) {

    $donor_id = $_POST["donor_id"] ?? "";
    $food_name = trim($_POST["food_name"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $expiration_date = trim($_POST["expiration_date"] ?? "");
    $pickup_location = trim($_POST["pickup_location"] ?? "");
    $status = trim($_POST["status"] ?? "");

    $record->add(
        $donor_id,
        $food_name,
        $quantity,
        $category,
        $expiration_date,
        $pickup_location,
        $status
    );

    header("Location: index.php?message=added");
    exit();
}

if (isset($_POST["update_record"])) {

    $donation_id = $_POST["donation_id"];

    $donor_id = $_POST["donor_id"] ?? "";
    $food_name = trim($_POST["food_name"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $expiration_date = trim($_POST["expiration_date"] ?? "");
    $pickup_location = trim($_POST["pickup_location"] ?? "");
    $status = trim($_POST["status"] ?? "");

    $record->update(
        $donation_id,
        $donor_id,
        $food_name,
        $quantity,
        $category,
        $expiration_date,
        $pickup_location,
        $status
    );

    header("Location: index.php?message=updated");
    exit();
}

if (isset($_POST["delete_record"])) {

    $donation_id = $_POST["donation_id"];

    $record->delete($donation_id);

    header("Location: index.php?message=deleted");
    exit();
}

?>
