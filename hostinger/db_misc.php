<?php 
    session_start();
    require("../hostinger/dbjoin.php");

    if ($_SESSION['custom']['db']['name'] != "u373989137_misc"){
        echo "Database is either not selected or the wrong one is selected! <br>".
             "Thus, for safety reasons, php scripts are terminated. Log in again!";
        exit();
    }
?>

<!DOCTYPE html>
<html>

    <head>
    
    </head>

    <body>
        <h1>Coming soon!</h1>
        <p>Nah, this db slot is simply not assigned, yet...</p>
        <a href="index.php">Back to the main page</a>

    </body>

</html>