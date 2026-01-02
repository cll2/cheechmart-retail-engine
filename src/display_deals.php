<?php
require_once 'dbconnect.local.php';

// Join deals with vendors items and amounts
$query = "
    SELECT 
        d.deal_id, 
        v.name AS vendor_name, 
        i.description, 
        d.deal_type, 
        d.amount, 
        d.start_date, 
        d.end_date
    FROM deals d
    JOIN vendors v ON d.vendor_id = v.vendor_id
    JOIN items i ON d.item_id = i.item_id
    ORDER BY d.start_date DESC
";


$result = pg_query($conn, $query);

if (!$result) {
    echo "<p>Query failed: " . pg_last_error($conn) . "</p>";
    exit;
}

$first = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deals</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>

<h1>Deal List</h1>

<?php
if ($first) {
    echo "<table>";
    echo "<tr>";
    foreach ($first as $col => $val) {
        echo "<th>" . htmlspecialchars($col) . "</th>";
    }
    echo "</tr>";

    // Output first row
    echo "<tr>";
    foreach ($first as $val) {
        echo "<td>" . htmlspecialchars($val) . "</td>";
    }
    echo "</tr>";

    // Output remaining rows
    while ($row = pg_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $val) {
            echo "<td>" . htmlspecialchars($val) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No deals found in the database.</p>";
}

pg_close($conn);
?>

<p>
<a href="create_deal.php">Add New Deal</a>
<a href="../public/index.html">Home</a>

</p>


</body>
</html>
