<?php

session_start();
require_once('server/funcs.php');

if(stripos($_POST['username'], '@') !== false)
{
	$user = $_POST['username'];
}
else
{
	$user = '@'.$_POST['username'];
}

$pass = $_POST['password'];
$pass = md5($pass);
$data = checkUser($user, $pass);


if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(is_array($data))
		{
			$_SESSION['username'] = $user;
			$_SESSION['user_id'] = $data['user_id'];
			goOnline($user, 1);
			header('Location: profile.php');
		}
		else
		{
			$_SESSION['error'] = "That was incorrect, try again!";
			header('Location: form.php');
		}
	}

else
{
	$_SESSION['error'] = "Sign in!";
	header('Location: form.php');
}

?>
