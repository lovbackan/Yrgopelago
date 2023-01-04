<?php
require("./hotelFunctions.php");
require(__DIR__ . '/vendor/autoload.php');
use benhall14\phpCalendar\Calendar as Calendar;

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
    <input type="checkbox" id="offer1"name="offer1" value="1" />
  </form>
  <script src="script.js"></script>
  <?php
$calendar = new Calendar;
$calendar->useSundayStartingDate();
$events = array();
$calendar->addEvent(
                    '2023-01-14',   # start date in either Y-m-d or Y-m-d H:i if you want to add a time.
                    '2023-01-18',   # end date in either Y-m-d or Y-m-d H:i if you want to add a time.
                    'My Birthday',  # event name text
                    true,           # should the date be masked - boolean default true
                    ['myclass', 'abc']   # (optional) additional classes in either string or array format to be included on the event days
                );
echo $calendar->display(date('Y-m-d')); # draw this months calendar

  ?>
</body>

</html>
