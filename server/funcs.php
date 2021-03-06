<?php

require_once('connection.php');


function checkUser($user, $pass)
{
	return dbRow("SELECT * FROM litter_users 
		WHERE username = '$user' AND pass = '$pass'");
}

function getUser($username)
{
	$find = '@';
	$check = stripos($username, $find);
	if($check === false)
	{
		$username = $find.$username;
	}

	return dbRow("SELECT * FROM litter_users 
		WHERE username = '$username'");
}

function getAllUsers()
{
	return dbArray("SELECT * FROM litter_users
				ORDER BY active DESC");
}

function getSessionUser($user, $user_id)
{
	return dbRow("SELECT * FROM litter_users
		WHERE username = '$user'
		AND user_id = '$user_id'");
}

function goOnline($user, $is)
{
	if($is == 1)
	{
		dbAdd("UPDATE litter_users
			SET active = '1'
			WHERE username = '$user'"); 
	}
	elseif(is == 0)
	{
		dbAdd("UPDATE litter_users
			SET active = '0'
			WHERE username = '$user'");
	}
}

function isOnline($active)
{
	if($active == 1)
	{
		print '<p class="online green">(online)</p>'; 
	}
	else
	{
		print '<p class="bullet">.</p>'; 
	}
}


function createUser()
{
	if(isset($_POST['register']))
	{
		$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
		$f_name = filter_var($_POST['f_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$l_name = filter_var($_POST['l_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$re_email = filter_var($_POST['re_email'], FILTER_VALIDATE_EMAIL);
		$pass = filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
		$pass = md5($pass);
		/* OBS att jag är medveten om att bara md5 inte är bra... */
		$re_pass = filter_var($_POST['re_pass'], FILTER_SANITIZE_SPECIAL_CHARS);

		$count = dbRow("SELECT COUNT(*) AS count FROM litter_users
			WHERE username = '$username'");
		
		if($username == "" || $f_name == "" || $l_name == "" || $pass == "")
			print "<h4>You didn't complete the form!</h4>";

		elseif($count['count'] > 0)
			print "<h4>This username is allreday taken!</h4>";

		elseif($email !== $re_email)
			print "<h4>The two e-mails didn't match!</h4>";

		elseif($email === false || $re_email === false)
			print "<h4>This is not a valid e-mail</h4>";

		elseif($pass !== md5($re_pass))
			print "<h4>The two passwords didn't match!</h4>";

		else
		{
			dbAdd("INSERT INTO litter_users 
		(username, f_name, l_name, email, pass)
		VALUES('@$username', '$f_name', '$l_name', '$email', '$pass')");

			$new_id = dbRow("SELECT user_id FROM litter_users
				WHERE username = '@$username'");
			mkdir('userIMG/' . $new_id['user_id']);

			session_start();
			$_SESSION['error'] = 'Your account has been created! Lets go:';
			header('Location: form.php');	
		}			
	}
	else
	{
		print "<h4>Something went wrong... Please try again later!</h4>";
	}
}

function printTime($time_stamp)
{
	$now = date('Y-m-d H:i:s');

	$years = substr($now, 0, 4);
	$months = substr($now, 5, 2);
	$days = substr($now, 8, 2);
	$hrs = substr($now, 11, 2);
	$mins = substr($now, 14, 2);

	$Tyears = substr($time_stamp, 0, 4);
	$Tmonths = substr($time_stamp, 5, 2);
	$Tdays = substr($time_stamp, 8, 2);
	$Thrs = substr($time_stamp, 11, 2);
	$Tmins = substr($time_stamp, 14, 2);

	if($years - $Tyears == 0)
		if($months - $Tmonths  == 0)
			if($days - $Tdays  == 0)
				if($hrs - $Thrs  == 0)
					if($mins - $Tmins  == 0)
						$result = 'Just now';
					else
					{
						if($mins - $Tmins > 1) {$result = $mins - $Tmins.' minutes ago';}
						else {$result = $mins - $Tmins.' minute ago';}
					}						
				else
					{
						if($hrs - $Thrs > 1) {$result = $hrs - $Thrs.' hours ago';}
						else {$result = $hrs - $Thrs.' hour ago';}
					}
			else
				{
					if($days - $Tdays > 1) {$result = $days - $Tdays.' days ago';}
					else {$result = 'yesterday';}
				}
		else
		{
			if($months - $Tmonths > 1) {$result = $months - $Tmonths.' months ago';}
			else {$result = 'last month';}
		}
	else
	{
		if($years - $Tyears > 1) {$result = $years - $Tyears.' years ago';}
		else {$result = 'last year';}
	}

	return $result;

}









