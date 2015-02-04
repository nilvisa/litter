<?php
	session_start();

	if(isset($_SESSION['error']))
	{
		print $_SESSION['error'];
		unset($_SESSION['error']);
	}
	else
	{
		print $_SESSION['error'] = "Sign in!";
	}

	if(isset($_SESSION['username'])) 
	{
	    header('Location: profile.php');
	    die;
	}
?>

<html>
	<form action="login.php" method="POST">
			<input type="text" name="username" value="" placeholder="Username">
			<input type="password" name="password" value="" placeholder="Password">
			<input type="submit" name="register" value="Login" class="button">
	</form>
	<a href="register.php">Register!</a>
</html>

