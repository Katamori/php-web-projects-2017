<?php 
    session_start();

    if(!isset($_SESSION['custom']['mal'])){
        echo 'MyAnimeList authorization did not happened! Log in properly.';
        exit();
    }else{
        require('../myanimelist/common.php');
    }

?>

<!DOCTYPE html>
<html>

	<head>
        <title>Custom watchlist</title>
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
        <h2> <?php echo 'The first '.$_POST['limit'].' elements of your watchlist'; ?></h2>
          
        <form method='post'> 
            <input type="number" value="10" name="limit">
            <br>  
			Sort by: <br>
			<select name="sort">
				<option value="db_id">MAL database id</option>				
				<option value="title">Anime title</option>
				<option value="mal_score">Rating by users</option>
				<option value="type">Type</option>
				<option value="date_start">Start date</option>

			</select>
            <br>
            <input type="checkbox" name="order" checked> Increasing?
            <br> 
            <input type="submit" value="set limit">                         
        </form>
        <br>

        <?php

            $limit = $_POST['limit'];
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




            //if(isset($_SESSION['custom']['mal']['user_xml'])){

                $url_user = 'https://myanimelist.net/malappinfo.php?u='.$_SESSION['custom']['mal']['user'].'&status=2&type=anime';
                $xml = file_get_contents($url_user, false, stream_context_create($_SESSION['custom']['mal']['http_auth']));    
                echo "Anime list of ".$_SESSION['custom']['mal']['user']." gathered from MAL!<br><br>";
      /*          
            }else{

                $xml = $_SESSION['custom']['mal']['user_xml'];
                echo $_SESSION['custom']['mal']['user']."'s anime list loaded from session. No new data has been downloaded";
            
            }
*/
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

            $p=0;
            for($q=0; $q<sizeof($array) && $p<$limit; $q++){
                $value = $array[$q];
            //foreach ($array as $value) {

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

                            //create the item-object
                            $temp_obj = new WatchlistItem();         
                            $temp_obj->db_id = $temp_id;
                            $temp_obj->title = $temp_title;

                            addAnimeFromSearch($temp_title, $temp_obj);

                            $items[] = $temp_obj;

                            $opened = false;
                            $p++;
         
                        }                          
                        break;
                }
            }

            unset($value);      //break the reference with the last element
            unset($array);      //It'd only consume resources at this point, tbh
            //unset($items);
            //unset($_SESSION['custom']['mal']['user_xml']);



            //the sorting
            if(isset($_POST['sort'])){

                function compare($a, $b){ 
                    $member = $_POST['sort'];
                    if(is_numeric($a->$member) ){ return (isset($_POST['order']) && $a->$member < $b->$member);
                    }else{ return (isset($_POST['order']) && strcmp( strtolower($a->$member), strtolower($b->$member)));};
                };

                usort($items, 'compare');
            };            
       

            echo("<table>");    //table output

            //these two lines are temporary restrictions due to php execution time limit at my host
            for($j=0; $j<$limit; $j++){
                $value = $items[$j];
            //foreach($items as $value){
                //echo $value->title." (btw ".var_dump($options).") <br>";



                //the print-out part
                echo("<tr>" .
                        "<td>".($j+1)."</td>".
                        "<td>".
                            "<form action='../myanimelist/anime_browser.php' method='post'>".
                                "<input type='hidden' name='title' value='".str_replace(" ","+", $value->title)."'>".
                                "<input type='submit' value='More information'>".
                            "</form>".
                        "</td>" .                
                        "<td>" . $value->db_id . "</td>" .                 
                        "<td>" . $value->title . "</td>" .
                        "<td>" . $value->mal_score . "</td>" . 
                        "<td>" . $value->type . "</td>" .
                        "<td>" . $value->episodes . "</td>" . 
                        "<td>" . $value->date_start . "</td>" .
                        "<td><img src='" . $value->img . "' height='192px'></img></td>" .                        
                    "</tr>"); 
           
            }

            echo("</table>");

            //store title in session, for further usage in another file
            foreach($items as $value){ array_push($_SESSION['custom']['mal']['watchlist'], str_replace(" ","+", $value->title)); };            
        ?>

	</body>

</html>  
