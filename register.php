<?php
	require_once('server/funcs.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
</head>
<body>

	<form action="register.php" method="POST">
		<input type="text" name="username" value="" placeholder="Username"><br>
		<input type="text" name="f_name" value="" placeholder="First Name"><br>
		<input type="text" name="l_name" value="" placeholder="Last Name"><br>
		<input type="email" name="email" value="" placeholder="E-mail"><br>
		<input type="email" name="re_email" value="" placeholder="Rewrite E-mail"><br>
		<input type="password" name="pass" value="" placeholder="Password"><br>
		<input type="password" name="re_pass" value="" placeholder="Rewrite Password"><br><br>
		<input type="submit" name="register" value="Register">
	</form>

<br><br>

<?php

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		print createUser();
	}

?>
		
</body>
</html>