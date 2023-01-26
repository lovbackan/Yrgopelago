<?php
    declare(strict_types=1);


    $reqMethod = $_SERVER["REQUEST_METHOD"];

    if ($reqMethod == "POST") {
        $star = intval($_POST['star']);

        /* check it is a int */
        if (!is_int($star)) {
            return;
        }
        /* be sure it is not greater than 5 and less than 0  */
        if ($star < 0 || $star > 5) {
            return;
        }

        updateStar($star, 1);
    }

    function updateStar(int $star, int $id): void {
        $dbPath = __DIR__ . '/' . "hotel.db";

        /*
            Emergency solution add connection to db.

            Did it because I need to have a connection to the db when
            I do a fetch in js.
        */
        try {
            $db = new PDO("sqlite:$dbPath");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $stmt = $db->prepare("UPDATE star SET star = :star, updated_at = :update WHERE id = :id;");
            $date = new DateTime();
            $date = $date->getTimestamp();

            $stmt->bindParam(':star', $star);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':update', $date);

            $stmt->execute();
        } catch (PDOException $e) {
            echo '<script>alert("Failed to connect to database")</script>';
            throw $e;
        }



    }

    function getStar(PDO $db, $id = 1) {
        $stmt = $db->prepare('SELECT star FROM star WHERE id = :id');

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch();
    }
