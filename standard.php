<?php
require("./hotelFunctions.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="styles.css" rel="stylesheet" />
    <link href="fonts.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/vendor/benhall14/php-calendar/html/css/calendar.css">
    <script defer src="./script.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Standard Room</title>
</head>

<body>
    <header>
        <nav>
            <h2>Groundbreaker</h2>
            <div class="navInfo">
                <a href="./index.php">Home</a>
                <a href="./economy.php">Economy</a>
                <a href="./standard.php">Standard</a>
                <a href="./luxury.php">Luxury</a>
            </div>
        </nav>
    </header>

    <section class="hero">
        <img class="heroDesktop" src="/pictures/2k/SimonLovbacka_budget_room_in_space_hotel_view_over_earth_stunni_01029d48-87c5-4def-b308-89366b635feb.png" />
        <div class="heroInfo">
            <h2>Introducing the Standard Room</h2>
            <p>When you just are looking for standard </p>
            <button class="buy">Make reservation</button>
        </div>
    </section>

    <div class="slider-wrapper">
        <button class="slide-arrow" id="slide-arrow-prev">
            &#8249;
        </button>
        <button class="slide-arrow" id="slide-arrow-next">
            &#8250;
        </button>
        <div class="slides-container" id="slides-container">
            <div class="slide">
                <img src="/Pictures/2k/SimonLovbacka_budget_room_in_space_hotel_view_over_earth_stunni_01029d48-87c5-4def-b308-89366b635feb.png" />
            </div>

            <div class="slide">
                <img src="/Pictures/2k/standard-room-upscaled.jpg" />
            </div>
            <div class="slide">
                <img src="/Pictures/gridPicture.png" />
            </div>
            <div class="slide">
                <img src="/Pictures/grid2.png" />
            </div>
            <div class="slide">
                <img src="/Pictures/grid4.png" />
            </div>
            <div class="slide">
                <img src="/Pictures/grid3.png" />
            </div>
            <div class="slide">
                <img src="/Pictures/grid8.png" />
            </div>

        </div>
    </div>
    <section class="formCalenderSection">
        <form id="inputForm" method="post">
            <h2>Make a reservation</h2>
            <label for="transferCode">Transfer Code</label>
            <input type="text" name="transferCode" id="transferCode" required class="form-control">
            <label for="name">Arrival</label>
            <input type="date" name="arrival" id="arrival" required class="form-control" min="2023-01-01" max="2023-01-31">
            <label for="name">Departure</label>
            <input type="date" name="departure" id="departure" required class="form-control" min="2023-01-01" max="2023-01-31">
            <label for="room" class="form-control">Room</label>
            <select required name=room id="room">
                <option disabled selected value=>Select a room!</option>
                <option value="Economy">Economy</option>
                <option value="Standard">Standard</option>
                <option value="Luxury">Luxury</option>
            </select>
            <label for="totalCost" class="form-control">Total Cost</label>
            <input type="text" name="totalCost" id="totalCost" readonly>
            <div class="checkBoxRow">
                <label for="offer1" class="form-control">Offer 1</label>
                <input type="checkbox" id="offer1" name="options[]" value="1" />
                <label for="offer2" class="form-control">Offer 2</label>
                <input type="checkbox" id="offer2" name="options[]" value="2" />
            </div>
            <button type="submit" id="bookButton">Book!</button>
        </form>
        <div class="calendarSection">
            <div class="calendarBox">
                <?php bookedRooms('Standard'); ?>
            </div>
        </div>
    </section>
</body>

</html>
