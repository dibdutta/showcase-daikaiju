<?php
// Migration: fix duplicate is_default=1 rows in tbl_poster_images.
// Root cause: dynamicPosterUpload() did not check for an existing default before
// setting is_default=1 on newly added images, leaving multiple rows with is_default=1
// per poster. For each affected poster we keep the row with the highest poster_image_id
// (most recently added, which was the intended new default) and clear the rest.
define("INCLUDE_PATH", "../");
require_once INCLUDE_PATH . "lib/inc.php";

$db = $GLOBALS['db_connect'];

// Find all fk_poster_id values that have more than one is_default=1 row
$rs = mysqli_query($db,
    "SELECT fk_poster_id, COUNT(*) AS cnt
     FROM tbl_poster_images
     WHERE is_default = '1'
     GROUP BY fk_poster_id
     HAVING cnt > 1"
);

if (!$rs) {
    echo "Query error: " . mysqli_error($db) . "<br>";
    exit;
}

$affected = 0;
while ($row = mysqli_fetch_assoc($rs)) {
    $poster_id = (int)$row['fk_poster_id'];

    // Find the highest poster_image_id that has is_default=1 — keep this one
    $maxRs = mysqli_query($db,
        "SELECT MAX(poster_image_id) AS keep_id
         FROM tbl_poster_images
         WHERE fk_poster_id = $poster_id AND is_default = '1'"
    );
    $maxRow = mysqli_fetch_assoc($maxRs);
    $keep_id = (int)$maxRow['keep_id'];

    // Clear is_default on all OTHER rows with is_default=1 for this poster
    $fix = mysqli_query($db,
        "UPDATE tbl_poster_images
         SET is_default = 0
         WHERE fk_poster_id = $poster_id
           AND is_default = '1'
           AND poster_image_id != $keep_id"
    );

    if ($fix) {
        $changed = mysqli_affected_rows($db);
        echo "poster_id $poster_id: cleared is_default on $changed row(s), kept poster_image_id=$keep_id<br>";
        $affected++;
    } else {
        echo "poster_id $poster_id: update error: " . mysqli_error($db) . "<br>";
    }
}

if ($affected === 0) {
    echo "No duplicate is_default rows found — nothing to fix.<br>";
}

echo "Migration complete.";
