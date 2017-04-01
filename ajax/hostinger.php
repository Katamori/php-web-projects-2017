<?php

    session_start();

    if (isset($_POST["ajax_hostinger_login"]) && isset($_POST["ajax_hostinger_pw"]) && isset($_POST["ajax_hostinger_db"])) {

        $login = htmlspecialchars($_POST["ajax_hostinger_login"]);
        $pw = htmlspecialchars($_POST["ajax_hostinger_pw"]);

        $connection = mysqli_connect("mysql.hostinger.co.uk", $login, $pw);
        mysqli_select_db($connection, "u373989137_".$_POST["ajax_hostinger_db"]) or die("Unable to select database.");

        $_SESSION["dbconn_doom"] = $connection;

        //manual switch link because my host
        $message = 
            'Database join (probably) successfull.<br>Feature work in progess though, thanks for your patience!';
        echo $message.'<br><br><br>';
    }



?>
