<?php

require_once('connection.php');


function checkUser($user, $pass)
{
	return dbRow("SELECT * FROM `litter`.`users` 
		WHERE `username` = '$user' AND `pass` = '$pass'");
}

function getUser($username)
{
	return dbRow("SELECT * FROM `litter`.`users` 
		WHERE `username` = '$username'");
}

function getSessionUser($user, $user_id)
{
	return dbRow("SELECT * FROM `litter`.`users`
		WHERE `username` = '$user'
		AND `user_id` = '$user_id'");
}

function goOnline($user, $is)
{
	if($is == 1)
	{
		dbAdd("UPDATE `litter`.`users`
			SET `active` = '1'
			WHERE `username` = '$user'"); 
	}
	elseif(is == 0)
	{
		dbAdd("UPDATE `litter`.`users`
			SET `active` = '0'
			WHERE `username` = '$user'");
	}
}

function isOnline($active)
{
	if($active == 1)
	{
		print '<span class="bullet green">.</span>'; 
	}
	else
	{
		print '<span class="bullet">.</span>'; 
	}
}


function createUser()
{

	if($_POST['register'])
	{
		$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
		$f_name = filter_var($_POST['f_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$l_name = filter_var($_POST['l_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$re_email = filter_var($_POST['re_email'], FILTER_VALIDATE_EMAIL);
		$pass = filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
		$pass = md5($pass);
		$re_pass = filter_var($_POST['re_pass'], FILTER_SANITIZE_SPECIAL_CHARS);

		$count = dbRow("SELECT COUNT(*) AS count FROM litter.users
			WHERE username = '$username'");
		
		if($username == "")
			print "Username!";

		elseif($count['count'] > 0)
			print "This username is allreday taken!";

		elseif($email !== $re_email)
			print "The two e-mails didn't match!";

		elseif($email === false || $re_email === false)
			print "This is not a valid e-mail";

		else
		{
			dbAdd("INSERT INTO `litter`.`users` 
		(`username`, `f_name`, `l_name`, `email`, `pass`)
		VALUES('@$username', '$f_name', '$l_name', '$email', '$pass')");

			$new_id = dbRow("SELECT `user_id` FROM `litter`.`users`
				WHERE `username` = '@$username'");
			mkdir('userIMG/' . $new_id['user_id']);

			session_start();
			$_SESSION['error'] = 'Your account has been created! Lets go:';
			header('Location: form.php');	
		}			
	}
	else
	{
		print "Something went wrong... Please try again later!";
	}
}





