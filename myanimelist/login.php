<!DOCTYPE html>
<html>

	<?php session_start(); ?>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>




		</script>		
	</head>





	<body>
		<h1>Login to MyAnimeList</h1>
        <h3>Note: I don't steal your data, but have no idea about security either.</h3>
        <h3>If you afraid using your password here, who am I to blame...</h3>

		<form action="../myanimelist/watchlist.php" method="post">

			Login<br>
			<input type="text" name="login" value="Katamori"> <br>

            Password:<br>
            <input type="password" name="pw"> <br>

			<input type="submit">
		</form>                

		<?php


			//echo "teszt";




 


		?>                


	</body>



</html>