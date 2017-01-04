<?php  
/*
	Plugin Name: Social Meta Tags
	Description: Social Meta Tags will generate social media meta data for all new posts that you publish. This allows to share the right titles, descriptions, images and more when your posts are shared into Twitter, Facebook.
	Plugin URI: https://wordpress.org/plugins/facebook-ogg-meta-tags/
	Version: 1.5
	Author: Bassem Rabia
	Author URI: mailto:bassem.rabia@gmail.com
	License: GPLv2
*/

	require_once(dirname(__FILE__).'/metaTags/metaTags.php');
	$metaTags = new metaTags();
?>