var whisper = {
	set: function(url){
		var contentType ="application/x-www-form-urlencoded; charset=utf-8";
		if(window.XDomainRequest){
			contentType = 'text/plain';
		}	

		jQuery.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: '{"some":"json"}',
			contentType: contentType,
			success:function(data){
				// console.log(data)
				jQuery('.whisper-response-notice').fadeIn().addClass('notice-success').find('p').text(data.message);
			}, 
			error:function(jqXHR,textStatus,errorThrown){
				// alert("You can not send Cross Domain AJAX requests: "+errorThrown);
			}
		});
	}
}

jQuery(document).ready(function(){		
	jQuery('.Whisper').click(function(){
		var url = jQuery(this).attr('url');
		if(url!='')
			whisper.set(url);
	})
})