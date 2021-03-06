<?php   
	/*
		Plugin Name: Plug & Play
		Description: Plug & Play is a cross-platform WordPress library of elements for building an <strong>Elegant and Secure</strong> WordPress web site. <strong>Plug and Play</strong> our features for WordPress to Turn your WordPress Blog into a Highly Interactive Blog.
		Plugin URI: https://wordpress.org/plugins/plug-and-play/
		Version: 1.0
		Author: Bassem Rabia
		Author URI: mailto:bassem.rabia@hotmail.co.uk
		License: GPLv2
	*/
	// delete_option('bPressSignature');
	// delete_option('bPressServices');
		
	require_once(dirname(__FILE__).'/bPress/WP2P.class.php');
	$WP2P = new WP2P(); 
	function bPressLanguage(){
		load_plugin_textdomain('bPress', false, basename(dirname(__FILE__) ).'/bPress/lang'); 
	}
	add_action('plugins_loaded', 'bPressLanguage');
?>