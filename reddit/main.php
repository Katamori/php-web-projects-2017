<!DOCTYPE html>
<html>

    <?php 

        require('../php/keys.php');
        session_start();

        $postdata = http_build_query(
            array(
          'grant_type' => "client_credentials",
          'user' => $Reddit_APIkey_public,
          'password' => $Reddit_APIkey_secret             
            )
        );

        /* authorization happens here */
        $authparams = array(
            'http'=>array(
                'method' => "POST",
                'header' => array(
                    'Authorization: Basic ' . base64_encode($Reddit_APIkey_public.':'.$Reddit_APIkey_secret),
                    'Content-type: application/x-www-form-urlencoded',
                ),
                'content' => $postdata                 
            )
        );        

        $rcontext = stream_context_create($authparams);

        $result = file_get_contents("https://www.reddit.com/api/v1/access_token", false, $rcontext);
        print("<pre>".print_r($result,true)."</pre>");        

    ?>

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


        <script>




        </script>	
    </head>


    <body>
        
    </body>


</html>