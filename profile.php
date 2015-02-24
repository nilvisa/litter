<?php

include('header.php');

?>

<div id="main">

	<div id="litter_form">
		<form method="POST" enctype="multipart/form-data" name="post_litter">
			<textarea onKeyPress=check_length(this.form); onKeyDown=check_length(this.form);
			 rows="5" cols="50" name="post" placeholder="Litter some..."></textarea><br>
			 <div id="counter"><input size="1" value="140" name="text_num"></div>
			 <br>
			<input type="file" name="post_pic"> Add a picture<br>
			<input type="submit" name="litter" value="GO!" class="button">
		</form>
	</div>


	<div id="change_profile">
		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="profile_pic"> Change profile pic!<br>
			<input type="submit" name="profile_pic" value="Change!" class="button">
		</form>
	</div>


	<div id="change_header">
		<form method="POST" enctype="multipart/form-data">
			<input type="file" name="header_pic"> Change header pic!<br>
			<input type="submit" name="header_pic" value="Change!" class="button">
		</form>
	</div>


<?php
		print '<div id="profile">';
			print '<div id="bg" style="background: url('.getBG($get['user_id']).'); background-size: 100%; background-repeat: no-repeat;">';

			getProfilePic($get['user_id'], '150px');
			print '<br><br><br><h2>'.$get['f_name'].' '.$get['l_name'].'</h2>';
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
			print '<a href="profile.php?profile=at'.$sess['username'].'">Where you have been mentioned</a>';
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
?>
	</div>

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

	
