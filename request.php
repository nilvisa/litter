<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	
		print '<div class="post_it">';

		if(isset($_POST['litter']))
		{
			createPost();
		}		
		if(isset($_POST['profile_pic']))
		{
			print changeProfilePic();
		}
		if(isset($_POST['header_pic']))
		{
			print changeBG();
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

		print '<input type="button" id="hide_btn" value="close">';
		print '</div>';		

	}