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
                <a href="./economy.php">Economy</a>
                <a href="./standard.php">Standard</a>
                <a href="./luxury.php">Luxury</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="hero">
            <img class="heroDesktop" src="/pictures/2k/retouchedHero 1.jpg" />
            <div class="heroInfo">
                <h2>Welcome to the Groundbreaker</h2>
                <p>A hotel among the stars</p>
                <button class="buy">Make reservation</button>
            </div>
        </section>
        <section class="sliderSection">
            <div class="slider-wrapper">
                <button class="slide-arrow" id="slide-arrow-prev">
                    &#8249;
                </button>
                <button class="slide-arrow" id="slide-arrow-next">
                    &#8250;
                </button>
                <div class="slides-container" id="slides-container">

                    <div class="slide">
                        <img src="/Pictures/2k/retouchedHero.jpg" />
                    </div>
                    <div class="slide">
                        <img src="/Pictures/hero-home-original.jpg" />
                    </div>
                    <div class="slide">
                        <img src="/Pictures/hotelGrid.png" />
                    </div>

                </div>
            </div>
        </section>
        <section class="island">
            <div class="islandInfo">
                <h2>Welcome to Space-shuttle island</h2>
                <p>Your destination on Earth to reach the stars</p>
            </div>
            <img class="spaceShuttlePicture" src="/Pictures/Hero-space-shuttle.jpg" />
        </section>

    </main>
</body>

</html>
