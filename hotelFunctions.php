<?php
declare(strict_types= 1);
require(__DIR__ . '/vendor/autoload.php');
use GuzzleHttp\Client;



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

$db = connect("hotel.db");
//DENNA KOD FIXAR BOKNINGEN
if (isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"], $_POST["totalCost"], $_POST["offer1"]) || isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"], $_POST["totalCost"])) {
  $transferCode = htmlspecialchars($_POST["transferCode"], ENT_QUOTES);

  //gör en api-anrop för att se om transferCoden är valid lägg in i if sats

  $arrival = $_POST["arrival"];
  $departure = $_POST["departure"];
  $room = $_POST["room"];
  $totalCost = $_POST["totalCost"];
  $offer1 = $_POST["offer1"];

$transferCodeCheck = checkTransferCode($transferCode, $totalCost);

  if ($arrival <= $departure & is_bool($transferCodeCheck) & $transferCodeCheck === true) {
    $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost,offer1) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost, $offer1]);
  } else {
   echo "woops something went wrong";
  }
};


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

//Gör funktion som lägger in pengarna på ditt konto

function depositToAccount(){
$client = new GuzzleHttp\Client();
$options = [
'form_params' => [
"user" => getenv('USER_NAME'), "api_key" => getenv('API_KEY')]];
try {
$response = $client->post("https://www.yrgopelago.se/centralbank/deposit", $options);
$response = $response->getBody()->getContents();
$response = json_decode($response, true);
print_r($response);

}
