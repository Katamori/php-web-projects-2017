<?php

    /*
        chain of call:

        1) form submission with login credentials (to hostinger/redirect.php)
        2) "redirect.php" contains session var declarations
        3) this file
        4) database queries somewhere (with this file as 'require' in php)
    */

    session_start();

    $connection = 
        mysqli_connect(
            "mysql.hostinger.co.uk", 
            $_SESSION['custom']['db']['login'], 
            $_SESSION['custom']['db']['pw']);

    mysqli_select_db(
        $connection, 
        $_SESSION['custom']['db']['name']) 
    or die("Unable to select database.");

?>
