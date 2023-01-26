<?php
    require "./hotelFunctions.php";
    session_start();
    session_unset();
    session_destroy();

    redirect('index.php');
?>

