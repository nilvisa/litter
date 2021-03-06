<?php
require_once('funcs.php');
require_once('profile_funcs.php');
require_once('post_funcs.php');

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

/* WHICH POSTS TO SHOW*/
if(isset($_GET['profile']))
{
	$profile = preg_replace("/[^a-zA-Z0-9@#]/","",$_GET['profile']);

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
		print '<div class="post_it"><h3>';
		print "There's no user with that name...";
		print '</h3><button type="button" id="hide_btn" class="button">close</button></div>';
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
	$tag = preg_replace('#[^a-z0-9_-å-ä-ö-Å-Ä-Ö-]#i', '', $_GET["tag"]);
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
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/mobile.css" rel="stylesheet" type="text/css">
</head>
<body>


<div id="header">
	<div id="get_user">
		<h2>
<?php
		print getProfilePic($sess['user_id'], 45); 
		print '<div id="user"><a href="profile.php?profile='.$sess['username'].'">'.$sess['username'].'</a></div>';
?>
		</h2>
	</div>

	<div id="search_form">
		<form method="GET" action="profile.php">
			<input type="text" name="profile" placeholder="Find @">
		</form>
	</div>

	<div id="logout">
		<p><a href="logout.php">Log out</a></p>
	</div>
</div>


<div id="logo">
	<h1><a href="index.php">litter</a></h1>
</div>


