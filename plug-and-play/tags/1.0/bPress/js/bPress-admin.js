jQuery(document).ready(function(){	
	jQuery('#bPress_container .accordion-header:not(.accordion-notification)').click(function(index, elem){
		jQuery('.bPress_service_content').removeClass('bPress_service_content_active');	
		jQuery('#bPress_container .accordion-header i').removeClass('dashicons-arrow-down').addClass('dashicons-arrow-left');
		jQuery(this).find('i').removeClass('dashicons-arrow-left').addClass('dashicons-arrow-down');
		var bPressService = jQuery(this).attr('name');
		console.log('bPressService = '+bPressService);
		jQuery('#'+bPressService).addClass('bPress_service_content_active');
	});
	
	jQuery('#bPress_container .accordion-notification').click(function(){
		jQuery(this).remove();
	}); 
});