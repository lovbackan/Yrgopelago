<?php
    session_start();
    require_once('./hotelFunctions.php');
    require('./handelStars.php');

    // die(var_dump(getStar($db)['star']));
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
