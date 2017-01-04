<?php  
/*
	Plugin Name: Social Meta Tags Generator
	Description: Social Meta Tags will generate social media meta data for all new posts that you publish. 
	This allows to share the right titles, descriptions, images and more when your posts are shared into Twitter, Facebook.
	Plugin URI: https://ml.wordpress.org/plugins/facebook-ogg-meta-tags/
	Version: 1.3
	Author: Bassem Rabia
	Author URI: mailto:bassem.rabia@gmail.com
	License: GPLv2
*/   

	add_action('wp_head', 'social_meta_tag');  
	function social_meta_tag(){  
		$url = wp_get_attachment_url(get_post_thumbnail_id());
		?> 
		<!-- Social Meta Tags Start --> 
			<!-- Google+ -->
			<meta itemprop="name" content="<?php the_title(); ?>">
			<meta itemprop="description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>">
			<meta itemprop="image" content="<?php echo $url ?>">
			<!-- Facebook -->
			<meta property="og:title" content="<?php the_title(); ?>" />
			<meta property="og:type" content="article" />
			<meta property="og:url" content="<?php the_permalink(); ?>" />
			<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
			<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />  
			<meta property="og:image" content="<?php echo $url ?>"/>      
			<!-- Twitter -->
			<meta name="twitter:card" content="summary" />
			<meta name="twitter:title" content="<?php the_title(); ?>" />
			<meta name="twitter:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" /> 
			<meta name="twitter:image" content="<?php echo $url ?>" /> 
		<!-- Social Meta Tags Start End -->
	<?php
	}
?>