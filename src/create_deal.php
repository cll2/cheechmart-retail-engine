<?php
require_once 'dbconnect.local.php';

// Fetch vendors for dropdown
$vendor_result = pg_query($conn, "SELECT vendor_id, name FROM vendors");
if (!$vendor_result) {
    echo "<p>Failed to fetch vendors: " . pg_last_error($conn) . "</p>";
    exit;
}

// Fetch items for dropdown (assuming you have an 'items' table)
$item_result = pg_query($conn, "SELECT item_id, description FROM items");
if (!$item_result) {
    echo "<p>Failed to fetch items: " . pg_last_error($conn) . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Deal</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>

<h1>Create a New Deal</h1>

<form method="POST" action="add_deal.php">
    <label for="vendor">Vendor:</label>
    <select name="vendor_id" id="vendor" required>
        <?php
        while ($vendor = pg_fetch_assoc($vendor_result)) {
            echo "<option value='" . $vendor['vendor_id'] . "'>" . htmlspecialchars($vendor['name']) . "</option>";
        }
        ?>
    </select><br><br>

    <label for="item">Item:</label>
    <select name="item_id" id="item" required>
        <?php
        while ($item = pg_fetch_assoc($item_result)) {
            echo "<option value='" . $item['item_id'] . "'>" . htmlspecialchars($item['description']) . "</option>";
        }
        ?>
    </select><br><br>

    <label for="deal_type">Deal Type:</label>
    <input type="text" name="deal_type" id="deal_type" required><br><br>

    <label for="amount">Amount ($):</label>
    <input type="number" step="0.01" name="amount" id="amount" required><br><br>

    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" id="start_date" required><br><br>

    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" id="end_date" required><br><br>

    <button type="submit">Add Deal</button>
</form>

<p><a href="display_deals.php">View All Deals</a></p>

<?php pg_close($conn); ?>

</body>
</html>

