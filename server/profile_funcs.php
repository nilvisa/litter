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
	return dbArray("SELECT * FROM litter_posts 
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE litter_users.username = '$user'
		ORDER BY post_id DESC");
}

function atLink($str)
{
	if($regex = "/@+[a-zA-Z0-9_-]+/")
	{
		$str = preg_replace($regex, '<a href="profile.php?profile=$0">$0</a>', $str);
	}
	if($regex = "/#+([a-zA-Z0-9_-]+)/")
	{
		$str = preg_replace($regex, '<a href="profile.php?tag=$1">$0</a>', $str);
	}
	
	return $str;
}

function findAt($user)
{
	return dbArray("SELECT * FROM litter_posts
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE post LIKE '%$user%'
		ORDER BY litter_posts.time_stamp DESC");
}

function findHashtag($str)
{
	return dbArray("SELECT * FROM litter_posts
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE post LIKE '%$str%'
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

	return print '<img src="' .$pic. '" width="' .$size. '">';
}

function changeProfilePic()
{
	if(isset($_POST['profile_pic']))
	{			
		$user_id = $_SESSION['user_id'];
		$img = $_FILES['profile_pic'];
		$pic_name = $img['name'];
		$pic = checkIMG($img, 'userIMG/' . $user_id);

		if($pic)
		{	
			dbAdd("UPDATE litter_users
				SET profile_pic = '$pic_name'
				WHERE user_id = '$user_id'");
		}
		else
		{
			print "Bad file...";
		}		
	}	
}

function getBG($user_id)
{
	$header = dbrow("SELECT header_pic FROM litter_users
		WHERE user_id = '$user_id'");

	if(!$header['header_pic'])
	{
		$pic = 'userIMG/bg.jpg';
	}
	else
	{
		$pic = 'userIMG/'.$user_id.'/'.$header['header_pic'];
	}

	return $pic;
}

function changeBG()
{
	if(isset($_POST['header_pic']))
	{			
		$user_id = $_SESSION['user_id'];
		$img = $_FILES['header_pic'];
		$pic_name = $img['name'];
		$pic = checkIMG($img, 'userIMG/' . $user_id);

		if($pic)
		{	
			dbAdd("UPDATE litter_users
				SET header_pic = '$pic_name'
				WHERE user_id = '$user_id'");
		}
		else
		{
			print "Bad file...";
		}		
	}	
}



function follow($id)
{	
	$sess_user = $_SESSION['user_id'];

	if(isset($_POST['follow']))
	{
		dbAdd("INSERT INTO litter_following (user_id, following)
			VALUES ('$sess_user', '$id')");
	}

	if(isset($_POST['unfollow']))
	{
		dbAdd("DELETE FROM litter_following
		WHERE following = '$id' AND user_id = '$sess_user'");
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