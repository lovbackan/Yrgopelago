<?php
require("./hotelFunctions.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="styles.css" rel="stylesheet" />
    <script defer src="./script.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Economy Room</title>
</head>

<body>
    <header>
        <nav>
            <a href="./index.php">Home</a>
            <a href="./standard.php">Standard</a>
            <a href="./economy.php">Economy</a>
            <a href="./luxury.php">Luxury</a>
        </nav>
    </header>

    <h1>Under Construction!</h1>
    <h2>30% discount if you stay longer than one night!</h2>
    <form id="inputForm" method="post">
        <label for="transferCode">Transfer Code</label>
        <input type="text" name="transferCode" id="transferCode" required class="form-control">
        <label for="name">Arrival</label>
        <input type="date" name="arrival" id="arrival" required class="form-control" min="2023-01-01" max="2023-01-31">
        <label for="name">Departure</label>
        <input type="date" name="departure" id="departure" required class="form-control" min="2023-01-01" max="2023-01-31">
        <label for="room" class="form-control">Room</label>
        <select required name=room id="room">
            <option disabled selected value>Select a room!</option>
            <option value="Economy">Economy</option>
            <option value="Standard">Standard</option>
            <option value="Luxury">Luxury</option>
        </select>
        <label for="totalCost" class="form-control">Total Cost</label>
        <input type="text" name="totalCost" id="totalCost" readonly>
        <button type="submit">Book!</button>
        <label for="offer1" class="form-control">Offer 1</label>
        <input type="checkbox" id="offer1" name="options[]" value="1" />
        <label for="offer2" class="form-control">Offer 2</label>
        <input type="checkbox" id="offer2" name="options[]" value="2" />
        <label for="offer3" class="form-control">Offer 3</label>
        <input type="checkbox" id="offer3" name="options[]" value="3" />
    </form>
    <h2>Economy</h2>
    <?php bookedRooms('Economy'); ?>
</body>

</html>
