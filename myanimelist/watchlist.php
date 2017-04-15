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

        <p><a href="../logout.php?acc=myanimelist">Click here to log out.</a></p>
    
        <?php

            session_start();

            /*
                error handling
            */

            try{
                //if this part of the code fails to work by any chance
                if(!isset($_SESSION['custom']['mal'])){
                    throw new Exception("You tried accessing this site without logging in.");
                };   

                //runs a test query that doesn't work without auth
                $o = file_get_contents(
                    "https://myanimelist.net/api/anime/search.xml?q=test", 
                    false, stream_context_create($_SESSION['custom']['mal']['http_auth']));

                if($o === FALSE){ throw new Exception("HTTP request failed!");}; 

                //form validation (kinda)
                //if(!isset($_POST['sort'])){ throw new Exception("Sorting option not chosen! Are you hacking into me?!");};

                //beyond the errors:  
                readfile('../html_blocks/fork-me.html');                        //add "fork me" to corner
                readfile('../html_blocks/mal_watchlist_input.html');            //add input              
                require('../myanimelist/common.php');                           //load common calls
                $_SESSION['custom']['mal']['logged_in'] = 1;                    //make login state true

                echo "Successfully logged in. <br>";

                //keep previous values of form
                isset($_POST['limit']) ? $limit = $_POST['limit'] : $limit=10;             

                $auth_context = stream_context_create($_SESSION['custom']['mal']['http_auth']);

            }catch(Exception $e){
                echo 'Not that fast! ' .$e->getMessage();
                exit(); //to terminate everything else, as well
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




            //if(isset($_SESSION['custom']['mal']['user_xml'])){

                $url_user = 'https://myanimelist.net/malappinfo.php?u='.$_SESSION['custom']['mal']['user'].'&status=2&type=anime';
                $xml = file_get_contents($url_user, false, $auth_context);    
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


            $items = array(); $opened = false; $temp_id; $temp_title;

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


            try{
                //the sorting
                function compare($a, $b){ 
                    $member = $_POST['sort'];
                    if(isset($_POST['order'])){
                        if(is_numeric($a->$member)){ return $b->$member < $a->$member;
                                            }else{ return strcmp( strtolower($b->$member), strtolower($a->$member));}
                    }else{
                        if(is_numeric($a->$member)){ return $a->$member < $b->$member;
                                            }else{ return strcmp( strtolower($a->$member), strtolower($b->$member));} 
                    };
                };            

                usort($items, 'compare');

            }catch(Exception $e){
                echo $e;
            }

           

           
            /*
                table output
            */

            echo("<table>");    

            //these two lines are restrictions due to php execution time limit at my host
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
