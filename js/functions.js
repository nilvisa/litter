
function check_length(post_litter)
{
	maxLen = 140; 
	if (post_litter.post.value.length >= maxLen)
	{
		var msg = 'You have reached your maximum limit of characters allowed';
		$('#post_it').addClass('post_it')
					.html(msg+'<br><br><input type="button" id="hide_btn2" value="close">');

		$('#hide_btn2').click(function(){
		$('#post_it').hide();
		});
	
		post_litter.post.value = post_litter.post.value.substring(0, maxLen);
	 }
	else
	{ 
		post_litter.text_num.value = maxLen - post_litter.post.value.length;
	}
}

