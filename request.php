<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		print '<div class="post_it"><h3>';

		if(isset($_POST['litter']))
		{
			print createPost();
		}
		if(isset($_POST['postComment']))
		{
			print postComment();
		}
		if(isset($_POST['reply']))
		{
			print replyComment();
		}		
		if(isset($_POST['profile_pic']))
		{
			print changeProfilePic();
		}
		if(isset($_POST['del_post']))
		{
			print deletePost();
		}
		if(isset($_POST['del_comment']))
		{
			print deleteComment();
		}
		if(isset($_POST['recycle']))
		{
			print recycle();
		}

		print '</h3><button type="button" id="hide_btn" class="button">close</button>';
		print '</div>';		

	}