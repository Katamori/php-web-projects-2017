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
            echo "Sorry, ".$_SESSION['mal_username'].", this feature is not implemented yet.<br>".
                 '<a href="index.php">Back to the main page.</a>';
        ?>       
    </body>

</html>