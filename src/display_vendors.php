<?php
// Load database connection from local config
require_once 'dbconnect.local.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Vendor List</h1>

<?php
// Query the vendors table
$query = "SELECT * FROM vendors";
$result = pg_query($conn, $query);

if (!$result) {
    echo "<p>Query failed.</p>";
    exit;
}

// Fetch the first row to generate table headers
$first = pg_fetch_assoc($result);

if ($first) {
    echo "<table>";
    echo "<tr>";
    foreach ($first as $col => $val) {
        echo "<th>" . htmlspecialchars($col) . "</th>";
    }
    echo "</tr>";

    // Output the first row
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
    echo "<p>No vendors found in the database.</p>";
}

// Close the connection
pg_close($conn);
?>

<p><a href="../public/index.html">Back to home</a></p>

</body>
</html>

