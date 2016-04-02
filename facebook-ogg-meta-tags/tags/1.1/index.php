<?php  
/*
	Plugin Name: Social Meta Tags
	Description: Social Meta Tags will generate social media meta data for all new posts that you publish. This allows to share the exactly titles, descriptions, images and more when your posts are shared into Twitter, Facebook.
	Plugin URI: https://ml.wordpress.org/plugins/facebook-ogg-meta-tags/
	Version: 1.1
	Author: Bassem Rabia
	Author URI: mailto:bassem.rabia@gmail.com
	License: GPLv2
*/   

	add_action('wp_head', 'social_meta_tag');  
	function social_meta_tag(){  
		$url = wp_get_attachment_url(get_post_thumbnail_id());
		?> 
		<!-- Start of Facebook Meta Tags --> 
		<meta property="og:title" content="<?php the_title(); ?>" />
		<meta property="og:url" content="<?php the_permalink(); ?>" />
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
		<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />  
		<meta property="og:image" content="<?php echo $url ?>"/>
		<!-- End of Facebook Meta Tags -->
		
		<!-- for Twitter -->          
			<meta name="twitter:card" content="summary" />
			<meta name="twitter:title" content="<?php the_title(); ?>" />
			<meta name="twitter:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" /> 
			<meta name="twitter:image" content="<?php echo $url ?>" /> 
		<!-- End of Twitter Meta Tags -->
	<?php
	}
?>