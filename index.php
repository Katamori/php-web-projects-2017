<!DOCTYPE html>
<html>


	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>




		</script>		
	</head>





	<body>
		<h1>Teszt</h1>
		
		<a href="./hostinger/dblogin.php">Database operations on hostinger server</a>
		<br>
		<a href="./myanimelist/login.php">MyAnimeList API use</a>
		

		<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');

			require('./php/test.php');

			//echo "teszt";

			//echo file_get_contents('http://www.doomworld.com')."\n";

		?>                


	</body>



</html>