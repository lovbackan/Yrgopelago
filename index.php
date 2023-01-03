<?php
require("./hotelFunctions.php");
$db = connect("hotel.db");

if (isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"])) {
  $transferCode = htmlspecialchars($_POST["transferCode"], ENT_QUOTES);
  //gör en api-anrop för att se om transferCoden är valid lägg in i if sats

  $arrival = $_POST["arrival"];
  $departure = $_POST["departure"];
  $room = $_POST["room"];

  if ($arrival <= $departure) {
    $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room) VALUES (?,?,?,?)');
    $stmt->execute([$transferCode, $arrival, $departure, $room]);
  } else {
    //     echo '<script>alert("Sorry either the transfercode was wrong or you booked a weird date")</script>';
  }
};


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link href="styles.css" rel="stylesheet" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
</head>

<body>
  <h1>Under Construction!</h1>
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
    <label for="price" class="form-control">Price</label>
    <input type="text" name="price" id="price" readonly>
    <!-- make a price tab -->
    <button type="submit">Book!</button>
    <label for="offer1" class="form-control">Offer 1</label>
    <input type="checkbox" name="offer1" value="Yes" />
    <label for="offer2" class="form-control">Offer 2</label>
    <input type="checkbox" name="offer2" value="Yes" />
    <label for="offer3" class="form-control">Offer 3</label>
    <input type="checkbox" name="offer3" value="Yes" />
  </form>
  <script src="script.js"></script>
</body>

</html>
