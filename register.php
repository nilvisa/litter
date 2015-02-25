<?php
	require_once('server/funcs.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" />
	<title>Litter</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
	<script src="js/functions.js"></script>
</head>
<body>

<div id="register">

	<div id="logo">
		<h1><a href="index.php">litter</a></h1>
	</div>

	<div id="register_form">
		<h2>Create an accont!</h2>

		<form action="register.php" method="POST">
			<input type="text" name="username" value="" placeholder="Username">

			<div class="clearfix"></div>

			<input type="text" name="f_name" value="" placeholder="First Name">
			<input type="text" name="l_name" value="" placeholder="Last Name">
			<input type="email" name="email" value="" placeholder="E-mail">
			<input type="email" name="re_email" value="" placeholder="Rewrite E-mail">
			<input type="password" name="pass" value="" placeholder="Password">
			<input type="password" name="re_pass" value="" placeholder="Rewrite Password">
			
			<div class="clearfix"></div>
			<button type="submit" name="register" class="button">Register</button>
		</form>
	</div>

<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		print createUser();
	}

?>
</div>
		
</body>
</html>