<?php

require_once('server/funcs.php');
require_once('server/profile_funcs.php');
require_once('server/post_funcs.php');

/* CHECK SESSION */
session_start();

if(!isset($_SESSION['username']))
{
	$_SESSION['error'] = "Sign in!";
	header('Location: form.php');
	die;
}

$user = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

if(!getSessionUser($user, $user_id))
{
	session_destroy();
	header('Location: form.php');
	die;
}


/* MESSAGE POST-IT */
print '<div id="post_it"></div>';

require_once('request.php');


/* DEFINE VARS */
$sess = getSessionUser($user, $user_id);
$get = getUser($user);
$post = getAllPosts();
$profile = 'all';
$fulltag = '';
follow($get['user_id']);
$following = getFollowing($get['user_id']);
$followers = getFollowers($get['user_id']);


/* WHICH POSTS TO SHOW*/
if(isset($_GET['profile']))
{
	$profile = ($_GET['profile']);

	if($profile == 'all')
	{
		$post = getAllPosts();
	}
	elseif($profile == 'at'.$sess['username'])
	{
		$post = findAt($sess['username']);
	}
	elseif(!$profile == getUser($profile))
	{
		print '<div class="post_it">';
		print "There's no user with that name...";
		print '</div>';
	}
	else
	{
		$post = getUserPosts($profile);
		$get = getUser($profile);
	}		
}

/* CREATE TAGS */
if(isset($_GET['tag']))
{
	$tag = preg_replace('#[^a-z0-9_]#i', '', $_GET["tag"]);
	$fulltag = "#".$tag;		
	$post = findHashtag($fulltag);
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" />
	<title>Litter</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
	<script src="js/functions.js"></script>
</head>
<body>
		
<?php
	print '<div id="header">';
		print '<h2>';
			getProfilePic($sess['user_id'], '35px'); 
			print '<a href="profile.php?profile='.$sess['username'].'">'.$sess['username'].'</a>';
		print '</h2>';
		
		print '<p><a href="logout.php">Logga ut</a></p>';
	print '</div>';

	print '<div id="logo">';
		print '<a href="index.php"><h1>litter</h1></a>';
	print '</div>';
