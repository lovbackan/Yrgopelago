<?php
    declare(strict_types=1);
    require('./hotelFunctions.php');

    /* check if user have press the submit button and if not redirect to home page */
    if (isset($_POST['submit'])) {

        /* Here I remove spaces and convert it to htmlspecialchars */
        $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES);
        $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES);

        /* Get the user from DB if exist */
        $user = $db->prepare('SELECT name, "password" FROM user WHERE name = :name');
        $user->bindParam(':name', $name);

        /* Check if we can preform SQL request */
        if (!$user->execute()) {
            $error[] = "Server error";
        }

        $user = $user->fetch();


        $error = [];

        /* Check if input is empty */
        if (empty($name) || empty($password)) {
            $error[] = "Must fill in both fields";
        }

        /* Check if we not find an user */
        if (!$user) {
            $error[] = "Could not find user with name: $name";
        }

        /* Check if password is Valid */
        if (!isValidUuid($password)) {
            $error[] = "Password field not matching patten";
        }

        /* check if user exist & password is matching password in DB */
        if ($user && !password_verify($password, $user["password"])) {
            $error[] = "Password is not correct";
        }

        /* Check if it's any error */
        if (!empty($error)) {
            redirect('index.php', ["error" => $error]);
        }

        /* If no error */
        session_start();
        $_SESSION["name"] = $name;

        redirect('hotel-manager.php');
    } else {
        redirect('index.php');
    }
?>
