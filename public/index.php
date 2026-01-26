<?php
// public/index.php

// Optional: require an init.php if you want shared functions, session start, etc.
// require_once __DIR__ . '/../src/init.php';

// Determine which page to load
$page = $_GET['page'] ?? '';

switch ($page) {
    case 'display_vendors':
        require_once __DIR__ . '/../src/display_vendors.php';
        break;

    case 'create_deal':
        require_once __DIR__ . '/../src/create_deal.php';
        break;

    case 'display_deals':
        require_once __DIR__ . '/../src/display_deals.php';
        break;

    case 'add_deal':
        require_once __DIR__ . '/../src/dbconnect.local.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $vendor_id  = $_POST['vendor_id'] ?? null;
            $item_id    = $_POST['item_id'] ?? null;
            $deal_type  = $_POST['deal_type'] ?? '';
            $amount     = $_POST['amount'] ?? 0;
            $start_date = $_POST['start_date'] ?? null;
            $end_date   = $_POST['end_date'] ?? null;

            if (!$vendor_id || !$item_id || !$start_date || !$end_date) {
                die("Missing required fields.");
            }

            $query = "INSERT INTO deals (vendor_id, item_id, deal_type, amount, start_date, end_date)
                      VALUES ($1, $2, $3, $4, $5, $6)";
            $result = pg_query_params($conn, $query, [
                $vendor_id, $item_id, $deal_type, $amount, $start_date, $end_date
            ]);

            if (!$result) {
                die("Error adding deal: " . pg_last_error($conn));
            }

            // Redirect to view deals
            header("Location: index.php?page=display_deals");
            exit;

        } else {
            // GET request → show the create deal form
            require_once __DIR__ . '/../src/create_deal.php';
        }
        break;

    default:
        // Default home page HTML
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>CheechMart</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <h1>CheechMart</h1>
            <p>Core Retail Engine</p>
            <nav>
                <a href="index.php?page=display_vendors">View Vendors</a>
                <a href="index.php?page=create_deal">Create Deal</a>
                <a href="index.php?page=display_deals">View Deals</a>
                <a href="index.php?page=add_deal">Add Deal</a>
            </nav>
        </body>
        </html>
        <?php
        break;
}

