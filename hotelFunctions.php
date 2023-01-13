<?php

declare(strict_types=1);

use GuzzleHttp\Client;

require(__DIR__ . '/vendor/autoload.php');

use benhall14\phpCalendar\Calendar as Calendar;

// $errors;

function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails. If connection works then create the tables for the database if they dont already exists.
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
                    features TEXT
                )");
    } catch (PDOException $e) {
        echo '<script>alert("Failed to connect to database")</script>';
        return "fail";
        throw $e;
    }
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

//Function that checks the date range between two dates!
function date_range($first, $last, $step = '+1 day', $output_format = 'd-m-Y'): array
{

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while ($current < $last) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }
    return ($dates);
}

//Function that checks if transfercode is valid and returns true if it is.
function checkTransferCode($transferCode, $totalCost): string | bool
{
    if (!isValidUuid($transferCode)) {
        echo '<script>alert("Invalid transfer code format");</script>';
        return false;
    } else {
        $client = new GuzzleHttp\Client();
        $options = [
            'form_params' => [
                "transferCode" => $transferCode, "totalcost" => $totalCost
            ]
        ];
        try {
            $response = $client->post("https://www.yrgopelago.se/centralbank/transferCode", $options);
            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);
        } catch (\Exception $e) {
            echo '<script>alert("Woops, problem with connection to API! Please contact Admin!)</script>';
            return false;
        }
        if (!array_key_exists("amount", $response) || $response["amount"] < $totalCost) {
            echo '<script>alert("Oh no! Either your transfer code has already been used, or the value of ur transferCode is lower than your bookings totalcost")</script>';
            return false;
        };
    }
    return true;
}

//Function that deposit the money to my bank account

function depositToAccount($transferCode): string | bool
{
    $client = new GuzzleHttp\Client();
    $options = [
        'form_params' => [
            "user" => "Simon",
            "transferCode" => $transferCode
        ]
    ];
    try {
        $result = $client->post("https://www.yrgopelago.se/centralbank/deposit", $options);
        $result = $result->getBody()->getContents();
        $result = json_decode($result, true);
        return true;
    } catch (\Exception $e) {
        echo '<script>alert("Something went wrong with the deposit!")</script>';
    }
};

//Function that checks the database for the specific room and creates a calender where the booked dates are red!
function bookedRooms($roomKind): void
{
    global $db;
    $statement = $db->prepare("SELECT arrival, departure
FROM bookings
WHERE room = '$roomKind'");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $roomKind = new Calendar;
    $roomKind->useSundayStartingDate();

    foreach ($result as $value) {
        $arrivalDate = $value['arrival'];
        $departureDate = $value['departure'];
        $roomKind->addEvent($arrivalDate, $departureDate, '', true);
    }
    echo $roomKind->display(date('Y-01-01'), 'grey');
    //Behövs verkligen denna die?
    die();
};
