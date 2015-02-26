<?php
if($post == getUserPosts($profile))
{
	if(empty(getUserPosts($profile)))
	{
		if($profile !== $sess['username'])
		{
			if($profile == 'at'.$sess['username'])
			{
				print '<div class="postit"><ul><li>';
				print "You haven't been mentioned by anyone yet...";
				print '</li></ul></div>';
			}
			else
			{
				print '<div class="postit"><ul><li>';
				print atLink($get['username'])."'s too clean, no litter!";
				print '</li></ul></div>';
			}
		}
		else
		{
			print '<div class="postit"><ul><li>';
			print "It's all clean, start litter!";
			print '</li></ul></div>';
		}
	}
}


foreach($post as $post)
{
	postComment($post['post_id']);

	if($post['reply'] == 0)
	{
		if($post['recycle'] > 0)
		 {
		 	print '<div class="post paper">';
		 }
		else
		 {
		 	print '<div class="post">';
		 }

			/*DELETE_BUTTON*/
			if($sess['user_id'] == $post['user_id'])
			{
				print '<div class="del_post">';
					print '<form method="POST">
							<input type="hidden" name="post_id" value="'.$post['post_id'].'">
							<button type="submit" name="del_post"><img src="img/trashicon.png"></button>
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
				print '<div class="profile_img">'.getProfilePic($post['user_id'], '50px').'</div>';
				print isOnline($post['active']);
				print '<h4>'.$post['f_name'].' '.$post['l_name'].'</h4>';
				print '<h3> '.atLink($post['username']).'</h3><h4> recycled:</h4>';

				$post = getRecycledPost($recycle);
				print '<div class="recycled">';
				if(!$post)
				{
					print "<h2>Sorry, the original litter was trashed</h2>";
					print '<div class="hide">';
				}

			}

			/*RECYCLE_BUTTON*/
			if($post['user_id'] !== $sess['user_id'])
			{
				print '<div class="recycle">';
					print '<form method="POST">
							<input type="hidden" name="post_id" value="'.$post['post_id'].'">
							<button type="submit" name="recycle"><img src="img/recycle.png"> Recycle</button>
						</form>';
				print '</div>';
			}
			/*END RECYCLE_BUTTON*/

			/*POST*/
			print '<div class="profile_img">'.getProfilePic($post['user_id'], '50px').'</div>';
			print isOnline($post['active']);
			print '<h4>'.$post['f_name'].' '.$post['l_name'].' </h4>';
			print '<h3>'.atLink($post['username']).': </h3>';
			print '<p class="post_post">'.atLink($post['post']).'</p>';

			if($post['post_pic'])
			{
				print '<img src="userIMG/'.$post['user_id'].'/'.$post['post_pic'].'" class="post_img">';
			}
			print '<div class="time_stamp"><p>'.printTime($post['time_stamp']).'</p></div>';



			if($post == getRecycledPost($recycle))
			{
				if(!$post)print '</div>';
				print '</div>';
				$post['post_id'] = $repost_id;
				$post['username'] = $reusername;
			}
			/*END RECYCLED*/


			/*REPLY_FORM*/
			print '<div class="reply">
				<form method="POST" action="#'.$post['post_id'].'">
				<input type="text" name="comment" value="'.$post['username'].'">
				<input type="submit" name="'.$post['post_id'].'" value="Reply" class="button">
				</form>
				</div>';
			/*END REPLY_FORM*/

		print '<a name="'.$post['post_id'].'"></a>';

		print '<br></div>';

			$comments = getComment($post['post_id']);

			if(!empty($comments))
			{
				print '<div class="postit"><ul>';

					foreach($comments as $comments)
					{
						print '<li>';

							/*DELETE_BUTTON*/
							if($sess['user_id'] == $comments['user_id'])
							{
								print '<div class="del_post">';
									print '<form method="POST">
											<input type="hidden" name="post_id" value="'.$comments['post_id'].'">
											<button type="submit" name="del_comment"><img src="img/trashicon.png"></button>
										</form>';
								print '</div>';
							}
							/*END DELETE_BUTTON*/

							/*COMMENT*/
							print '<h3> '.atLink($comments['username']).':</h3>';
							print '<p>'.atLink($comments['post']).'</p>';
							print '<p class="time_stamp">'.printTime($comments['time_stamp']).'</p>';
						print '</li>';
					}

				print '</ul></div> <div class="clearfix"></div>';
			}
	}
}