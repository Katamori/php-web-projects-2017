<!DOCTYPE html>
<html>

	<?php 
	    session_start();
	?>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>




		</script>		
	</head>





	<body>
		<h1>Login forms</h1>


		<div>
			<h2>MyAnimeList login</h2>
			<p>Note: I don't steal your data, but have no idea about security either. <br>
			   If you afraid using your password here, who am I to blame...</p>

			<form action="../myanimelist/mal_auth.php" method="post">

				Login<br>
				<input type="text" name="mal_login" value="Katamori"> <br>

				Password:<br>
				<input type="password" name="mal_pw"> <br>

				Choose action: <br>
				<select name="mal_action">
					<option value="main">Main page (not implemented yet)</option>				
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
			<p>Only for the site admin so far</p>

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

		<?php

		?>                


	</body>



</html>