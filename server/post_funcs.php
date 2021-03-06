<?php
require_once('connection.php');

function createPost()
{
	if(isset($_POST['litter']))
	{
		$random = rand().rand();

		$user_id = $_SESSION['user_id'];
		$post = filter_var($_POST['post'], FILTER_SANITIZE_SPECIAL_CHARS);
		$img = $_FILES['post_pic'];
		
		if($post !== "")
		{
			if($img['name'])
			{
				$pic_name = $random.$img['name'];
				$pic = checkIMG($img, $pic_name, 'userIMG/' . $user_id);

				if($pic)
				{
					dbAdd("INSERT INTO litter_posts (user_id, post, post_pic)
						VALUES('$user_id', '$post', '$pic_name')");

					print "Your litter vas successfully posted!";
				}
				else
				{
					print "Your picture was not in a correct IMG-format...";
				}
			}
			else
			{
				dbAdd("INSERT INTO litter_posts (user_id, post)
				VALUES('$user_id', '$post')");

				print "Your litter vas successfully posted!";
			}	
		}
		else
		{
			print "Something went wrong... Please try again later!";
		}		
	}
	
}

function postComment()
{	
	if(isset($_POST['postComment']))
	{
		$user_id = $_SESSION['user_id'];
		$comment = filter_var($_POST['comment'], FILTER_SANITIZE_SPECIAL_CHARS);
		$post_id = (int)$_POST['post_id'];

		if($comment !== "")
		{
			dbAdd("INSERT INTO litter_posts (user_id, post, reply)
			VALUES ('$user_id', '$comment', '$post_id')");

			return '<h3>Your comment was successfully posted</h3>';
		}
		else
		{
			return '<h3>Something went wrong...</h3>';
		}
	}
}

function replyComment()
{	
	if(isset($_POST['reply']))
	{
		$user_id = $_SESSION['user_id'];
		$comment = filter_var($_POST['comment'], FILTER_SANITIZE_SPECIAL_CHARS);
		$reply_id = (int)$_POST['reply_id'];

		if($comment !== "")
		{
			dbAdd("INSERT INTO litter_posts (user_id, post, reply)
			VALUES ('$user_id', '$comment', '$reply_id')");

			return "Your comment was successfully posted";
		}
		else
		{
			return "Something went wrong...";
		}
	}
}

function getComment($post_id)
{
	return dbArray("SELECT * FROM litter_posts 
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE litter_posts.reply = '$post_id'
	ORDER BY litter_posts.time_stamp");
}

function getCommentsPost($reply)
{
	return dbRow("SELECT * FROM litter_posts 
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE litter_posts.post_id = '$reply'");
}

function deletePost()
{
	$sess_user = $_SESSION['user_id'];

	if(isset($_POST['del_post']))
	{
		$post_id = (int)$_POST['post_id'];		

		dbAdd("DELETE FROM litter_posts
			WHERE post_id = '$post_id'  AND user_id = '$sess_user'");

		$comments = getComment($post_id);

		if(!empty($comments))
		{
			foreach($comments as $comments)
			{
				$user_id = $comments['user_id'];

				dbAdd("DELETE FROM litter_posts
					WHERE reply = '$post_id' AND user_id = '$user_id'");
			}
		}

		return "Your post was successfully trashed!";
	}
}


function deleteComment()
{
	$sess_user = $_SESSION['user_id'];

	if(isset($_POST['del_comment']))
	{
		$post_id = (int)$_POST['post_id'];

		dbAdd("DELETE FROM litter_posts
			WHERE post_id = '$post_id' AND user_id = '$sess_user'");

		return "Your comment was successfully trashed!";
	}
}


function recycle()
{
	$user_id = $_SESSION['user_id'];

	if(isset($_POST['recycle']))
	{
		$post_id = (int)$_POST['post_id'];

		dbAdd("INSERT INTO litter_posts (user_id, recycle)
		VALUES ('$user_id', '$post_id')");

		return "Recycling is good for our planet, good on you!";
	}
}

function getRecycledPost($recycle)
{
	return dbRow("SELECT * FROM litter_posts
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE post_id = $recycle");
}

function findHashtag($str)
{
	return dbArray("SELECT * FROM litter_posts
		INNER JOIN litter_users
		ON litter_posts.user_id = litter_users.user_id
		WHERE post LIKE '%$str%'
		ORDER BY litter_posts.time_stamp DESC");
}



