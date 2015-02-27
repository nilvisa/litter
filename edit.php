<?php

include('header.php');

?>

<div id="edit_wrapper">
	
	<h3>Change your profile-info:</h3><br>

	<div id="change_profile">
		<form method="POST">

	<?php
			print '<h4>First Name</h4>
			<input type="text" name="f_name" value="'.$sess['f_name'].'">';

			print '<h4>Last Name</h4>
			<input type="text" name="l_name" value="'.$sess['l_name'].'">';

			print '<h4>E-mail</h4>
			<input type="email" name="email" value="'.$sess['email'].'">';
	?>
				
				<div class="clearfix"></div>
				<button type="submit" name="changeInfo" class="button">Change!</button>
			</form>
	</div>

	<div id="changePic">

		<?php	print getProfilePic($sess['user_id'], '150px'); ?>

		<form method="POST" enctype="multipart/form-data">
			
			<div class="fileinputs">
			<input type="file" name="profile_pic" class="file">

	    	<div class="fakefile">
	        	<input type="button" value="Add a picture">
	    	</div>
			</div>

			<input type="submit" name="profile_pic" value="Change!" class="button">
		</form>
	</div>
</div>


</body>
</html>

<?php

include('footer.php');

?>
