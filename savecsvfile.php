<?php

// Declare variables
$form_id = {formid};
$webhook_url = "{webhookurl};
$csv_filename = {yourcsvfilename.csv}";


$username = "{gocanvasusername}";
$password = "{gocanvaspassword}";
$csv_file_path = '{pathonservertosavefileto}' . $csv_filename;

// Grab the current time in seconds
$timenow = time();

// add 30 mins to it
$tminus30mins = $timenow - 1800;

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
