<?php

print '<div id="whos_online">';
	$following = getFollowing($get['user_id']);

	print_r($following);

	if(count($following) == 0)
	{
		print "No";
	}
	else
	{
		foreach($following as $following)
		{			
			print '<div class="whos_online">';
			print '<a href="profile.php?profile='.$following['username'].'" title="'.$following['username'].'">'
			.getProfilePic($following['user_id'], '50px').'</a>';
			print '</div>';		
		}
	}
print '</div>';