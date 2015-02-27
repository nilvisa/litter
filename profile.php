<?php

include('header.php');

?>

<div id="main">

	<div id="litter_form">
		<form method="POST" enctype="multipart/form-data" name="post_litter">
			<textarea onKeyPress=check_length(this.form); onKeyDown=check_length(this.form);
			 rows="5" cols="50" name="post" placeholder="Litter some..."></textarea>
			 <div id="counter"><input size="1" value="140" name="text_num"></div>

			 <div class="fileinputs">
	       		<input type="file" name="post_pic" class="file">

	        	<div class="fakefile">
	            	<input type="button" value="Add a picture">
	        	</div>
	    	</div>
			
			<button type="submit" name="litter" class="button">GO!</button>
		</form>
	</div>



<?php
		print '<div id="profile">';

			print getProfilePic($get['user_id'], '150px');
			print '<br>';
			print '<h2>'.$get['f_name'].' '.$get['l_name'].'</h2>';
			print '<h3> '.$get['username'].'</h3>';

			isOnline($get['active']);

			if(!$get['active'])
			{
				print '<p>(Last here: '.printTime($get['last_in']).')</p>';
			}


			/* FOLLOW */

			$following = getFollowing($get['user_id']);
			$followers = getFollowers($get['user_id']);
						
			if($sess['user_id'] !== $get['user_id'])
			{
				if(checkFollowing($sess['user_id'], $get['user_id']))
				{
					print '<form method="POST">
								<input type="hidden" name="id" value="'.$get['user_id'].'">
								<button type="submit" name="unfollow" class="button">Unfollow</button>
							</form>';
				}
				else
				{
					print '<form method="POST">
								<input type="hidden" name="id" value="'.$get['user_id'].'">
								<button type="submit" name="follow" class="button">Follow</button>
						</form>';
				}
			}
			print '<p>Following: '.count($following).'</p>';
			print '<p>Followers: '.count($followers).'</p>';

			// print '<div>';
			// 	require_once('following.php');
			// print '</div>';



			if($sess['user_id'] == $get ['user_id'])
			{
				print '<br><a href="profile.php?profile=at'.$sess['username'].'">See where you have been mentioned</a><br>';
				print '<a href="edit.php">Edit your settings</a>';
			}


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

include('footer.php');

?>
