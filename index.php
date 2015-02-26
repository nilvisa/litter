<?php

include('header.php');

?>

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

print '<div id="wrapper">';

	require_once('post.php');

print '</div>';


print '<div id="whos_online">';
	$online = whosOnline();

	print "<h3>Who's here now:</h3>";

	if(count($online) == 1)
	{
		print "It's only you here...";
	}
	else
	{
		foreach($online as $online)
		{
			if($online['user_id'] !== $sess['user_id'])
			{
				print '<a href="profile.php?profile='.$online['username'].'" title="'.$online['username'].'">'.getProfilePic($online['user_id'], '50px').'</a>';
			}		
		}
	}
print '</div>';

include('footer.php');

?>
