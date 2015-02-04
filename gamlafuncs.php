<?php

require_once('connection.php');


function getUser($connect, $user, $pass)
{
	$query = mysqli_query($connect,
		"SELECT * FROM litter.users 
		WHERE username = '$user' AND pass = '$pass'");
		
	
	$row = mysqli_fetch_assoc($query);
	return $row;

	mysqli_free_result($query);
	mysqli_close($connect);
}


function getUserPosts($connect, $user)
{
	$query = mysqli_query($connect,
		"SELECT post, post_pic, username FROM litter.posts 
		INNER JOIN litter.users
		ON posts.user_id = users.user_id
		WHERE users.username = '$user'
		ORDER BY post_id DESC");
	
	$array = [];

	if($query)
	{
		while($row = mysqli_fetch_assoc($query))
		{
			$array[] = $row;
		}
		return $array;

		mysqli_free_result($query);	
		mysqli_close($connect);
	}	
}

function getAllPosts($connect)
{
	$query = mysqli_query($connect,
		"SELECT post, post_pic, username FROM litter.posts 
		INNER JOIN litter.users
		ON posts.user_id = users.user_id
		ORDER BY post_id DESC");
	
	$array = [];

	if($query)
	{
		while($row = mysqli_fetch_assoc($query))
		{
			$array[] = $row;
		}
		return $array;

		mysqli_free_result($query);	
		mysqli_close($connect);
	}	
}

function registerUser($connect, $username, $f_name, $l_name, $email, $pass)
{
	mysqli_query($connect, 
		"INSERT INTO `litter`.`users` 
		(`username`, `f_name`, `l_name`, `email`, `pass`)
		VALUES('$username', '$f_name', '$l_name', '$email', '$pass')");
}

function createUser($connect)
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
		$f_name = filter_var($_POST['f_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$l_name = filter_var($_POST['l_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$re_email = filter_var($_POST['re_email'], FILTER_VALIDATE_EMAIL);
		$pass = filter_var($_POST['pass'], FILTER_SANITIZE_SPECIAL_CHARS);
		$pass = md5($pass);
		$re_pass = filter_var($_POST['re_pass'], FILTER_SANITIZE_SPECIAL_CHARS);

		$count = mysqli_query($connect,
			"SELECT COUNT(*) AS count FROM litter.users
			WHERE username = '$username'");
		$countRow = mysqli_fetch_assoc($count);


		if($username == "")
			$error = "Username!";

		elseif($countRow['count'] > 0)
			$error = "This username is allreday taken!";

		elseif($email !== $re_email)
			$error = "The two e-mails didn't match!";

		elseif($email === false || $re_email === false)
			$error = "This is not a valid e-mail";

		else
		{
			registerUser($connect, $username, $f_name, $l_name, $email, $pass);
			header('Location: login.php');	
		}			

	}

	print $error;
}

