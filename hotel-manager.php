<?php
require("./hotelFunctions.php");
require('./roomPages/headAndHeader.php');


if (!isset($_SESSION['name'])) {
    redirect('index.php');
}
?>
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
    <script defer src="./script.js"></script>
</body>

</html>
