<?php
require_once 'dbconnect.local.php';

// Sanitize input
$vendor_id = (int)$_POST['vendor_id'];
$item_id = (int)$_POST['item_id'];
$deal_type = pg_escape_string($conn, $_POST['deal_type']);
$amount = floatval($_POST['amount']);
$start_date = pg_escape_string($conn, $_POST['start_date']);
$end_date = pg_escape_string($conn, $_POST['end_date']);

// Insert into deals table (make sure you have 'item_id' and 'amount' columns)
$query = "
    INSERT INTO deals (vendor_id, item_id, deal_type, amount, start_date, end_date)
    VALUES ($vendor_id, $item_id, '$deal_type', $amount, '$start_date', '$end_date')
";

$result = pg_query($conn, $query);

if ($result) {
    header("Location: display_deals.php");
    exit;
} else {
    echo "<p>Error adding deal: " . pg_last_error($conn) . "</p>";
    echo '<p><a href="create_deal.php">Back to Deal Form</a></p>';
}

pg_close($conn);
?>

