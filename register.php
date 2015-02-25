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
			<input type="text" name="username" placeholder="Username" 
			value="<?php if(isset($_POST['register'])){ echo htmlentities($_POST['username']);} ?>">

			<div class="clearfix"></div>

			<input type="text" name="f_name" placeholder="First Name" 
			value="<?php if(isset($_POST['register'])){ echo htmlentities($_POST['f_name']);} ?>">
			<input type="text" name="l_name" placeholder="Last Name" 
			value="<?php if(isset($_POST['register'])){ echo htmlentities($_POST['l_name']);} ?>">
			<input type="email" name="email" placeholder="E-mail" 
			value="<?php if(isset($_POST['register'])){ echo htmlentities($_POST['email']);} ?>">
			<input type="email" name="re_email" placeholder="Rewrite E-mail" 
			value="<?php if(isset($_POST['register'])){ echo htmlentities($_POST['re_email']);} ?>">

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