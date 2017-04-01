<!DOCTYPE html>
<html>

	<?php session_start(); ?>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>




		</script>		
	</head>





	<body>
		<h1>Katamori's php project server</h1>


		<div>
			<h2>MyAnimeList login</h2>
			<h3>Note: I don't steal your data, but have no idea about security either.</h3>
			<h3>If you afraid using your password here, who am I to blame...</h3>
			<h4>(so far, it logs you in only to the watchlist listing feature - sorry)</h4>

			<form action="../myanimelist/watchlist.php" method="post">

				Login<br>
				<input type="text" name="mal_login" value="Katamori"> <br>

				Password:<br>
				<input type="password" name="mal_pw"> <br>

				<input type="submit">
			</form> 
		</div>



		<div>
			<h2>Hostinger database login</h2>
			<h3>Note: this part of the code</h3>
			<h3>won't work if running anywhere else than katamori.16mb.com</h3>
			<h4>(so far, it logs you in only to the Doom crawler server)</h4>

			<form action="../hostinger/doomvids.php" method="post">

				Login<br>
				<input type="text" name="hostinger_login" value="u373989137_doom"> <br>

				Password:<br>
				<input type="password" name="hostinger_pw"> 

				<input type="submit">
			</form> 			
		</div>

<!--
		<a href="./hostinger/dblogin.php">Database operations on hostinger server</a>
		<br>
		<a href="./myanimelist/login.php">MyAnimeList API use</a>
-->		

		<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');

			//require('./php/test.php');

			//echo "teszt";

			//echo file_get_contents('http://www.doomworld.com')."\n";

		?>                


	</body>



</html>