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
            <a href="./index.php">
                <h1>Groundbreaker</h1>
            </a>
            <div class="navInfo">
                <a href="./economy.php">Economy</a>
                <a href="./standard.php">Standard</a>
                <a class="lastNavItem" href="./luxury.php">Luxury</a>
            </div>
        </nav>
    </header>
    <main>
        <section class="hero">
            <img class="heroDesktop" src="/pictures/2k/retouchedHero1.jpg" />
            <div class="heroInfo">
                <h2>Welcome to The Groundbreaker</h2>
                <p>A hotel among the stars</p>
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
                <div class="islandInfoHeading">
                    <h2>Space-shuttle Island</h2>
                    <p>Your destination on Earth to reach the stars</p>
                </div>
                <p>
                    Have you ever wanted to experience the ultimate adventure? Imagine taking a luxurious space shuttle to the world's first space hotel located 250 miles above the Earth's surface. This is more than just a dream, it's now a reality. Welcome to the Groundbreaker Hotel!
                </p>
                <p>
                    This incredible space hotel provides guests with the opportunity to experience the wonders of space travel up close. The space hotel is equipped with state-of-the-art technology, allowing you to explore the universe in an exciting and unique way. You can take part in space walks, view the Earth from a unique perspective, and get up close and personal with the stars. Experience weightlessness with the Groundbreakers partial artificial gravity from its rotation to maintain lunar gravity—approximately 1⁄6 of Earth's gravity.
                </p>
                <p>
                    Your journey begins with a first-class flight on a space shuttle departing from Space-shuttle Island. The shuttle is equipped with the most advanced technology, ensuring a safe and comfortable journey in style.
                </p>
                <p>
                    This is your chance to experience a once in a lifetime adventure. So, grab your passport and prepare to embark on an unforgettable journey to the Groundbreaker Hotel!
                </p>
            </div>
            <img class="spaceShuttlePicture" src="/Pictures/Hero-space-shuttle.jpg" />
        </section>

    </main>
</body>

</html>
