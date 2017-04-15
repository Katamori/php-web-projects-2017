<?php

    try{
        if(!isset($_GET['acc'])){ throw new Exception('No account selected!'); };

        switch($_GET['acc']){

            case 'myanimelist':

                echo 'Logging out '.$_SESSION['custom']['mal']['user'].' MAL user... <br>';

                $_SESSION['custom']['mal']['logged_in'] = 0;

                $_SESSION['custom']['mal']['http_auth'] = '';
                $_SESSION['custom']['mal']['user'] = '';
                $_SESSION['custom']['mal']['user_xml'] = '';
                $_SESSION['custom']['mal']['watchlist'] = array();

                echo 'Logged out. <a href=\'./index.php\'>Black to the main page</a>';

            break;
        }

    }catch(Exception $e){

    }

?>