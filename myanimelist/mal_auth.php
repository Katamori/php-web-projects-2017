<?php

    session_start();


    /*
        THE PROCESS THAT SENDS YOU ON
    */

    //echo isset($_POST["mal_login"])."<br>";
    //echo isset($_POST["mal_pw"])."<br>";
    //echo isset($_POST["mal_action"])."<br>";
    //echo isset($_SESSION['custom']['mal'])."<br>";

    if(isset($_SESSION['custom']['mal'])){

        //manual switch link because my host
        $message = 
            'Welcome back, '.$_SESSION['custom']['mal']['user'].'!';
        echo $message.'<br><br><br>' 
            .'<a href="../myanimelist/'.$_POST["mal_action"].'.php">'
            .'Click here to be redirected to your desired site.</a>';

    }elseif (isset($_POST["mal_login"]) && isset($_POST["mal_pw"]) && isset($_POST["mal_action"])) {

        //MAL HTTP authentication - source: http://stackoverflow.com/a/21565794/2320153
        $login = htmlspecialchars($_POST["mal_login"]);
        $pw = htmlspecialchars($_POST["mal_pw"]);

        // Create a stream
        $context = array(
            'http'=>array(
                'method' => "GET",
                'header' => "Authorization: Basic " . base64_encode($login.':'.$pw)                 
            )
        );

        $_SESSION['custom']['mal'] = array(
            'http_auth' => $context,
            'user' => $login,
            'user_xml' => '', /* will be defined in watchlist.php */ 
            'watchlist' => ''
        );

        //manual switch link because my host
        $message = 
            'Authorization data prepared.<br>'.
            'Sadly though, my hosting service apparently forbids any kind of automatic redirection, <br>'.
            'meaning that you must click on the link below to continue - beginner webdevs\' misfortune, sorry!';
        echo $message.'<br><br><br>' 
            .'<a href="../myanimelist/'.$_POST["mal_action"].'.php">'
            .'Click here to be redirected to your desired site.</a>';

    };




?>
