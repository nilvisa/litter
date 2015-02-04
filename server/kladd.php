"(SELECT * FROM `litter`.`comment_users`
LEFT JOIN `litter`.`post.users`
ON `comment_users`.`post_id` = `post_users`.`user_id`
WHERE `comment_users`.`post_comment` LIKE '%$user%')
	UNION ALL 
(SELECT * FROM `litter`.`posts_users` 
WHERE `post_users`.`post` LIKE '%$user%')
ORDER BY `time_stamp` DESC"



ALTER VIEW litter.comment_users 
MODIFY COLUMN time_stamp AS c_time_stamp



CREATE OR REPLACE VIEW comment_users(comment_id, post_id, post_comment, Ctime_stamp, Cuser_id, Cusername, Cf_name, Cl_name, Cprofile_pic)
AS SELECT comments.comment_id, comments.post_id, comments.post_comment, comments.time_stamp, comments.user_id, users.username, users.f_name, users.l_name, users.profile_pic
FROM litter.comments
INNER JOIN litter.users
ON comments.user_id = users.user_id
ORDER BY comments.time_stamp



CREATE OR REPLACE VIEW post_users(post_id, post, post_pic, Ptime_stamp, Puser_id, Pusername, Pf_name, Pl_name, Pprofile_pic)
AS SELECT posts.post_id, posts.post, posts.post_pic, posts.time_stamp, posts.user_id, users.username, users.f_name, users.l_name, users.profile_pic
FROM litter.posts
INNER JOIN litter.users
ON posts.user_id = users.user_id
ORDER BY posts.time_stamp


SELECT * FROM `litter`.`posts`
INNER JOIN `litter`.`users`
ON `posts`.`user_id` = `users`.`user_id`
WHERE `post` LIKE '%$username%'
ORDER BY `time_stamp` DESC;