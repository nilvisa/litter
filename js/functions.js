
function check_length(post_litter)
{
	maxLen = 140; 
	if (post_litter.post.value.length >= maxLen)
	{
		var msg = '<p>You have reached the maximum limit of characters allowed';
		$('#post_it').addClass('post_it')
					.html(msg+'<br><br><button type="button" id="hide_btn2" class="button">close</button></p>');

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



/* SCROLL */

$(document).ready(function(){
	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
	});
	
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
	
});
