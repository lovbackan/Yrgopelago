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

    <main>
        <section class="hero">
            <img class="heroDesktop" src="./pictures/2k/retouchedHero1.jpg" />
            <div class="heroInfo">
                <h2>Welcome to The Groundbreaker</h2>
                <h3>A hotel among the stars</h3>
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
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/Y1qQZbTF8iQ?&autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="slide">
                        <img src="./pictures/2k/retouchedHero.jpg" />
                    </div>
                    <div class="slide">
                        <img src="./pictures/hero-home-original.jpg" />
                    </div>
                    <div class="slide">
                        <img src="./pictures/hotelGrid.png" />
                    </div>

                </div>
            </div>
        </section>
        <section class="island">
            <div class="islandInfo">
                <div class="islandInfoHeading">
                    <h2>Space Shuttle Island</h2>
                    <h3>Your destination on Earth to reach the stars</h3>
                </div>
                <p>
                    Have you ever wanted to experience the ultimate adventure? Imagine taking a luxurious space shuttle to the world's first space hotel located 250 miles above the Earth's surface. This is more than just a dream, it's now a reality. Welcome to The Groundbreaker Hotel!
                </p>
                <p>
                    This incredible space hotel provides guests with the opportunity to experience the wonders of space travel up close. The space hotel is equipped with state-of-the-art technology, allowing you to explore the universe in an exciting and unique way. You can take part in space walks, view the Earth from a unique perspective, and get up close and personal with the stars. Experience gravity approximately 1/6 of Earth's onboard the Groundbreaker.
                </p>
                <p>
                    Your journey begins with a first-class flight on a space shuttle departing from Space Shuttle Island. The shuttle is equipped with the most advanced technology, ensuring a safe and comfortable journey in style.
                </p>
                <p>
                    This is your chance to experience a once in a lifetime adventure. So, grab your passport and prepare to embark on an unforgettable journey to The Groundbreaker Hotel!
                </p>
            </div>
            <img class="spaceShuttlePicture" src="./pictures/Hero-space-shuttle.jpg" />
        </section>

    </main>
</body>

</html>
