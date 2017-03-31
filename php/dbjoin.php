<?php


    if (isset($_POST["login"]) && isset($_POST["pw"])) {

        $login = htmlspecialchars($_POST["login"]);
        $pw = htmlspecialchars($_POST["pw"]);

        $connection = mysqli_connect("mysql.hostinger.co.uk", $login, $pw);
        mysqli_select_db($connection, "u373989137_doom") or die("Unable to select database.");

        $_SESSION["dbconn_doom"] = $connection;

    }



?>
