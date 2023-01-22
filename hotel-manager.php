<?php
require("./hotelFunctions.php");
require('./roomPages/headAndHeader.php');

session_start();

if (!isset($_SESSION['name'])) {
    redirect('index.php');
}
?>
    <main class="hero">
        <section>
            <h2>The Groundbreaker Hotel Lets You Choose Your Own Level of Luxury</h2>
            <p>At the Groundbreaker hotel, the stars are in your hands! Want to live like
                royalty with five-star service and luxury, or perhaps you prefer a simpler
                three-star experience with a more relaxed atmosphere? We've got it all!
            </p>
        </section>

        <svg viewBox="0 0 765 746" fill="none">
            <circle cx="374.595" cy="374.595" r="78.9983" fill="#FDE617"/>

            <ellipse class="planet" cx="0" cy="0" rx="19.9502" ry="20" fill="#FFBE5E"/>
            <path id="path1" d="M209.32600000000002,373.578a165,165 0 1,0 330,0a165,165 0 1,0 -330,0" stroke="white" stroke-dasharray="6 6"/>

            <ellipse class="planet" cx="0" cy="0" rx="19.9776" ry="20" fill="#FD9E10"/>
            <path id="path2" d="M138.894,374.155a235,235 0 1,0 470,0a235,235 0 1,0 -470,0" stroke="white" stroke-dasharray="6 6"/>

            <circle class="planet" cx="0" cy="0" r="20" fill="#17FDB8"/>
            <path id="path3" d="M71.47199999999998,373.578a302.106,302.106 0 1,0 604.212,0a302.106,302.106 0 1,0 -604.212,0" stroke="white" stroke-dasharray="6 6"/>

            <circle class="planet" cx="0" cy="0" r="20" fill="#FD1717"/>
            <path id="path4" d="M3.5779999999999745,373.578a370,370 0 1,0 740,0a370,370 0 1,0 -740,0" stroke="white" stroke-dasharray="6 6"/>
        </svg>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script defer src="./script.js"></script>
</body>

</html>
