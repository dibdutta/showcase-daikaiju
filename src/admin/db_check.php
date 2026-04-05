<?php
// Temporary diagnostic script - remove after use
if (!isset($_GET['token']) || $_GET['token'] !== 'mpe_dbcheck_2026') {
    http_response_code(403);
    exit('Forbidden');
}

define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/dbconfig.php";

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
if (!$db) {
    die("DB connection failed: " . mysqli_connect_error());
}
mysqli_query($db, "SET time_zone = 'America/New_York'");
$GLOBALS['db_connect'] = $db;

header('Content-Type: text/plain');

// --- Raw SQL checks ---
$queries = [
    "Sold archive count" =>
        "SELECT COUNT(*) AS cnt FROM tbl_sold_archive",

    "Sold auctions (auction_is_sold IN 1,2)" =>
        "SELECT COUNT(*) AS cnt FROM tbl_auction WHERE auction_is_sold IN ('1','2')",

    "Slider join (homePageSoldSlider eligible)" =>
        "SELECT COUNT(*) AS cnt
         FROM tbl_auction a
         INNER JOIN tbl_sold_archive tsa ON a.auction_id = tsa.auction_id
         INNER JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
         WHERE a.auction_is_sold IN ('1','2')",

    "First-position slider poster" =>
        "SELECT COUNT(*) AS cnt
         FROM tbl_auction a
         INNER JOIN tbl_sold_archive tsa ON a.auction_id = tsa.auction_id
         INNER JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
         WHERE a.slider_first_position_status = '1'
         AND a.auction_is_sold IN ('1','2')",

    "Sample rows (up to 5)" =>
        "SELECT a.auction_id, p.poster_title, tsa.soldamnt, a.auction_is_sold, tsa.poster_thumb
         FROM tbl_auction a
         INNER JOIN tbl_sold_archive tsa ON a.auction_id = tsa.auction_id
         INNER JOIN tbl_poster p ON a.fk_poster_id = p.poster_id
         WHERE a.auction_is_sold IN ('1','2')
         LIMIT 5",
];

foreach ($queries as $label => $sql) {
    echo "=== $label ===\n";
    $rs = mysqli_query($db, $sql);
    if (!$rs) {
        echo "ERROR: " . mysqli_error($db) . "\n\n";
        continue;
    }
    while ($row = mysqli_fetch_assoc($rs)) {
        echo implode(" | ", array_map(fn($k, $v) => "$k: $v", array_keys($row), $row)) . "\n";
    }
    echo "\n";
}

// --- Actual function call ---
echo "=== homePageSoldSlider() function call ===\n";
require_once INCLUDE_PATH . "classes/DBCommon.php";
require_once INCLUDE_PATH . "classes/Auction.php";
$objAuction = new Auction();
$result = $objAuction->homePageSoldSlider();

if ($result === false) {
    echo "RETURNED: false (second query failed)\n";
    echo "DB error: " . mysqli_error($db) . "\n";
} elseif (empty($result)) {
    echo "RETURNED: empty array\n";
} else {
    echo "RETURNED: " . count($result) . " rows\n";
    foreach (array_slice($result, 0, 3) as $row) {
        echo implode(" | ", array_map(fn($k, $v) => "$k: $v", array_keys($row), $row)) . "\n";
    }
}

mysqli_close($db);
