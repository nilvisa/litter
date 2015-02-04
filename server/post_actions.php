<?php

require_once('connection.php');


$user_id = $_POST['user_id1'];
$comment = filter_var($_POST['comment1'], FILTER_SANITIZE_SPECIAL_CHARS);
$post_id = $_POST['post_id1'];

	dbAdd("INSERT INTO `litter`.`posts` (`user_id`, `post`, `reply`)
	VALUES ('$user_id', '$comment', '$post_id')");