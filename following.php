<?php

require_once('server/header.php');

print '<div id="whos_online">';

	print "<h3>You're following:</h3>";

	print '<div id="online_img">';

	$following = getFollowing($get['user_id']);

	if(count($following) == 0)
	{
		print "None, go follow someone!";
	}
	else
	{
		print '<div id="online_container">';
		foreach($following as $following)
		{			
			print '<div class="whos_online">';
			print '<a href="profile.php?profile='.$following['username'].'" title="'.$following['username'].'">'
			.getProfilePic($following['following'], '50px').'</a>';
			print '</div>';		
		}
		print '</div>';
	}
	print '</div>';
print '</div>';

print '<div id="wrapper">';

	if($post = getFollowingPosts())
	{
			require_once('post.php');	
	}
	else
	{
		print '<div class="postit"><ul><li>';
			print '<p>Nothing to show in you newsfeed...</p>';
		print '</li></ul></div>';
	}

print '</div>';
