<?php

require_once("connection.php");
require_once("classes/FoodDonation.php");

$record = new FoodDonation($conn);

$edit_data = null;

if (isset($_GET["search"])) {

    $keyword = trim($_GET["keyword"] ?? "");

    $records = $record->search($keyword);

} else {

    $records = $record->getAll();

}

if (isset($_GET["edit"])) {

    $edit_id = $_GET["edit"];

    foreach ($records as $row) {

        if ($row["donation_id"] == $edit_id) {

            $edit_data = $row;

            break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodHub: Food Waste Donation Platform</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>FoodHub: Food Waste Donation Platform</h1>
    <p class="subtitle">Simple PHP PDO OOP CRUD System</p>

    <div class="note">The fields follow the FoodDonations entity from the Prelim. DonorID is kept as a simple number field.</div>

    <?php if (isset($_GET["message"])): ?>
        <div class="message">
            <?php
            if ($_GET["message"] == "added") echo "Record added successfully.";
            if ($_GET["message"] == "updated") echo "Record updated successfully.";
            if ($_GET["message"] == "deleted") echo "Record deleted successfully.";
            ?>
        </div>
    <?php endif; ?>

    <div class="box">

        <h2><?= $edit_data ? "Update Record" : "Add Record"; ?></h2>

        <form action="handler.php" method="POST">

            <?php if ($edit_data): ?>
                <input type="hidden" name="donation_id" value="<?= $edit_data["donation_id"]; ?>">
            <?php endif; ?>

            <div class="form-grid">

                <div>
                    <label>Donor ID</label>
                    <input type="number" name="donor_id" value="<?= htmlspecialchars($edit_data["donor_id"] ?? ""); ?>">
                </div>

                <div>
                    <label>Food Name</label>
                    <input type="text" name="food_name" value="<?= htmlspecialchars($edit_data["food_name"] ?? ""); ?>">
                </div>

                <div>
                    <label>Quantity</label>
                    <input type="text" name="quantity" value="<?= htmlspecialchars($edit_data["quantity"] ?? ""); ?>">
                </div>

                <div>
                    <label>Category</label>
                    <input type="text" name="category" value="<?= htmlspecialchars($edit_data["category"] ?? ""); ?>">
                </div>

                <div>
                    <label>Expiration Date</label>
                    <input type="date" name="expiration_date" value="<?= htmlspecialchars($edit_data["expiration_date"] ?? ""); ?>">
                </div>

                <div>
                    <label>Pickup Location</label>
                    <input type="text" name="pickup_location" value="<?= htmlspecialchars($edit_data["pickup_location"] ?? ""); ?>">
                </div>

                <div>
                    <label>Status</label>
                    <select name="status"><option value="">Select</option><option value="Available" <?= ($edit_data["status"] ?? "") == "Available" ? "selected" : ""; ?>>Available</option><option value="Requested" <?= ($edit_data["status"] ?? "") == "Requested" ? "selected" : ""; ?>>Requested</option><option value="Completed" <?= ($edit_data["status"] ?? "") == "Completed" ? "selected" : ""; ?>>Completed</option></select>
                </div>

            </div>

            <?php if ($edit_data): ?>
                <button type="submit" name="update_record" class="btn">Update</button>
                <a href="index.php" class="cancel">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add_record" class="btn">Add</button>
            <?php endif; ?>

        </form>

    </div>

    <div class="box">

        <div class="table-header">

            <h2>Records</h2>

            <form method="GET" class="search">

                <input type="text" name="keyword"
                       value="<?= htmlspecialchars($_GET["keyword"] ?? ""); ?>"
                       placeholder="Search">

                <button type="submit" name="search" class="btn">Search</button>

                <a href="index.php" class="cancel">Clear</a>

            </form>

        </div>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor ID</th>
                        <th>Food Name</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Expiration Date</th>
                        <th>Pickup Location</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($records as $row): ?>

                        <tr>
                            <td><?= $row["donation_id"]; ?></td>
                            <td><?= htmlspecialchars($row["donor_id"]); ?></td>
                            <td><?= htmlspecialchars($row["food_name"]); ?></td>
                            <td><?= htmlspecialchars($row["quantity"]); ?></td>
                            <td><?= htmlspecialchars($row["category"]); ?></td>
                            <td><?= htmlspecialchars($row["expiration_date"]); ?></td>
                            <td><?= htmlspecialchars($row["pickup_location"]); ?></td>
                            <td><?= htmlspecialchars($row["status"]); ?></td>
                            <td class="actions">

                                <a href="index.php?edit=<?= $row["donation_id"]; ?>" class="edit">Edit</a>

                                <form action="handler.php" method="POST"
                                      onsubmit="return confirm('Delete this record?');">

                                    <input type="hidden" name="donation_id" value="<?= $row["donation_id"]; ?>">

                                    <button type="submit" name="delete_record" class="delete">Delete</button>

                                </form>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                    <?php if (count($records) == 0): ?>
                        <tr>
                            <td colspan="9">No record found.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
