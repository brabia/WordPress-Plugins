<?php   
	/*
		Plugin Name: WP Whisper
		Description: WP Whisper is an online webmaster's community where your can share your interesting content to reach potential audiences across the world’s while they are reading interesting content.
		Plugin URI: https://wordpress.org/plugins/wp-whisper/
		Version: 1.0
		Author: Bassem Rabia
		Author URI: mailto:bassem.rabia@gmail.com
		License: GPLv2
	*/

	require_once(dirname(__FILE__).'/whisper/whisper.php');
	$whisper = new whisper();
	function whisperLang(){
		load_plugin_textdomain('whisper', false, basename(dirname(__FILE__) ).'/whisper/lang'); 
	}
	add_action('plugins_loaded', 'whisperLang');
?>