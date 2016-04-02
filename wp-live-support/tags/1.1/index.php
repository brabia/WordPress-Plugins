<?php   
/*
	Plugin Name: WordPress Live Support
	Description: WP Live Support, your Powerful, Simple and Flexible WordPress Live Support. Use WP Live Support to Chats Live with our WP experts.
	Plugin URI: https://wordpress.org/plugins/wp-live-support/
	Version: 1.1
	Author: Bassem Rabia
	Author URI: mailto:bassem.rabia@hotmail.co.uk
	License: GPLv2
*/  
	$plugin_name 	= 'WordPress Live Support';
	$plugin_version = '1.1'; 
	require_once(dirname(__FILE__).'/core/wordpress-live-support.php');  
	$WordPressLiveSupport = new WordPressLiveSupport($plugin_name, $plugin_version); 
	function WordPressLiveLanguage() {
		load_plugin_textdomain('wordpress-live-support', false, basename(dirname(__FILE__) ).'/core/lang'); 
	}
	add_action('plugins_loaded', 'WordPressLiveLanguage'); 
?>