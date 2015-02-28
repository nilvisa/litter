<?php

include('header.php');

?>

<div id="edit_wrapper">
<br>
	<h2> Are you really sure you want to delete your profile
	 and all your posts, comments and pictures!?</h2>

	 <div id="delete_user">
	 	<form method="post" action="index.php">
	 	<button type="submit" name="del_user" class="button delete">YES!</button>
	 	<a href="edit.php" class="button">NO!</a>
	 </form>
	</div>

</div>

<?php

print_r(deleteUser());

include('footer.php')

?>