<?php
require("./hotelFunctions.php");
session_start();


if (!isset($_SESSION['name'])) {
    redirect('index.php');
}
require('./handelStars.php');

// die(var_dump(getStar($db)["star"]));
$star = getStar($db)['star'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script defer src="../script.js"></script>

    <!-- Font Awesome ikon pack -->
    <script src="https://kit.fontawesome.com/a913f4ac89.js" crossorigin="anonymous"></script>

    <link href="../styles.css" rel="stylesheet" />
    <link href="../fonts.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/vendor/benhall14/php-calendar/html/css/calendar.css">

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Groundbreaker</title>
</head>

<body>
    <header>
        <a href="../index.php">
            <h1>Groundbreaker</h1>
        </a>

        <!-- sign in form -->
        <?php if (!isset($_SESSION['name'])): ?>
        <form action="/handle-login.php" method="post">
            <label for="name">User name</label>
            <input id="name" name="name" type="text">

            <label for="password">Password</label>
            <input type="password" name="password" pattern="^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$" id="password">
            <button type="submit" name="submit" id="bookButton">Sign in</button>
        </form>
        <?php endif ?>

        <section>
            <?php for ($i = 0; $i < 5; $i++): ?>
            <?php if ($i < $star): ?>
            <i class="fa-2xl fa-solid fa-star"></i>
            <?php else: ?>
            <i class="fa-2xl fa-regular fa-star"></i>
            <?php endif ?>
            <?php endfor ?>
        </section>

        <nav>
            <div class="navInfo">
                <?php if (isset($_SESSION['name'])): ?>
                <a href="./hotel-manager.php">Admin</a>
                <a href="./handle-sign-out.php">Sign out</a>
                <?php endif ?>

                <a href="./roomPages/economy.php">Economy</a>
                <a href="./roomPages/standard.php">Standard</a>
                <a class="lastNavItem" href="./roomPages/luxury.php">Luxury</a>
            </div>

        </nav>

    </header>
    <main class="hotel-manager-main">
        <section>
            <h2>The Groundbreaker Hotel Lets You Choose Your Own Level of Luxury</h2>
            <p>At the Groundbreaker hotel, the stars are in your hands! Want to live like
                royalty with five-star service and luxury, or perhaps you prefer a simpler
                three-star experience with a more relaxed atmosphere? We've got it all!
            </p>
        </section>


        <svg viewBox="0 0 746 746" fill="none">
            <circle class="sun" cx="374.595" cy="374.595" r="78.9983" fill="#FDE617"/>
            <ellipse cx="374.326" cy="373.578" rx="163.065" ry="163.472" stroke="white" stroke-dasharray="6 6"/>
            <ellipse class="planet" cx="374.95" cy="374" rx="19.9502" ry="20" fill="#FFBE5E"/>
            <ellipse cx="373.105" cy="373.366" rx="233.105" ry="233.366" stroke="white" stroke-dasharray="6 6"/>
            <ellipse class="planet" cx="374.978" cy="373" rx="19.9776" ry="20" fill="#FD9E10"/>
            <circle cx="373.578" cy="373.578" r="302.106" stroke="white" stroke-dasharray="6 6"/>
            <circle class="planet" cx="375" cy="374" r="20" fill="#17FDB8"/>
            <ellipse cx="372.893" cy="373" rx="371.893" ry="372" stroke="white" stroke-dasharray="6 6"/>
            <circle class="planet" cx="375" cy="373" r="20" fill="#FD1717"/>
        </svg>
    </main>
</body>

</html>
