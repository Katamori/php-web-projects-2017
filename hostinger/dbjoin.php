<?php

    /*
        chain of call:

        1) form submission with login credentials (to hostinger/redirect.php)
        2) "redirect.php" contains session var declarations
        3) this file
        4) database queries somewhere (with this file as 'require' in php)
    */

    session_start();

    $_SESSION["dbconn"]  = mysqli_connect("mysql.hostinger.co.uk", $_SESSION["dblogin"], $_SESSION["dbpw"]);
    mysqli_select_db($_SESSION["dbconn"], $_SESSION["dbname"]) or die("Unable to select database.");

?>
