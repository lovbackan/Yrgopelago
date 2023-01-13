<?php
require("./hotelFunctions.php");

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
    //I calculate the cost in javascript but since the json response needs to have a features cost, this code is necessary!


    switch ($features) {
        case '1':
            $featuresCost = 3;
            break;
        case '2':
            $featuresCost = 5;
            break;
        case '1,2':
            $featuresCost = 8;
            break;
        case 'none':
            $featuresCost = 0;
            break;
        default:
            break;
    }

    $transferCodeCheck = checkTransferCode($transferCode, $totalCost);
    // The following code grabs all the arrival and departures for the specific room from the database
    $statement = $db->prepare("SELECT arrival, departure
                  FROM bookings
                  WHERE room = '$room'");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // If result is not empty -> For each row in database check the arrival and departure and create a period variable that stores all the dates inbetween arrival and departure and checks if the submitted dates collides with them.

    if (!empty($result)) {
        foreach ($result as $value) {
            $arrivalDate = $value['arrival'];
            $departureDate = $value['departure'];
            $period = date_range($arrivalDate, $departureDate, "+1 day", "Y-m-d");

            foreach ($period as $value) {
                if ($arrival === $value || $departure === $value) {
                    echo '<script>alert("Sorry the date is currently booked")</script>';
                    $dateFree = false;
                    return;
                } else {
                    $dateFree = true;
                }
            }
        }
    } else {
        //If databank is empty all the dates are free to book!
        $dateFree = true;
    };
    global $dateFree;


    //Check if everything is in order and is good to go! This is the first time that we also check if the departure is after the arrival, if not alert message is sent.
    if ($dateFree === true & $departure > $arrival & is_bool($transferCodeCheck) & $transferCodeCheck === true) {
        $goodToGo = true;
    } else {
        $goodToGo = false;
    }

    //The booking response!
    $bookingResponse = [
        "island" => "Space Shuttle Island",
        "hotel" => "Groundbreaker",
        "arrival_date" => $arrival,
        "departure_date" => $departure,
        "total_cost" => $totalCost,
        "stars" => "3",
        "features" => ["name" => $features, "cost" => $featuresCost],
        "additional_info" => "Thank you for choosing the hotel among the stars!"
    ];

    //If everything is good to go, register the booking and echo the json bookingresponse!
    if (!empty($_POST["options"]) && $goodToGo === true) {
        $deposit = depositToAccount($transferCode);
        $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost,features) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost, $features]);
        header('Content-Type: application/json');
        echo json_encode($bookingResponse);
        die();
    } else if ($goodToGo === true) {
        $deposit = depositToAccount($transferCode);
        $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost) VALUES (?,?,?,?,?)');
        $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost]);
        header('Content-Type: application/json');
        echo json_encode($bookingResponse);
        die();
    };
}
