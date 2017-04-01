<?php

    session_start();

    if (isset($_POST["mal_login"]) && isset($_POST["mal_pw"]) && isset($_POST["mal_action"])) {


        /*

            MAL HTTP authentication

            source: http://stackoverflow.com/a/21565794/2320153

        */

        $login = htmlspecialchars($_POST["mal_login"]);
        $pw = htmlspecialchars($_POST["mal_pw"]);

        // Create a stream
        $options = array(
            'http'=>array(
                'method' => "GET",
                'header' => "Authorization: Basic " . base64_encode($login.':'.$pw)                 
            )
        );

        $_SESSION["mal_connect_context"] = stream_context_create($options);
        $_SESSION['mal_username'] = $login;

        //manual switch link because my host
        $message = 
            'Authorization data prepared.<br>'.
            'Sadly though, my hosting service apparently forbids any kind of automatic redirection, <br>'.
            'meaning that you must click on the link below to continue. I\'m working on some one-site <br>'.
            'solutions that you can reach under /ajax/login.php - beginner webdevs\' misfortune, sorry!';
        echo $message.'<br><br><br>' 
            .'<a href="../myanimelist/'.$_POST["mal_action"].'.php">'
            .'Click here to be redirected to your desired site.</a>';

    }


?>
