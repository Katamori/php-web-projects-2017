<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>




		</script>		
	</head>





	<body>
		<h1>Katamori's php project server - AJAX login edition</h1>

        <p>The concept behind this page: to use only one page for each login. <br><br> Kinda. </p>


		<div>
			<h2>MyAnimeList login</h2>
			<h3>Note: I don't steal your data, but have no idea about security either.</h3>
			<h3>If you afraid using your password here, who am I to blame...</h3>
			<h4>(so far, it logs you in only to the watchlist listing feature - sorry)</h4>

			<form action="../ajax/myanimelist.php" method="post">

				Login<br>
				<input type="text" name="ajax_mal_login" value="Katamori"> <br>

				Password:<br>
				<input type="password" name="ajax_mal_pw"> <br>

				Choose action: <br>
				<select name="ajax_mal_action">
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
			<h3>Note: this part of the code won't work if running</h3>
			<h3> anywhere else than katamori.16mb.com</h3>
			<h4>(so far, it logs you in only to the Doom crawler server)</h4>

			<form action="../ajax/hostinger.php" method="post">

				Login<br>
				<input type="text" name="ajax_hostinger_login" value="u373989137_doom"> <br>

				Password:<br>
				<input type="password" name="ajax_hostinger_pw"><br> 

				Choose database: <br>
				<select name="ajax_hostinger_db">
					<option value="doom">Doom</option>
					<option value="misc">Misc (NOT AVAILABLE)</option>
				</select>
				<br>

				<input type="submit">
			</form> 			
		</div>

		<h2>AJAX application experiments - to use regular php form submission, <a href="../index.php">click here.</a> </h2>


		<?php


		?>                


	</body>



</html>