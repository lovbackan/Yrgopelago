<?php
require("../hotelFunctions.php");
require("../booking.php");
require_once("headAndHeader.php");
?>
<section class="hero">
    <img class="heroDesktop" src="../pictures/2k/SimonLovbacka_super_luxurious_room_in_space_hotel_view_over_ear_0d67896b-b72d-4bd9-a86a-8e49be89da74.png" />
    <div class="heroInfo">
        <h2>Introducing the Luxury Suite</h2>
        <h3>When money aint a problem</h3>
    </div>
</section>
<section class="sliderSection">
    <div class="slider-wrapper">
        <button class="slide-arrow" id="slide-arrow-prev">
        </button>
        <button class="slide-arrow" id="slide-arrow-next">
        </button>
        <div class="slides-container" id="slides-container">

            <div class="slide">
                <img src="../pictures/2k/SimonLovbacka_super_luxurious_room_in_space_hotel_view_over_ear_0d67896b-b72d-4bd9-a86a-8e49be89da74.png" />
            </div>
            <div class="slide">
                <img src="../pictures/2k/SimonLovbacka_very_luxurious_room_in_space_hotel_view_over_eart_b59543be-40e6-4a11-83fd-5e1fb9d41ce5.png" />
            </div>
            <div class="slide">
                <img src="../pictures/Luxury-room.jpg" />
            </div>
            <div class="slide">
                <img src="../pictures/standard-room.jpg" />
            </div>

            <div class="slide">
                <img src="../pictures/grid5.png" />
            </div>
            <div class="slide">
                <img src="../pictures/grid6.png" />
            </div>

        </div>
    </div>
</section>
<section class="formCalenderSection">
    <div class="formContainer">
        <form id="inputForm" method="post">
            <h2>Make a reservation for luxury room</h2>
            <label for="transferCode">Transfer Code</label>
            <input type="text" name="transferCode" id="transferCode" required class="form-control">
            <label for="name">Arrival</label>
            <input type="date" name="arrival" id="arrival" required class="form-control" min="2023-01-01" max="2023-01-31">
            <label for="name">Departure</label>
            <p>20% discount if u stay longar than one night!</p>
            <input type="date" name="departure" id="departure" required class="form-control" min="2023-01-02" max="2023-01-31">
            <label for="room" class="form-control">Room</label>
            <select required name=room id="room">
                <option disabled selected value=>Select a room!</option>
                <option value="Economy">Economy</option>
                <option value="Standard">Standard</option>
                <option value="Luxury">Luxury</option>
            </select>
            <label for="totalCost" class="form-control">Total Cost $</label>
            <input type="text" name="totalCost" id="totalCost" readonly>
            <div class="checkBoxRow1">
                <label for="offer1" class="form-control">Stargazing from the hotel's observatory: 3$</label>
                <input type="checkbox" id="offer1" name="options[]" value="Stargazing" />
            </div>
            <div class=checkBoxRow2>
                <label for="offer2" class="form-control">Spacewalk with instructor: 5$</label>
                <input type="checkbox" id="offer2" name="options[]" value="Spacewalk" />
            </div>
            <button type="submit" id="bookButton">Book!</button>
        </form>
    </div>
    <div class="calendarSection">
        <div class="calendarBox">
            <?php bookedRoomsCalendar('Luxury'); ?>
        </div>
    </div>
</section>
</body>

</html>
