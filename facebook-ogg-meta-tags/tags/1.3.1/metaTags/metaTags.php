<?php
/***************************************************************
	@
	@	Social Meta Tags
	@	bassem.rabia@gmail.com
	@
/**************************************************************/
class metaTags{
	public function __construct(){
		add_action('wp_head', array(&$this, 'init'));
	}		
	public function init(){
		$url = plugin_dir_url(__FILE__).'/images/512.png';
		if(has_post_thumbnail())
			$url = wp_get_attachment_url(get_post_thumbnail_id());		
		?> 
		<!-- 
			Social Meta Tags Generator
			Plugin URI: https://ml.wordpress.org/plugins/facebook-ogg-meta-tags/
		--> 
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
		<!-- ------------------ -->
		<?php
	}
}	 
?>