<?php 
    session_start();
    require("../hostinger/dbjoin.php");

    if ($_SESSION["dbname"] != "u373989137_doom"){
        echo "Database is either not selected or the wrong one is selected! <br>".
             "Thus, for safety reasons, php scripts are terminated. Log in again!";
        exit();
    }
?>

<!DOCTYPE html>
<html>


	<head>

        <style>
            td {border: 1px solid #bbb;}
        </style>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>

            function AJAXsubmission(){
                
                //source: http://stackoverflow.com/a/5004276/2320153

                // Variable to hold request
                var request;

                // Bind to the submit event of our form
                $("#repeat_form").on("submit", function(event){

                        // Prevent default posting of form - put here to work in case of errors
                        event.preventDefault();

                        // Abort any pending request
                        if (request) {
                            request.abort();
                        }
                        // setup some local variables
                        var $form = $(this);

                        // Let's select and cache all the fields
                        var $inputs = $form.find("input, select, button, textarea");

                        // Serialize the data in the form
                        var serializedData = $form.serialize();

                        // Let's disable the inputs for the duration of the Ajax request.
                        // Note: we disable elements AFTER the form data has been serialized.
                        // Disabled form elements will not be serialized.
                        $inputs.prop("disabled", true);

                        // Fire off the request to /form.php
                        request = $.ajax({
                            url: "../hostinger/db_doom.php",
                            type: "post",
                            data: serializedData
                        });

                        // Callback handler that will be called on success
                        request.done(function (response, textStatus, jqXHR){
                            // Log a message to the console
                            console.log("db_doom.php successfully called and loaded.");
                        });

                        // Callback handler that will be called on failure
                        request.fail(function (jqXHR, textStatus, errorThrown){
                            // Log the error to the console
                            console.error(
                                "The following error occurred: "+
                                textStatus, errorThrown
                            );
                        });

                        // Callback handler that will be called regardless
                        // if the request failed or succeeded
                        request.always(function () {
                            // Reenable the inputs
                            $inputs.prop("disabled", false);
                        });


                });
            };


            $(document).ready(function(){
                                        
                AJAXsubmission();
                
                //warning: don't use it with multiple checkboxes!
                $('#repeat_form :checkbox').change(function() {
                    // this will contain a reference to the checkbox   
                    if ($(this).is(':checked')) {
                        AJAXsubmission();
                    } else {
                        $("#repeat_form").off('submit');
                    }
                });

            });




		</script>		
	</head>





	<body>

        <h1> Collection of Youtube videos about Doom </h1>

        <h2>Sorry, but to allow *any* DB change, you must log in again.</h2>

		<form action="" method="post" id="repeat_form">

			Login: 
            <br>
			<input type="text" name="login" value="u373989137_doom">
            <br> 
            Password:
            <br>
            <input type="password" name="pw">
            <br>
            <input type="checkbox" name="ajax" checked> Use AJAX?
            <br> 
			<input type="submit">
		</form>            

        <?php

            function isNull($e){ if ($e == ""){return "NULL";}else{return $e;} };



            function sendRequest($mode, $videoid){


                $apikey_YT = "AIzaSyDShcKq34IsxyvxQ_GxH3Xbj2vfDcfjX_g";

                switch($mode){

                    case "related":

                        $ytrequrl = "https://www.googleapis.com/youtube/v3/search?".
                                "part=snippet".
                                "&maxResults=50".
                                "&relatedToVideoId=".$videoid.
                                "&type=video".
                                "&key=".$apikey_YT;
                    
                    break;



                    case "single":

                        $ytrequrl = "https://www.googleapis.com/youtube/v3/videos?".
                                "part=snippet".
                                "&id=".$videoid.
                                "&key=".$apikey_YT;

                    break;


                }


                //curl method
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $ytrequrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);

                if (curl_errno($ch)) {
                    //echo 'Error: ' . curl_error($ch).'\n';
                }
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);


                //print("<pre>".print_r($output,true)."</pre>");
                //var_dump($http_status." - ".$output."\n");
                //echo strlen(file_get_contents('http://www.doomworld.com')."\n");

                return $output;

            };



            function setMissingUploader($sql_query_result){


                $q = "START TRANSACTION; ";

                while($row = mysqli_fetch_assoc($sql_query_result) ){ 

                    $j = json_decode(sendRequest("single", $row['id']));
                    //var_dump($j->items);

                    /*
                        query 1: add uploader id to the video's db record 
                    */
                    $q .=   "UPDATE videos SET uploader='".$j->items[0]->snippet->channelId."' ".
                            "WHERE id='".$row['id']."' AND uploader IS NULL; ".
                    /* 
                        query 2: try adding uploader id to 'uploader' table
                    */
                            "INSERT IGNORE INTO uploaders VALUES ('"
                            .$j->items[0]->snippet->channelId."','"
                            .str_replace("'"," ",$j->items[0]->snippet->channelTitle)."'); ". 
                    /* 
                        query 3: try updating if it already existed and had no 'name' field
                    */
                            "UPDATE uploaders SET name='".str_replace("'"," ",$j->items[0]->snippet->channelTitle).
                            "' WHERE id='".$j->items[0]->snippet->channelId."' AND name IS NULL; ";

                };

                $q .= "COMMIT;";

                $r = mysqli_multi_query($_SESSION["dbconn"], $q) or die($q.' failed: ' . mysqli_error($_SESSION["dbconn"]));

            };



            //HTML TABLE CREATION
            function createHTMLtable(){


                $query = 'SELECT * FROM videos ORDER BY distance DESC LIMIT 0, 5';
                $sql_result = mysqli_query($_SESSION["dbconn"], $query) 
                                or die($query.' failed: ' . mysqli_error($_SESSION["dbconn"]));     


                echo "<table>";

                echo "<tr>".
                        "<th>video id</th>".
                        "<th>title</th>".
                        "<th>uploader</th>".
                        "<th>is it a speedrun?</th>".
                        "<th>thumbnail</th>".
                        "</tr>";


                while($row = mysqli_fetch_assoc($sql_result)) {
                        //var_dump($row);

                        echo "<tr>".
                                "<td>".isNull($row['id'])."</td>".
                                "<td>".isNull($row['title'])."</td>".
                                "<td>".isNull($row['uploader'])."</td>".
                                "<td>".isNull($row['speedrun'])."</td>".
                                "<td><img src='https://i.ytimg.com/vi/".
                                    isNull($row['id']).
                                    "/default.jpg'></img></td>".
                            "</tr>";
                        
                        $ids[] = isNull($row['id']);

                }

                echo "</table>";


            };










        /*
            THE ACTUAL PROCESS
        */



            //a set of useful SQL parameters
            $query_d2only = "(title like '%doom%' or title like '%heretic%' ". 
                            "or title like '%hexen%' or title like '%strife%' ". 
                            "or title like '%cyberdemon%' or title like '%plutonia%' ". 
                            "or title like '%wad%' or title like '%psychophobia%' ". 
                            "or title like '%skulltag%'or title like '%russian overkill%' ". 
                            "or title like '%project brutality%' or title like '%zblood%' ". 
                            "or title like '%scythe%' or title like '%Japanese Community Project%' ". 
                            "or title like '%evilution%' or title like '%bd v%' ". 
                            "or title like '%heretic 2 %' or title like '%hexen 2 %' ". 
                            "or title like '%brutal doom%' ". 

                            "or title like '%icon of sin%') ".
                            //not like 
                            "AND title not like '%doom 3%' ".
                            "AND title not like '%doom 4%' ".
                            "AND title not like '%doom 2016%' ".
                            //order by
                            "ORDER BY distance";
            

            //echo "SELECT * FROM videos WHERE ".$query_d2only."<br>";


            $limit = " LIMIT 0, 50";


            //other potentially necessary vars
            $ids = array();
            $api_result;




            /*
                MAIN CYCLE: VIDEO INFO INSERT
            */
