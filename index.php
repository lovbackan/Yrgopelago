<?php
require("./hotelFunctions.php");
$db = connect("hotel.db");

if (isset($_POST["transferCode"], $_POST["arrival"], $_POST["departure"], $_POST["room"])) {
  $transferCode = htmlspecialchars($_POST["transferCode"], ENT_QUOTES);
  //gör en api-anrop för att se om transferCoden är valid
  $arrival = $_POST["arrival"];
  $departure = $_POST["departure"];
  $room = $_POST["room"];
  $stmt = $db->prepare('INSERT INTO bookings(transferCode,arrival,departure,room) VALUES (?,?,?,?)');
  $stmt->execute([$transferCode, $arrival, $departure, $room]);
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
  <form method="post">
    <label for="transferCode">Transfer Code</label>
    <input type="text" name="transferCode" id="transferCode" required class="form-control">
    <label for="name">Arrival</label>
    <input type="date" name="arrival" id="arrival" required class="form-control" min="2023-01-01" max="2023-01-31">
    <label for="name">Departure</label>
    <input type="date" name="departure" id="departure" required class="form-control" min="2023-01-01" max="2023-01-31">
    <label for="room" class="form-control">Room</label>
    <select required name=room>
      <option disabled selected value>Select a room!</option>
      <option value="Economy">Economy</option>
      <option value="Standard">Standard</option>
      <option value="Luxury">Luxury</option>
    </select>
    <button type="submit">Book!</button>
  </form>
  <script src="script.js"></script>
</body>

</html>
