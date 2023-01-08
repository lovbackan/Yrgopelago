<?php

declare(strict_types=1);
require(__DIR__ . '/vendor/autoload.php');

use GuzzleHttp\Client;

require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

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
        return "Failed to connect to the database";
        throw $e;
    }
    // return "DB conncetion works";
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
function date_range($first, $last, $step = '+1 day', $output_format = 'd-m-Y')
{

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while ($current <= $last) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }
    return ($dates);
}

//Function that checks if transfercode is valid and returns true if it is.
function checkTransferCode($transferCode, $totalCost): string | bool
{
    if (!isValidUuid($transferCode)) {
        echo '<script>alert("Invalid transfer code format")</script>';
        // return "Invalid transferCode format";
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
            echo '<script>alert("Transfer code is not valid")</script>';
            // return "Error occured!" . $e;
            return false;
        }
        if (array_key_exists("error", $response)) {
            if ($response["error"] == "Not a valid GUID") {
                //The banks error message for a transferCode not being valid for enough can be misleading.
                echo '<script>alert("Transfer code is not valid")</script>';
                // return "An error has occured! $response[error]. This could be due to your Transfercode not being vaild for enough credit.";
                return false;
            }
            // return "An error has occured! $response[error]";
            return false;
        }
        if (!array_key_exists("amount", $response) || $response["amount"] < $totalCost) {
            echo '<script>alert("Sorry your transfer code does not contain enough money")</script>';
            // return "Transfer code is not valdid for enough money.";
            return false;
        }
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
        return "Error occured!" . $e;
    }
};

//Function that checks the database for the specific room and creates a calender where the booked dates are red!
function bookedRooms($roomKind)
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
    echo $roomKind->display(date('Y-01-01'));

    die();
};


//This code does most of the work, on submit, check if transfercode is valid, checks if the posted date is free, checks if
if (isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"], $_POST["totalCost"])) {
    $transferCode = htmlspecialchars($_POST["transferCode"], ENT_QUOTES);
    $arrival = $_POST["arrival"];
    $departure = $_POST["departure"];
    $room = $_POST["room"];
    $totalCost = $_POST["totalCost"];

    // this step is neccessary because otherwise it will show an error that features does not exist!
    if (!empty($_POST["options"])) {
        $features = implode(',', $_POST['options']);
    } else {
        $features = "none";
    }


    $transferCodeCheck = checkTransferCode($transferCode, $totalCost);
    // The following code grabs all the arrival and departures for the specific room from the database
    $statement = $db->prepare("SELECT arrival, departure
                  FROM bookings
                  WHERE room = '$room'");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // For each row in database check the arrival and departure and create a period variable that stores all the dates inbetween arrival and departure and checks if the submitted dates collides with them.

    if (!empty($result)) {
        foreach ($result as $value) {
            $arrivalDate = $value['arrival'];
            $departureDate = $value['departure'];
            $period = date_range($arrivalDate, $departureDate, "+1 day", "Y-m-d");

            foreach ($period as $value) {
                if ($arrival === $value || $departure === $value) {
                    echo '<script>alert("Sorry the date is currently booked")</script>';
                    $dateFree = false;
                    return "Sorry the date is currently booked";
                } else {
                    $dateFree = true;
                }
            }
        }
    } else {
        $dateFree = true;
    };
    global $dateFree;

    //Check if everything is in order and is good to go!
    if ($dateFree === true & $arrival < $departure & is_bool($transferCodeCheck) & $transferCodeCheck === true) {
        $goodToGo = true;
    } else {
        $goodToGo = false;
        echo '<script>alert("Woops something went wrong with your booking please try again!")</script>';
    }

    //The booking response!
    $bookingResponse = [
        "island" => "Spaceshuttle island",
        "hotel" => "Groundbreaker",
        "arrival_date" => $arrival,
        "departure_date" => $departure,
        "total_cost" => $totalCost,
        "stars" => "3",
        "features" => $features,
        "additional_info" => "Thank you for chosing Groundbreaker as your hotel of choice!"
    ];

    //If everything is good to go, register the booking and echo the json bookingresponse!
    if (!empty($_POST["options"]) && $goodToGo === true) {
        $deposit = depositToAccount($transferCode);
        $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost,features) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost, $features]);
        echo json_encode($bookingResponse);
        die();
    } else if ($goodToGo === true) {
        $deposit = depositToAccount($transferCode);
        $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost) VALUES (?,?,?,?,?)');
        $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost]);
        echo json_encode($bookingResponse);
        die();
    };
}
