jQuery(document).ready(function(){  
	jQuery('.show-popup').click(function(event){
		event.preventDefault();  
		jQuery('.overlay-bg').show(); 
		jQuery('.overlay-bg').css('z-index', '1002');  
	}); 
	jQuery('.close-btn').click(function(){
		jQuery('.overlay-bg').hide(); 
	});
});