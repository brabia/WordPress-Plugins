<?php
/* 
Plugin Name: Facebook ogg Meta Tags
Plugin URI: http://www.tunicontact.com/nous-contactez/
Description: Integrate Facebook Meta Tag into your Wordpress content 
Version: 1.0
Author: Adonide WP Team
Author URI: http://www.tunicontact.com/nous-contactez/
/* ----------------------------------------------*/  
add_action('wp_head', 'facebook_meta_tag');  
function facebook_meta_tag() {  
?> 
<!-- Start of Facebook Meta Tags --> 
<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt($post->ID)); ?>" />  
<meta property="fb:admins" content="Djerba Hyaty"/>
<meta property="og:image" content="<?php echo $wpc_image_url[0] ?>"/>
<!-- End of Facebook Meta Tags -->
<?php 
}  
?>