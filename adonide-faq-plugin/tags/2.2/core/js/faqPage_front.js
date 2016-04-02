$(document).ready(function() { 
	$('#html_faq_page .faqPage_content').each(function( index ) {
		$(this).hide();
	});
});

function faqPage_tabs(element){
	$('#html_faq_page .faqPage_content').each(function( index ) {
		$(this).hide();
	});
	// $('#html_faq_page_'+element+'').fadeIn(1000);   
	
	$('#html_faq_page_'+element+'')
		.css('opacity', 0)
		.slideDown('slow')
		.animate(
		{ opacity: 1 },
		{ queue: false, duration: 'slow' }
	);
}
