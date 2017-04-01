<?php

    /*

        MAL HTTP authentication

        source: http://stackoverflow.com/a/21565794/2320153

    */

    if (isset($_POST["mal_login"]) && isset($_POST["mal_pw"])) {

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
        $_SESSION["mal_username"] = $login;

        //$connection = mysqli_connect("mysql.hostinger.co.uk", $login, $pw);
        //mysqli_select_db($connection, "u373989137_doom") or die("Unable to select database.");

        //$_SESSION["dbconn_doom"] = $connection;

    }



?>
