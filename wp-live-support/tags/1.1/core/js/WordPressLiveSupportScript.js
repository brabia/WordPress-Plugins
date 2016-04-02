jQuery(document).ready(function(){  
	jQuery('#WordPressLiveSupportTabs .WordPressLiveSupportTab').click(function(event){
		var WordPressLiveSupportTab = jQuery(this).attr('name');
		jQuery('.WordPressLiveSupportTab').removeClass('WordPressLiveSupportActiveTab');
		jQuery(this).addClass('WordPressLiveSupportActiveTab'); 
		jQuery('.WordPressLiveSupportContent').removeClass('WordPressLiveSupportActiveContent');
		jQuery('#'+WordPressLiveSupportTab).addClass('WordPressLiveSupportActiveContent');
	}); 
});