/*

            $query = "SELECT * FROM videos WHERE checked <> 0 AND ".$query_d2only.$limit;
            $sql_result = mysqli_query($_SESSION["dbconn"], $query) 
                        or die($query.' failed: ' . mysqli_error($_SESSION["dbconn"]));   

            //according to certain parameters, do changes
            while($row = mysqli_fetch_assoc($sql_result)) {


                $api_result = sendRequest("related", $row['id']);

                //insert all the elements of the api result
                foreach(json_decode($api_result)->items as $item_array){




                    //go through the json and insert all the videos 
                    //(id, title, distance, uploader)
                    $query = 
                        "INSERT IGNORE INTO videos (id, title, distance, uploader) VALUES ('"
                        .$item_array->id->videoId."','"
                        .str_replace("'"," ",$item_array->snippet->title)."','"
                        .($row['distance']+1)."','"
                        .$item_array->snippet->channelId."')";

                    $query_b =
                        "INSERT IGNORE INTO uploaders (id) VALUES ('".$item_array->snippet->channelId."')";


                    $result = mysqli_query($_SESSION["dbconn"], $query) 
                                or die($query.' failed: ' . mysqli_error($_SESSION["dbconn"]));
                    $result = mysqli_query($_SESSION["dbconn"], $query_b) 
                                or die($query.' failed: ' . mysqli_error($_SESSION["dbconn"]));                                


                }


                //set the source column "checked"
                $query = "UPDATE videos SET checked = 1 WHERE id = '".$row['id']."'";
                $result = mysqli_query($_SESSION["dbconn"], $query) 
                            or die($query.' failed: ' . mysqli_error($_SESSION["dbconn"]));                 


                //echo $query.'<br>';
                    
            }            

 

*/

            /*

                MISSING CHANNEL INSERT

            */

            $query = "SELECT * FROM videos WHERE uploader IS NULL ORDER BY distance LIMIT 0, 50";
            $sql_result = mysqli_query($_SESSION["dbconn"], $query) 
                        or die($query.' failed: ' . mysqli_error($_SESSION["dbconn"]));          


            setMissingUploader($sql_result);            
 

            unset($row);
           



            //mysqli_close($_SESSION["dbconn"]);

        ?>

	</body>

</html>  
