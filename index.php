<!DOCTYPE html>
<html>

	<?php 
	    session_start();
        $_SESSION["custom"] = array();
		readfile('./html_blocks/fork-me.html'); 
	?>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


		<script>




		</script>		
	</head>

	<body>
		<h1>Katamori's php project server</h1>

		<ol>
			<li>
				<a href="login.php">Login for various services</a>			
			</li>
<!--
			<li>
				<a href="reddit/main.php">Custom Reddit front paae</a>			
			</li>
-->
			<li>
				<a href="code-golf.php">My code golf contributions to CodeGolf.SE</a>			
			</li>			
		</ol>

		<?php
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');

		?>                


	</body>



</html>