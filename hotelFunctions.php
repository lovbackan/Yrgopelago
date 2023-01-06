<?php
declare(strict_types= 1);
require(__DIR__ . '/vendor/autoload.php');
use GuzzleHttp\Client;
require 'vendor/autoload.php';
use benhall14\phpCalendar\Calendar as Calendar;



function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec("CREATE TABLE IF NOT EXISTS bookings(
                    id INTEGER primary key,
                    transferCode TEXT,
                    arrival DATE,
                    departure DATE,
                    room TEXT,
                    totalCost INTEGER,
                    offer1 TEXT
                )");
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
        throw $e;
    }
    echo "DB conncetion works";
    return $db;
}

$db = connect("hotel.db");

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}


function date_range($first, $last, $step = '+1 day', $output_format = 'd-m-Y' ) {

$dates = array();
$current = strtotime($first);
$last = strtotime($last);

while( $current <= $last ) {

$dates[] = date($output_format, $current);
$current = strtotime($step, $current);
}
return($dates);
}





//Funktion som kollar transferCode
function checkTransferCode($transferCode, $totalCost): string | bool
{
if (!isValidUuid($transferCode)) {
return "Invalid transferCode format";
} else {
$client = new GuzzleHttp\Client();
$options = [
'form_params' => [
"transferCode" => $transferCode, "totalcost" => $totalCost]];
try {
$response = $client->post("https://www.yrgopelago.se/centralbank/transferCode", $options);
$response = $response->getBody()->getContents();
$response = json_decode($response, true);
print_r($response);
} catch (\Exception $e) {
return "Error occured!" . $e;}
if (array_key_exists("error", $response)) {
if ($response["error"] == "Not a valid GUID") {
 //The banks error message for a transferCode not being valid for enough can be misleading.
return "An error has occured! $response[error]. This could be due to your Transfercode not being vaild for enough credit.";}
return "An error has occured! $response[error]";}
if (!array_key_exists("amount", $response) || $response["amount"] < $totalCost) {
return "Transfer code is not valdid for enough money.";}}
return true;
}

//Gör funktion som lägger in pengarna på ditt konto. DENNA FUNKAR INTE!

function depositToAccount($transferCode): string | bool {
$client = new GuzzleHttp\Client();
$options = [
'form_params' => [
"user" => "Simon",
"transferCode" => $transferCode]
];
try {
$result = $client->post("https://www.yrgopelago.se/centralbank/deposit", $options);
$result = $result->getBody()->getContents();
$result = json_decode($result, true);
return true;
} catch (\Exception $e) {
return "Error occured!" . $e;}
};

// Funtion som plockar ut bokade datum i datubasen för det specifika rummet och målar upp en kalender
function bookedRooms ($roomKind) {
global $db;
$statement = $db->prepare("SELECT arrival, departure
FROM bookings
WHERE room = '$roomKind'");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$roomKind = new Calendar;
$roomKind->useSundayStartingDate();

foreach ($result as $value){
$arrivalDate = $value['arrival'];
$departureDate = $value['departure'];
$roomKind->addEvent($arrivalDate, $departureDate, '', true);
echo $arrivalDate, $departureDate;
}
echo $roomKind->display(date('Y-m-d'));

die();

};


//DENNA KOD FIXAR BOKNINGEN
if (isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"], $_POST["totalCost"], $_POST["offer1"]) || isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"], $_POST["totalCost"])) {


                    $transferCode = htmlspecialchars($_POST["transferCode"], ENT_QUOTES);
                    $arrival = $_POST["arrival"];
                    $departure = $_POST["departure"];
                    $room = $_POST["room"];
                    $totalCost = $_POST["totalCost"];
                    $offer1 = $_POST["offer1"];


                  $transferCodeCheck = checkTransferCode($transferCode, $totalCost);



                  // Kolla så att datumet inte redan är bokat
                  global $db;
                   global $dateFree;
                  $statement = $db->prepare("SELECT arrival, departure
                  FROM bookings
                  WHERE room = '$room'");
                  $statement->execute();
                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                  $dateFree = true;

                  foreach ($result as $value){
                  $arrivalDate = $value['arrival'];
                  $departureDate = $value['departure'];
                  $period = date_range($arrivalDate, $departureDate, "+1 day", "Y-m-d");

                  foreach ($period as $value) {
                  if ($arrival === $value || $departure === $value){
                  Echo "Sorry the date is currently booked";
                  $dateFree = false;}
                  }
                  }


                    if ($dateFree === true & $arrival < $departure & is_bool($transferCodeCheck) & $transferCodeCheck === true) {
                    //Min deposit funktion fungerar ej!
                    $deposit = depositToAccount($transferCode);
                      $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost,offer1) VALUES (?,?,?,?,?,?)');
                      $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost, $offer1]);
                      echo "Booking successfull";


                      die();

                    } else {
                     echo "woops something went wrong";
                     die();
                    }
                  };

//  $bookingResponse = [
// "island" => "Spaceshuttle island",
// "hotel" => "Groundbreaker",
// "arrival_date" => $arrival,
// "departure_date" => $departure,
// "total_cost" => $totalCost,
// "stars" => $stars,
// "features" => $features,
// "additional_info" => "Very good. Enjoy your stay. But not too much, you might never leave."];
//  echo json_encode($bookingResponse);






