$(document).ready(function(){
	$('.faqPage_content').fadeOut();
	$('.faq_page').click(function(){
		$('.faqPage_content').hide();
		$(this).next('.faqPage_content').fadeIn();
	})
});