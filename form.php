<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" />
	<title>Litter</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/mobile.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
	<script src="js/functions.js"></script>
</head>
<body>
	
	<div id="login">	

		<div id="logo">
			<h1>litter</h1>
		</div>

		<div id="login_form">
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
			    header('Location: index.php');
			    die;
			}
		?>		
			<form action="login.php" method="POST">
				<input type="text" name="username" value="" placeholder="Username">
				<input type="password" name="password" value="" placeholder="Password">
				<input type="submit" name="register" value="Login" class="button">
			</form>

			<br>
			<h2><a href="register.php">Register!</a></h2>
		</div>

			
		
	</div>

</body>
</html>

