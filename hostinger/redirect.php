<?php

    session_start();

    if (isset($_POST["hostinger_login"]) && isset($_POST["hostinger_pw"]) && isset($_POST["hostinger_db"])) {

        $_SESSION['custom']['db'] = array(

            'name' => "u373989137_".$_POST["hostinger_db"],
            'login' => htmlspecialchars($_POST["hostinger_login"]),
            'pw' => htmlspecialchars($_POST["hostinger_pw"])

        );

        //manual switch link because my host
        $message = 
            'Login data saved.<br>'.
            'Sadly though, my hosting service apparently forbids any kind of automatic redirection, <br>'.
            'meaning that you must click on the link below to continue. I\'m working on some one-site <br>'.
            'solutions that you can reach under /ajax/login.php - beginner webdevs\' misfortune, sorry!<br><br>'.
            'Oh, any by the way: database connection was not possible the way I wanted, soooo....yeah.';
        echo $message.'<br><br><br>' 
            .'<a href="../hostinger/db_'.$_POST["hostinger_db"].'.php">'
            .'Click here to be redirected to your desired site.</a>';
    }



?>
