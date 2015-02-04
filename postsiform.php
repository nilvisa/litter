<?php
	require_once('server/funcs.php');
	require_once('server/profile_funcs.php');

	session_start();

	if(!isset($_SESSION['username']))
	{
		$_SESSION['error'] = "Logga in!";
		header('Location: form.php');
		die;
	}

	$user = $_SESSION['username'];
	$user_id = $_SESSION['user_id'];
	print '<h1>' . $user . '</h1>';
	print '<p><a href="logout.php">Logga ut</a></p>';

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(!empty($_POST['litter']))
		{
			print createPost();
		}
		if(!empty($_POST['profile_pic']))
		{
			print changeProfilePic();
		}
		
	}
	
	
?>



<html>
<head><meta charset="utf-8"></head>

	<form action="profile.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="profile_pic"> Change profile pic!<br>
		<input type="submit" name="profile_pic" value="Change!" class="button">
	</form>
	<?php getProfilePic($user_id, '150px'); ?>

	<br><br>	

	<form action="profile.php" method="POST" enctype="multipart/form-data">
			<textarea rows="5" cols="50" name="post" placeholder="Litter some..."></textarea>
			<br>
			<input type="file" name="post_pic"> Add a picture<br>
			<input type="submit" name="litter" value="GO!" class="button">
	</form>

</html>

<?php
	


	


	$post = getAllPosts($user);

	foreach($post as $post)
	{
		print '<p>' .sincePosted(). '</p><br>';
		print '<h3>';
		getProfilePic($post['user_id'], '50px');
		print ' ' . $post['username'] . ': </h3>';
		print '<form><input type="text" size="20" value="' . $post['post'] . '"></form>';

		if($post['post_pic'])
		{
			print '<img src="userIMG/' . $post['user_id'] . '/' . $post['post_pic'] . '" width="400px">';
		}
		print '<p>' . $post['time_stamp'] . '</p>';
		print '<br><br>';
		
	}
	

	hej jag heter Hej jag heter johan vad heter du?


	

	
