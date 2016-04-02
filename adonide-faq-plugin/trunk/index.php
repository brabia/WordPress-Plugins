<?php   
/*
	Plugin Name: FAQ plugin
	Description: FAQ plugin is a quick, easy way to add an FAQs page.
	Plugin URI: http://wordpress.org/extend/plugins/adonide-faq-plugin/
	Version: 2.2.2
	Author: Bassem Rabia
	Author URI: mailto:bassem.rabia@gmail.com
	License: GPLv2
*/   

	// delete_option('faqPage_plugin_signature');  
	if(realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
		exit("Do not access this file directly."); 
	else{ 
		$plugin_name 	= 'HTML FAQ PAGE';
		$plugin_version = '2.2.2';
		require_once(dirname(__FILE__).'/core/html-faq-page.php');  
		$faqPage = new faqPage($plugin_name, $plugin_version); 
		
		require_once(dirname(__FILE__).'/core/html-faq-page-postType.php');  
		$faqPagePost = new faqPage_postType($plugin_name, $plugin_version);  
		
		function html_faq_page_textdomain() {
			load_plugin_textdomain('html-faq-page', false, basename(dirname(__FILE__)).'/core/lang'); 
		}
		add_action('plugins_loaded', 'html_faq_page_textdomain'); 
	} 
?>