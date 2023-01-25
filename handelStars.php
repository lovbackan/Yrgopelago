<?php
    declare(strict_types=1);
    // require_once('./hotelFunctions.php');

    $reqMethod = $_SERVER["REQUEST_METHOD"];



    if ($reqMethod == "POST") {
        $star = (int) $_POST['star'] ?? 0;

        /* check it is a int */
        if (!is_int($star)) {
            return;
        }
        /* be sure it is not greater than 5 and less than 0  */
        if ($star < 0 || $star > 5) {
            return;
        }

        updateStar($db, $star, 1);
    }

    function updateStar(PDO $db, int $star, int $id): void {
        $stmt = $db->prepare("UPDATE star SET star = :star, updated_at = :update WHERE id = :id;");
        $date = new DateTime();
        $date = $date->getTimestamp();

        $stmt->bindParam(':star', $star);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':update', $date);

        $stmt->execute();
    }

    function getStar(PDO $db, $id = 1) {
        $stmt = $db->prepare('SELECT star FROM star WHERE id = :id');

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch();
    }
