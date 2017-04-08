<!DOCTYPE html>
<html>

	<?php 
	    session_start();
		readfile('./html_blocks/fork-me.html'); 
	?>

	<head>
		<title>Login</title>
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

			<?php 

			/*
				optional write-out of login form
			*/

				$temp = $_SESSION['custom']['mal']['logged_in'];

				if(isset($temp) && $temp != 0){
					echo 'You\'re already logged in, choose an option below to proceed.';
				}else{ 
					readfile('./html_blocks/login_mal.html'); 
				};

			?>

			Choose action: <br>
			<select name="mal_action">
				<option value="main">Main page (not implemented yet)</option>				
				<option value="watchlist" selected>Custom watchlist</option>
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

		<?php 

		/*
			optional write-out of login form
		*/

			$temp = $_SESSION['custom']['db']['pw'];
			if(isset($temp) && $temp != ""){
				echo 'You\'re already logged in, <a href="../hostinger/db_doom.php">click here to proceed.</a> ';
			}else{ 
				readfile('./html_blocks/login_db.html'); 
			};
		?>
		
	</div>



		

		<?php

		?>                


	</body>



</html>