<?php
    session_start();

    /*
        list item class definition
    */

    class WatchlistItem {
        public $db_id = null;
        public $title = null;
        public $type = null;
        public $mal_score = null;
        public $date_start = null;
        public $date_end = null;        
        public $runtime = null;
        public $episodes = null;
        public $img = null;
        public $synonym = null;
        public $synopsis = null;
    };



    /*
        DEFINITION OF COMMON FUNCTIONS
    */

    /*
        input 1: string, used in MAL search
        input 2: WatchListItem object that'll be uploaded with the sufficient data
        
    */
    function addAnimeFromSearch($animetitle, $watchlistitem){

        //query about the anime itself
        $tempxml = file_get_contents(
            "https://myanimelist.net/api/anime/search.xml?q=" . str_replace(" ","+", $animetitle), 
            false, stream_context_create($_SESSION['custom']['mal']['http_auth']));

        $p = xml_parser_create();
        xml_parse_into_struct($p, $tempxml, $temp_array);
        xml_parser_free($p); 
                        
        $tempdate1; $tempdate2;


        foreach ($temp_array as &$inner_value) {
            if($inner_value["type"] == "complete"){
                    switch($inner_value["tag"]){
                        case "ID":          $watchlistitem->db_id = $inner_value["value"];         break;
                        case "TITLE":       $watchlistitem->title = $inner_value["value"];         break;
                        case "SCORE":       $watchlistitem->mal_score = $inner_value["value"];     break;
                        case "TYPE":        $watchlistitem->type = $inner_value["value"];          break;
                        case "EPISODES":    $watchlistitem->episodes = $inner_value["value"];      break;                                    
                        case "IMAGE":       $watchlistitem->img = $inner_value["value"];           break;                     
                        case "SYNONYMS":    $watchlistitem->synonym = $inner_value["value"];       break;
                        case "SYNOPSIS":    $watchlistitem->synopsis = $inner_value["value"];      break;
                        case "START_DATE":  
                            $watchlistitem->date_start = $inner_value["value"]; 
                            $tempdate1 = new DateTime($inner_value["value"]);   
                            break;                          
                        case "END_DATE":    
                            $watchlistitem->date_end = $inner_value["value"];      
                            $tempdate2 = new DateTime($inner_value["value"]);   
                            $watchlistitem->runtime = $tempdate1->diff($tempdate2)->days;
                            break;                                                 
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