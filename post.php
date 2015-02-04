<?php
if($post == getUserPosts($profile))
{
	if(empty(getUserPosts($profile)))
	{
		if($profile !== $sess['username'])
		{
			if($profile == 'at'.$sess['username'])
			{
				print '<div class="post_it">';
				print "You haven't been mentioned by anyone yet...";
				print '</div>';
			}
			else
			{
				print '<div class="post_it">';
				print atLink($get['username'])."'s too clean, no litter!";
				print '</div>';
			}
		}
		else
		{
			print '<div class="post_it">';
			print "It's all clean, start litter!";
			print '</div>';
		}
	}
}

foreach($post as $post)
{
	postComment($post['post_id']);

	if($post['reply'] == 0)
	{
		if($post['recycle'] > 0)print '<div class="post recycled">';
		else print '<div class="post">';

			/*DELETE_BUTTON*/
			if($sess['user_id'] == $post['user_id'])
			{
				print '<div class="del_post">';
					print '<form method="POST">
							<input type="hidden" name="post_id" value="'.$post['post_id'].'">
							<input type="submit" name="del_post" value="Delete" class="button">
						</form>';
				print '</div>';
			}
			/*END DELETE_BUTTON*/

			/*RECYCLED*/
			$recycle = $post['recycle'];
			$repost_id = $post['post_id'];
			$reusername = $post['username'];
			if($post['recycle'] > 0)
			{
				getProfilePic($post['user_id'], '50px');
				print '<h3> <a href="profile.php?profile='.$post['username'].'">'.$post['f_name'].' '.$post['l_name'].'</a></h3>';
				print isOnline($post['active']);
				print '<h4>'.atLink($post['username']).' recycled:</h4>';

				$post = getRecycledPost($recycle);
				print '<div class="rePost">';
				if(!$post)
				{
					print "<h2>Sorry, the original litter was trashed</h2>";
					print '<div class="hide">';
				}

			}

			/*POST*/
			getProfilePic($post['user_id'], '50px');
			print '<h3> <a href="profile.php?profile='.$post['username'].'">'.$post['f_name'].' '.$post['l_name'].'</a></h3>';
			print isOnline($post['active']);
			print '<h4>'.atLink($post['username']).': </h4>';
			print '<p>'.atLink($post['post']).'</p>';

			if($post['post_pic'])
			{
				print '<img src="userIMG/'.$post['user_id'].'/'.$post['post_pic'].'" width="400px">';
			}
			print '<p>'.$post['time_stamp'].'</p>';


			/*RECYCLE_BUTTON*/
			if($post['user_id'] !== $sess['user_id'])
			{
				print '<div class="recycle">';
					print '<form method="POST">
							<input type="hidden" name="post_id" value="'.$post['post_id'].'">
							<input type="submit" name="recycle" value="Recycle" class="button">
						</form>';
				print '</div>';
			}
			/*END RECYCLE_BUTTON*/


			if($post == getRecycledPost($recycle))
			{
				if(!$post)print '</div>';
				print '</div>';
				$post['post_id'] = $repost_id;
				$post['username'] = $reusername;
			}
			/*END RECYCLED*/

			print '<br><br>';

			$comments = getComment($post['post_id']);

			if(!empty($comments))
			{
				foreach($comments as $comments)
				{
					print '<div class="comment">';

					/*DELETE_BUTTON*/
					if($sess['user_id'] == $comments['user_id'])
					{
						print '<div class="del_comment">';
							print '<form method="POST">
									<input type="hidden" name="post_id" value="'.$comments['post_id'].'">
									<input type="submit" name="del_comment" value="Delete" class="button">
								</form>';
						print '</div>';
					}
					/*END DELETE_BUTTON*/

					/*COMMENT*/
					print '<i><h3> '.atLink($comments['username']).':</h3>';
					print '<p>'.atLink($comments['post']).'</p></i>';
					print '</div>';
				}
			}

			/*REPLY_FORM*/
			print '<form method="POST">
				<input type="text" name="comment" value="'.$post['username'].'">
				<input type="submit" name="'.$post['post_id'].'" value="Reply" class="button">
				</form>';
			/*END REPLY_FORM*/

			print '<br><br>';


		print '</div>';
	}
}