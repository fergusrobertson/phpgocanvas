<?php

// Declare variables
$form_id = {formid};
$webhook_url = "{webhookurl};
$csv_filename = {yourcsvfilename.csv}";


$username = "{gocanvasusername}";
$password = "{gocanvaspassword}";
$csv_file_path = '{pathonservertosavefileto}' . $csv_filename;

// Add an extra 5 minutes (300) to account for the program lag
$timenow = time() + 300;

// Calculate the time minus 12 hours, 13 hours, 1 hour, 15 minutes, and 30 minutes
$tminus30mins = $timenow - 1830;

// Construct the URL to the GoCanvas CSV API
$url = "https://www.gocanvas.com/apiv2/csv.xml?form_id=" . $form_id . "&begin_second=" . $tminus30mins . "&end_second=" . $timenow . "&username=" . $username . "&password=" . $password;

// Get the CSV data from GoCanvas
$source = file_get_contents($url);

// Save the CSV data to the local filesystem
file_put_contents($csv_file_path, $source);

// Check if the file exists and is not empty
if (file_exists($csv_file_path) && filesize($csv_file_path) > 0) {
  // Send a webhook to Make.com to trigger your workflow
  $ch = curl_init($webhook_url);
  curl_exec($ch);
  curl_close($ch);
}

?>
