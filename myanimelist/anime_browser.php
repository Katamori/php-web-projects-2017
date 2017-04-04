<?php 
    session_start();

    if(!isset($_SESSION['custom']['mal'])){
        echo 'MyAnimeList authorization did not happened! Log in properly.';
        exit();
    }

     if(!isset($_POST['title'])){
        echo 'No anime series were selected! Use this page properly.';
        exit();
    }   
?>

<!DOCTYPE html>
<html>

    <head>
        <style>
            td {

                border-right: 1px solid #bbb;
                border-bottom: 1px solid #bbb;                
                /*overflow: hidden;
                word-break: break-word;
                vertical-align: top;

                padding: 5px;*/
            }
        </style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script>


		</script>	
    </head>


    <body>

        <?php 
            echo "Series: ".$_POST['title']."<br><br>The rest are work in progress."
        ?>

    </body>

</html>