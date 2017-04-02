<!DOCTYPE html>
<html>
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

			<form action="../myanimelist/mal_auth.php" method="post">

				Login<br>
				<input type="text" name="mal_login" value="Katamori"> <br>

				Password:<br>
				<input type="password" name="mal_pw"> <br>

				Choose action: <br>
				<select name="mal_action">
					<option value="watchlist">Custom watchlist</option>
					<option value="unidentified">RESERVED</option>
					<option value="unidentified">RESERVED</option>
					<option value="unidentified">RESERVED</option>
				</select>
				<br>

				<input type="submit">
			</form> 
		</div>



		<div>
			<h2>Hostinger database login</h2>
			<h3>Only for the site admin so far</h3>

			<form action="../hostinger/redirect.php" method="post">

				Login<br>
				<input type="text" name="hostinger_login" value="u373989137_doom"> <br>

				Password:<br>
				<input type="password" name="hostinger_pw"><br> 

				Choose database: <br>
				<select name="hostinger_db">
					<option value="doom">Doom</option>
					<option value="misc">Misc (NOT AVAILABLE)</option>
				</select>
				<br>

				<input type="submit">
			</form> 			
		</div>

		<h2>These are regular login forms - to try with AJAX, <a href="../ajax/login.php">click here.</a> </h2>

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