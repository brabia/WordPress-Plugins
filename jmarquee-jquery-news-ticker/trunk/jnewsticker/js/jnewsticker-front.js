var jnewsticker = {
	loop: function(){		
		if(parseFloat($('#jnewsticker .jnewsticker-items').css('left')||"".replace(/[^0-9-.]/g,'')) + $('#jnewsticker .jnewsticker-items').width() > 0)
			$('#jnewsticker .jnewsticker-items').css('left', parseFloat($('#jnewsticker .jnewsticker-items').css('left').replace(/[^0-9-.]/g,'')) - 1*1);
		else
			$('#jnewsticker .jnewsticker-items').attr('style', 'left:'+$('#jnewsticker .jnewsticker-items-container').width()+'px');
	},
	init: function(screenW){		
		var intervalId;
		$('#jnewsticker .jnewsticker-items').attr('style', 'left:'+screenW+'px');
		intervalId = setInterval(function(){
			jnewsticker.loop();
		}, 24)
		$('#jnewsticker .jnewsticker-items li')
		.mouseenter(function(){
			clearInterval(intervalId);
		})
		.mouseleave(function(){			
			intervalId = setInterval(function(){
				jnewsticker.loop();
			}, 24)
		});
	}
}

$(document).ready(function(){
	var screenW = $(window).width() - $('#jnewsticker .jnewsticker-header').outerWidth() - 100;
	// console.log('screenW ready', screenW, $(window).width() - $('#jnewsticker .jnewsticker-header').outerWidth() - 100);
	jnewsticker.init(screenW);	
})