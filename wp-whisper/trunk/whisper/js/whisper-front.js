var whisper = {
	get: function(url, callback){
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
				if(data.length > 0){
					jQuery('.whisper-container').append('<h3></h3><div class="whisper-content"></div>');
					// console.log('callback', callback);
					callback();
					jQuery('.whisper-content').html('');
					jQuery.each(data, function(k, v){
						jQuery('.whisper-content').append('<div class="whisper-article"><a target="_blank" href="'+v.url+'"><div class="img" style="background:url('+v.img+')"></div><h5>'+v.title+'</h5></a></div>');
					})
				}							
			},
			error:function(jqXHR,textStatus,errorThrown){
				//alert("You can not send Cross Domain AJAX requests: "+errorThrown);
			}
		});
	}
}