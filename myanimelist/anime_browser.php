<?php 
    session_start();

    //initialization error check    
    try{

        if(!isset($_SESSION['custom']['mal'])){
            throw new Exception('MyAnimeList authorization did not happened! Log in properly.<br>');      
        }

        if(!isset($_SESSION['custom']['mal']['watchlist'])){
            throw new Exception('Your watchlist is not detected! Try again.<br>');
            exit();
        }

        if(!isset($_POST['title'])){
            throw new Exception('No anime series were selected! Use this page properly. <br>');

        }

        readfile('../html_blocks/fork-me.html');         
        require('../myanimelist/common.php');


    }catch(Exception $e){
        echo $e->getMessage().'<a href="../index.php">Back to the main page.</a>';
    }





    /*
        main logic
    */

    $m = 1;

    //a temporary "container due to the ridiculously long name
    $watchlist = $_SESSION['custom']['mal']['watchlist'];
    $length = sizeof($watchlist);

    //find the position of the sent anime in the list
    while($m<$length && $watchlist[$m-1] != $_POST['title']){ $m++; };    

    //a container for the chosen subject, too
    $subject = new WatchlistItem();
    addAnimeFromSearch($watchlist[$m-1], $subject);

?>

<!DOCTYPE html>
<html>

    <head>
        <title><?php echo 'Anime browser - '.str_replace("+"," ",$_POST['title']); ?></title>    
        <style>

        </style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script>


		</script>	
    </head>


    <body>

        <table style='width:100%;'>
            <tr>
                <td>
                    <?php 
                        //render "previous anime" button
                        if($m != 1){ echo
                        "<form method='post'>".
                            "<input type='hidden' name='title' value='".$watchlist[$m-2]."'>".
                            "<input type='submit' value='(-- Previous anime'>".
                        "</form>";};
                    ?>       
                </td>
                <td>
                    <?php
                        //random
                        echo 
                        "<form method='post'>".
                            "<input type='hidden' name='title' value='".$watchlist[rand(2, $length-1)]."'>".
                            "<input type='submit' value='Select randomly'>".
                        "</form>";
                    ?>        
                </td>
                <td>
                    <?php
                        //render "next anime" button
                        if($m != sizeof($watchlist)){ echo
                        "<form method='post'>".
                            "<input type='hidden' name='title' value='".$watchlist[$m+0]."'>".
                            "<input type='submit' value='Next anime --)'>".
                        "</form>";};
                    ?>       
                </td>
            </tr>
            
        </table>

        <table style='width:100%;'>
            <tr>
                <td>
                    <img <?php echo "src='".$subject->img."'" ?> width='384px' alt='picture not loaded or found'>
                </td>
                <td>
                    <?php echo 
                        "Series: ".str_replace('+', ' ', $_POST['title']).", no. ".$m.". in your current query.<br><br>".
                        $subject->synopsis."<br><br>".
                        "<a href='https://myanimelist.net/anime/".$subject->db_id."'>More information at MyAnimeList.net</a>";         
                    ?>
                </td>
            </tr>
        </table>
        <br><br>
        <a href="../myanimelist/watchlist.php">Back to your watchlist</a>
    </body>

</html>