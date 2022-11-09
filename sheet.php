<?php
use Google\Client;
use Google\Service\Sheets;
// Autoload Composer.
require_once __DIR__ . '\vendor\autoload.php';

$client = new \Google_client();
$client->setApplicationName('Google sheets and PHP');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');
$service = new Google_Service_Sheets($client);

// The ID of the spreadsheet to retrieve data from.
$spreadsheetId = "1nHoaphdA5GDx7bYdJsA1CzHAKhx4eNjrRqkSlPlpiX4";  // TODO: Update placeholder value.

// The A1 notation of the values to retrieve.
$range = "sheet1";  // TODO: Update placeholder value.

 

if(isset($_GET["sid"])){

  $s_id = $_GET["sid"];
  $s_name = $_GET["name"];
  $s_specialize = $_GET["sp"];
  $email = $_GET["email"];

  $values = [
    [$s_id,$s_name,$s_specialize,$email],
  ]; //add the values to be appended
  //execute the request
  $body = new Google_Service_Sheets_ValueRange([
      'values' => $values
  ]);
  $params = [
      'valueInputOption' => 'RAW'
  ];
  $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
  printf("%d cells appended.", $result->getUpdates()->getUpdatedCells());
  $message = "added to google sheet successfuly !";
  header('Location: index.php?message='.$message);
}