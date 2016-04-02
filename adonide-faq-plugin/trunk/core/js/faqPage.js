/***************************************************************
@
@	HTML FAQ PAGE WP class
@	bassem.rabia@hotmail.co.uk
@
/**************************************************************/  

(function() {
	tinymce.create('tinymce.plugins.FaqPageButton', {
		init : function(ed, url) {
			ed.addButton('faqPage_button', {
				title : 'FAQ HTML Page', 
				image : url+'/question-btn.png',
				onclick : function() {
					idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;  
					ed.execCommand('mceInsertContent', false, '[faq]');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : 'FAQ HTML Page Button',
				author : 'Bassem Rabia'
			};
		}
	});
	tinymce.PluginManager.add('faqPage_button', tinymce.plugins.FaqPageButton);
})();