<?php 
    //require("../php/dbjoin.php"); 
    session_start();
?>

<!DOCTYPE html>
<html>

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <script>




        </script>	
    </head>

    <body>
        <?php 
            echo "Well, dear ".$_SESSION['mal_username'].", one day this is gonna be some a proper MAL interface.<br>".
                 '<a href="index.php">Back to the main page.</a>';
        ?>       
    </body>

</html>