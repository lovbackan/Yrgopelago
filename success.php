<?php
require("./hotelFunctions.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="styles.css" rel="stylesheet" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Groundbreaker</title>
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
    <h1>Your booking is successfull, we hope you enjoy your stay!</h1>
    <h2>Info</h2>

    <?php echo $bookingResponse; ?>

</body>

</html>
