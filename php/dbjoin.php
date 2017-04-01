<?php


    if (isset($_POST["hostinger_login"]) && isset($_POST["hostinger_pw"])) {

        $login = htmlspecialchars($_POST["hostinger_login"]);
        $pw = htmlspecialchars($_POST["hostinger_pw"]);

        $connection = mysqli_connect("mysql.hostinger.co.uk", $login, $pw);
        mysqli_select_db($connection, "u373989137_doom") or die("Unable to select database.");

        $_SESSION["dbconn_doom"] = $connection;

    }



?>
