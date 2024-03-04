<?php

// Define constants for sensitive data (improve security)
define('GOCANVAS_FORM_ID', '{formid}');
define('WEBHOOK_URL', '{webhookurl}');
define('CSV_FILENAME', 'yourcsvfilename.csv');

// Credentials (replace with actual values)
$username = '{gocanvasusername}';
$password = '{gocanvaspassword}';

// Construct file path dynamically
$csv_file_path = __DIR__ . '/' . CSV_FILENAME; // Use __DIR__ for current directory path

// Calculate time window
$now = time();
$past30Mins = $now - 1800;

// Build GoCanvas API URL
$url = "https://www.gocanvas.com/apiv2/csv.xml?form_id=" . GOCANVAS_FORM_ID . "&begin_second=" . $past30Mins . "&end_second=" . $now . "&username=" . $username . "&password=" . $password;

// Fetch and save CSV data
$csvData = file_get_contents($url);
file_put_contents($csv_file_path, $csvData);

// Send webhook notification if file exists and is not empty
if (file_exists($csv_file_path) && filesize($csv_file_path) > 0) {
    $ch = curl_init(WEBHOOK_URL);
    curl_exec($ch);
    curl_close($ch);
}

?>

