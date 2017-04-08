<?php 
    session_start();
    require("../hostinger/dbjoin.php");

    if ($_SESSION['custom']['db']['name'] != "u373989137_misc"){
        echo "Database is either not selected or the wrong one is selected! <br>".
             "Thus, for safety reasons, php scripts are terminated. Log in again!";
        exit();
    }
?>

<!DOCTYPE html>
<html>

    <head>
    
    </head>

    <body>
        <h1>Coming soon!</h1>
        <p>Nah, this db slot is simply not assigned, yet...</p>
        <a href="index.php">Back to the main page</a>

        <?php 
            readfile('../html_blocks/execute_btn.html'); 
            //echo "<pre>".var_dump($r)."</pre>";

            //source: http://stackoverflow.com/a/20447057/2320153
            $doc = new DOMDocument;

            // We don't want to bother with white spaces
            $doc->preserveWhiteSpace = false;

            // Most HTML Developers are chimps and produce invalid markup...
            $doc->strictErrorChecking = false;
            $doc->recover = true;

            @$doc->loadHTMLFile('http://stackexchange.com/sites#oldest');

            $xpath = new DOMXPath($doc);

            $query = "//*[@id='content']/div/div[2]/div[1]/div[2]/div[1]/span/span";
            $entries = $xpath->query($query);
            $result = $entries->item(0)->textContent;

            echo "<pre>".print_r($result)."</pre>";


        ?>
    </body>

</html>