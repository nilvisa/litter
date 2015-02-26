<?php

include('header.php');

?>


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

</body>
</html>