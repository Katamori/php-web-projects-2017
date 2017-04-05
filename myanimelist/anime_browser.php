<?php 
    session_start();

    if(!isset($_SESSION['custom']['mal'])){
        echo 'MyAnimeList authorization did not happened! Log in properly.<br>'.
             '<a href="../index.php">Back to the main page.</a>';      
        exit();
    }elseif(!isset($_SESSION['custom']['mal']['watchlist'])){
        echo 'Your watchlist is not detected! Try again.<br>'.
             '<a href="../index.php">Back to the main page.</a>';
        exit();
    }  elseif(!isset($_POST['title'])){
        echo 'No anime series were selected! Use this page properly. <br>'.
             '<a href="../index.php">Back to the main page.</a>';
        print_r($_POST);
        exit();
    }else{ 
        require('../myanimelist/common.php');
        $m = 1;         
    };  
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

            //a temporary "container due to the ridiculously long name
            $watchlist = $_SESSION['custom']['mal']['watchlist'];

            //find the position of the sent anime in the list
            while($m<sizeof($watchlist) && $watchlist[$m-1] != $_POST['title']){ $m++; };

            if($m != 1){ echo
            "<form method='post'>".
                "<input type='hidden' name='title' value='".$watchlist[$m-2]."'>".
                "<input type='submit' value='(-- Previous anime'>".
            "</form>";};

            if($m != sizeof($watchlist)-1){ echo
            "<form method='post'>".
                "<input type='hidden' name='title' value='".$watchlist[$m+0]."'>".
                "<input type='submit' value='Next anime --)'>".
            "</form>".
            "<br>";};



            //a container for the chosen subject, too
            $subject = new WatchlistItem();
            addAnimeFromSearch($watchlist[$m-1], $subject);

            echo
                "<img src='".$subject->img."' width='300px' alt='picture not loaded or found'><br>". 
                "Series: ".$_POST['title'].", no.".$m.". in your watchlist.<br><br>".
                $subject->synopsis;

            //echo "<img src='".$subject."' alt=''>";
        ?>

    </body>

</html>