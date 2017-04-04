<?php 
    session_start();

    if(!isset($_SESSION['custom']['mal'])){
        echo 'MyAnimeList authorization did not happened! Log in properly.';
        exit();
    }


    /*
        DEFINITION OF COMMON FUNCTIONS
    */

    /*
        input 1: string, used in MAL search
        input 2: WatchListItem object that'll be uploaded with the sufficient data
        input 3: stream context for the connection; may be removed in the future
    */
    function addAnimeFromSearch($animetitle, $watchlistitem, $streamcontext){

        $nameasquery = str_replace(" ","+", $animetitle);
        //query about the anime itself
        $tempxml = file_get_contents(
            "https://myanimelist.net/api/anime/search.xml?q=" . $nameasquery, 
            false, $streamcontext);

        $p = xml_parser_create();
        xml_parse_into_struct($p, $tempxml, $temp_array);
        xml_parser_free($p); 
                        





        foreach ($temp_array as &$inner_value) {
            if($inner_value["type"] == "complete"){
                    switch($inner_value["tag"]){
                        case "ID":          $watchlistitem->db_id = $inner_value["value"];         break;
                        case "TITLE":       $watchlistitem->title = $inner_value["value"];         break;
                        case "SCORE":       $watchlistitem->mal_score = $inner_value["value"];     break;
                        case "TYPE":        $watchlistitem->type = $inner_value["value"];          break;
                        case "EPISODES":    $watchlistitem->episodes = $inner_value["value"];      break;                                    
                        case "IMAGE":       $watchlistitem->img = $inner_value["value"];           break;
                        case "START_DATE":  $watchlistitem->date_start = $inner_value["value"];    break;
                    }
        /*
            this case means that the end of an XML "portion" is reached
            so we exit completely - we need only the first block
            
            the reason is that I give full names to the query
            that must be precise enough for finding the item as a first result 
        */
            }elseif($inner_value["type"] == "close"){ break; };
        }

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

        <h1> Your MyAnimeList watchlist </h1>
        <h2> The first xy elements of your watchlist</h2>
          

        <br>

        <?php

            /*

                to-do used to be here; migrated to "notes.txt" @ 03:54, 2017-04-03

                list item class definition
            */

            class WatchlistItem {
                public $db_id = null;
                public $title = null;
                public $type = null;
                public $mal_score = null;
                public $date_start = null;
                public $runtime = null;
                public $episodes = null;
                public $img = null;
            };


            /*
                doing the "query"


                principle:
                - if type = "open": set "opened" true anyhow
                - if type = "complete":
                    - save the necessary values to temporary vars
                    - if tag is MY_STATUS and value isn't 6 then set "opened" to false
                - if type = "closed":
                    - if "opened" is true:
                        - create new WatchlistItem and save ID and title to it

                what I need from an $url_user result:
                    only SERIES_ANIMEDB_ID, apparently...oh, and SERIES_TITLE, for the proper query


                what I need from an $url_search result:
                    ID, TITLE, SCORE, TYPE, EPISODES, IMAGE
                    + START_DATE itself and the difference between END_DATE and START_DATE (in days)

            */




            if($_SESSION['custom']['mal']['user_xml'] == ''){

                $url_user = 'https://myanimelist.net/malappinfo.php?u='.$_SESSION['custom']['mal']['user'].'&status=2&type=anime';
                $xml = file_get_contents($url_user, false, stream_context_create($_SESSION['custom']['mal']['http_auth']));    
                echo "Anime list of ".$_SESSION['custom']['mal']['user']." gathered from MAL!<br><br>";
                
            }else{

                $xml = $_SESSION['custom']['mal']['user_xml'];
                echo $_SESSION['custom']['mal']['user']."'s anime list loaded from session. No new data has been downloaded";
            
            }

            $parser = xml_parser_create();
            xml_parse_into_struct($parser, $xml, $array);
            xml_parser_free($parser);   
            //print("<pre>".print_r($array,true)."</pre>");


            /*

                data is got; now, evaluation comes

            */


            $items = array();
            $opened = false;

            $temp_id;
            $temp_title;


            foreach ($array as &$value) {

                switch($value["type"]){

                    case "complete":
                        switch($value["tag"]){
                            case "SERIES_ANIMEDB_ID":   $temp_id = $value["value"];     break;
                            case "SERIES_TITLE":        $temp_title = $value["value"];  break;
                            case "MY_STATUS":           $opened = $value["value"]==6;   break;
                        }
                        break;


                    case "open":
                        if($value["tag"] == "ANIME"){$opened = true;};          
                        break;


                    case "close":
                        if($opened){

             
                            $temp_obj = new WatchlistItem();         //create the item-object
                            $temp_obj->db_id = $temp_id;
                            $temp_obj->title = $temp_title;

                            $items[] = $temp_obj;


                            $opened = false;
                        }                          
                        break;
                }
            }

            unset($value);      //break the reference with the last element
            unset($array);      //It'd only consume resources at this point, tbh

            $_SESSION['custom']['mal']['watchlist'] = $items;

          
            echo("<table>");    //table output

            //these two lines are temporary restrictions due to php execution time limit at my host
            for($j=0; $j<10; $j++){
                $value = $items[$j];
            //foreach($items as $value){
                //echo $value->title." (btw ".var_dump($options).") <br>";

                addAnimeFromSearch($value->title, $value, stream_context_create($_SESSION['custom']['mal']['http_auth']));

                //the print-out part
                echo("<tr>" .
                        "<td>".
                            "<form action='../myanimelist/anime_browser.php'>".
                                "<input type='hidden' value='".$nameasquery."' name='title'>".
                                "<input type='submit' value='More information'>".
                            "</form>".
                        "</td>" .                
                        "<td>" . $value->db_id . "</td>" .                 
                        "<td>" . $value->title . "</td>" .
                        "<td>" . $value->mal_score . "</td>" . 
                        "<td>" . $value->type . "</td>" .
                        "<td>" . $value->episodes . "</td>" . 
                        "<td>" . $value->date_start . "</td>" .
                        "<td><img src='" . $value->img . "'></img></td>" .                        
                    "</tr>"); 
           
            }

            echo("</table>");


        ?>

	</body>

</html>  
