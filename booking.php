<?php
//This code does most of the work, on submit, check if transfercode is valid, checks if the posted date is free, checks if everything is goodTogo and then insert the booking into database and transfer money
if (isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"], $_POST["totalCost"])) {
    $transferCode = htmlspecialchars($_POST["transferCode"], ENT_QUOTES);
    $arrival = $_POST["arrival"];
    $departure = $_POST["departure"];
    $room = $_POST["room"];
    $totalCost = $_POST["totalCost"];

    $transferCodeCheck = checkTransferCode($transferCode, $totalCost);

    // this step is neccessary because otherwise it will show an error that features does not exist!
    if (!empty($_POST["options"])) {
        $features = implode(',', $_POST['options']);
    } else {
        $features = "none";
    }
    //I calculate the cost in javascript but since the json response needs to have a features cost, this code is necessary!


    switch ($features) {
        case 'Stargazing':
            $featuresCost = 3;
            break;
        case 'Spacewalk':
            $featuresCost = 5;
            break;
        case 'Stargazing,Spacewalk':
            $featuresCost = 8;
            break;
        case 'none':
            $featuresCost = 0;
            break;
        default:
            break;
    }

    // The following code grabs all the arrival and departures for the specific room from the database. I would like to have this as a function instead but had some problems getting it to work so sadly the code has to be here at the moment!

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

        //If there are no dates booked in the calender the following code makes sure that u can book!
        $dateFree = true;
    };

    // Check if everything is in order and is good to go! This is the first time that we also check if the departure is after the arrival, if not alert message is sent.
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
        depositToAccount($transferCode);
        $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost,features) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost, $features]);
        header('Content-Type: application/json');
        echo json_encode($bookingResponse);
        die();
    } else if ($goodToGo === true) {
        depositToAccount($transferCode);
        $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room,totalCost) VALUES (?,?,?,?,?)');
        $stmt->execute([$transferCode, $arrival, $departure, $room, $totalCost]);
        header('Content-Type: application/json');
        echo json_encode($bookingResponse);
        die();
    };
}
