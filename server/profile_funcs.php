<?php

require_once('connection.php');
require_once('funcs.php');


function getAllPosts()
{
	return dbArray("SELECT * FROM litter_posts 
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		ORDER BY post_id DESC");
}

function getUserPosts($user)
{
	$find = '@';
	$check = stripos($user, $find);
	if($check === false)
	{
		$user = $find.$user;
	}
	
	return dbArray("SELECT * FROM litter_posts 
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE litter_users.username = '$user'
		ORDER BY post_id DESC");
}

function atLink($str)
{
	if($regex = "/@+[a-zA-Z0-9_-å-ä-ö-Å-Ä-Ö-]+/")
	{
		$str = preg_replace($regex, '<a href="profile.php?profile=$0">$0</a>', $str);
	}
	if($regex = "/#+([a-zA-Z0-9_-å-ä-ö-Å-Ä-Ö-]+)/")
	{
		$str = preg_replace($regex, '<a href="index.php?tag=$1">$0</a>', $str);
	}
	
	return $str;
}

function findAt($user)
{
	$find = '@';
	$check = stripos($user, $find);
	if($check === false)
	{
		$user = $find.$user;
	}

	return dbArray("SELECT * FROM litter_posts
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE post LIKE '%$user%'
		ORDER BY litter_posts.time_stamp DESC");
}


function getProfilePic($user_id, $size)
{
	$profile_pic = dbrow("SELECT profile_pic FROM litter_users
		WHERE user_id = '$user_id'");

	if(!$profile_pic['profile_pic'])
	{
		$pic = 'userIMG/profile.png';
	}
	else
	{
		$pic = 'userIMG/'.$user_id.'/'.$profile_pic['profile_pic'];
	}
	
	return '<img src="' .$pic. '" height="' .$size. '">';
	

	
}

function changeProfilePic()
{
	if(isset($_POST['profile_pic']))
	{			
		$random = rand().rand();

		$user_id = $_SESSION['user_id'];
		$img = $_FILES['profile_pic'];
		$pic_name = $random = rand() . rand().$img['name'];
		$pic = checkIMG($img, $pic_name, 'userIMG/' . $user_id);

		if($pic)
		{	
			dbAdd("UPDATE litter_users
				SET profile_pic = '$pic_name'
				WHERE user_id = '$user_id'");

			return "You have a new profile pic, nice!";
		}
		else
		{
			return "Bad file...";
		}		
	}	
}

function changeInfo()
{
	if(isset($_POST['changeInfo']))
	{
		$user_id = $_SESSION['user_id'];
		$f_name = filter_var($_POST['f_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$l_name = filter_var($_POST['l_name'], FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		
		if($f_name == "" || $l_name == "" || $email == "")
			print "<h4>You can't change anything to just blank...</h4>";

		elseif($email === false)
			print "<h4>This is not a valid e-mail</h4>";

		else
		{
			dbAdd("UPDATE litter_users 
				SET f_name = '$f_name', l_name = '$l_name', email = '$email'
					WHERE user_id = '$user_id'");

			return "Your changes were made!";	
		}			
	}
	else
	{
		return "Something went wrong... Please try again later!";
	}
}


function follow()
{	
	$sess_user = $_SESSION['user_id'];
	$id = $_POST['id'];
	$username = dbRow("SELECT username FROM litter_users
		WHERE user_id = '$id'");

	if(isset($_POST['follow']))
	{
		dbAdd("INSERT INTO litter_following (user_id, following)
			VALUES ('$sess_user', '$id')");

		return "You're now following ".$username['username'];
	}

	if(isset($_POST['unfollow']))
	{
		dbAdd("DELETE FROM litter_following
		WHERE following = '$id' AND user_id = '$sess_user'");

		return "You just stopped following ".$username['username'];
	}			
}

function getFollowing($user_id)
{
	return dbArray("SELECT * FROM litter_following
		WHERE user_id = '$user_id'
		ORDER BY time_stamp DESC");
}

function getFollowers($user_id)
{
	return dbArray("SELECT * FROM litter_following
		WHERE following = '$user_id'
		ORDER BY time_stamp DESC");
}

function checkFollowing($user_id, $following)
{
	$result = dbRow("SELECT * FROM litter_following
		WHERE user_id = '$user_id' AND following = '$following'");

	if($result)
	{
		return true;
	}
}