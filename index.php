<?php
require("./hotelFunctions.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="styles.css" rel="stylesheet" />
    <link href="fonts.css" rel="stylesheet" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script defer src="./script.js"></script>
    <title>Groundbreaker</title>
</head>

<body>

    <header>
        <nav>
            <h2>Groundbreaker</h2>
            <div class="navInfo">
                <a href="./index.php">Home</a>
                <a href="./standard.php">Standard</a>
                <a href="./economy.php">Economy</a>
                <a href="./luxury.php">Luxury</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="hero">
            <img class="heroDesktop" src="/pictures/hero-home.jpg" />
            <div class="heroInfo">
                <h2>Welcome to the Groundbreaker</h2>
                <p>A hotel among the stars</p>
                <button class="buy">Make reservation</button>
            </div>
        </section>

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
    </main>
</body>

</html>
