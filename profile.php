<?php
	require_once('server/funcs.php');
	require_once('server/profile_funcs.php');
	require_once('server/post_funcs.php');

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

	$sess = getSessionUser($user, $user_id);
	$get = getUser($user);

	print '<div id="post_it"></div>';

	require_once('request.php');

	$post = getAllPosts();
	$profile = 'all';
	$fulltag = '';

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

	if(isset($_GET['tag']))
	{
		$tag = preg_replace('#[^a-z0-9_]#i', '', $_GET["tag"]);
		$fulltag = "#".$tag;		
		$post = findHashtag($fulltag);
	}
	
	follow($get['user_id']);
	$following = getFollowing($get['user_id']);
	$followers = getFollowers($get['user_id']);

?>



<html>
<head>
	<meta charset="utf-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="js/functions.js"></script>
</head>
<body>

	<div id="header">
		<h1>
			<?php getProfilePic($sess['user_id'], '35px'); 
			print atLink($sess['username']); ?>
		</h1>

		<p><a href="logout.php">Logga ut</a></p>
	</div>

	<div id="side">

		<form method="POST" enctype="multipart/form-data" name="post_litter">
			<textarea onKeyPress=check_length(this.form); onKeyDown=check_length(this.form);
			 rows="5" cols="50" name="post" placeholder="Litter some..."></textarea><br>
			 <div id="counter"><input size="1" value="140" name="text_num"></div>
			 <br>
			<input type="file" name="post_pic"> Add a picture<br>
			<input type="submit" name="litter" value="GO!" class="button">
		</form>

		<br><br>

		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="profile_pic"> Change profile pic!<br>
			<input type="submit" name="profile_pic" value="Change!" class="button">
		</form>

		<br><br>

		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="header_pic"> Change header pic!<br>
			<input type="submit" name="header_pic" value="Change!" class="button">
		</form>		

		<br><br>

<?php

		print '<a href="profile.php?profile=all">All litter</a> <br>';
		print '<a href="profile.php?profile='.$sess['username'].'">Your litter</a> <br> ';
		print '<a href="profile.php?profile=at'.$sess['username'].'">Where you have been mentioned</a>';
		print '<br><br>';

	print '</div>';

	print '<div id="wrapper">';

		if($post == getAllPosts() || $post == getUserPosts($profile) || $post == findHashtag($fulltag))
		{
			require_once('post.php');
		}
		else
		{
			if($post == findAt($sess['username']))
			{
				require_once('atpost.php');
			}
		}
		
		
		
	
	print '</div>';
	print '<div id="right">';
	print '<div id="bg" style="background: url('.getBG($get['user_id']).'); background-size: 100%; background-repeat: no-repeat;">';

	getProfilePic($get['user_id'], '150px');
	print '<br><br><br><h1>'.$get['f_name'].' '.$get['l_name'].'</h1>';
	print isOnline($get['active']);
	print '<p>'.$get['username'].'</p>';
	print '<p>Following: '.count($following).'</p>';
	print '<p>Followers: '.count($followers).'</p>';

	if($sess['user_id'] !== $get['user_id'])
	{
		if(checkFollowing($sess['user_id'], $get['user_id']))
		{
			print '<form method="POST">
						<input type="submit" name="unfollow" value="Unfollow" class="button">
					</form>';
		}
		else
		{
			print '<form method="POST">
						<input type="submit" name="follow" value="Follow" class="button">
				</form>';
		}
	}

	print "hej!";
?>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	
		$('#hide_btn').click(function(){
		$('.post_it').hide();
		$('#post_it').hide();
		});
	});	

	
		$('#hide_btn2').click(function(){
		$('#post_it').hide();
		});

</script>

</html>

	
