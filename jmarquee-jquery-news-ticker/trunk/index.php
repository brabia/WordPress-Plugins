<?php   
	/*
		Plugin Name: jMarquee - jQuery News Ticker
		Description: jMarquee is an easy Pre-packed jQuery News Ticker plugin with ready to use styles.
		Plugin URI: https://wordpress.org/plugins/norfolky-jmarquee/
		Version: 1.0
		Author: Bassem Rabia
		Author URI: mailto:bassem.rabia@gmail.com
		License: GPLv2
	*/

	require_once(dirname(__FILE__).'/jnewsticker/jnewsticker.php');
	$jnewsticker = new jnewsticker();
	function jnewsticker_language(){
		load_plugin_textdomain('jnewsticker', false, basename(dirname(__FILE__) ).'/jnewsticker/lang'); 
	}
	add_action('plugins_loaded', 'jnewsticker_language');
?>