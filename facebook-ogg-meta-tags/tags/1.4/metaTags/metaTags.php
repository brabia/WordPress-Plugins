<?php
/***************************************************************
	@
	@	Social Meta Tags
	@	bassem.rabia@gmail.com
	@
/**************************************************************/
class metaTags{
	public function __construct(){
		$this->Signature = array(
			'pluginName' => 'Social Meta Tags',
			'pluginNiceName' => 'Social Meta Tags',
			'pluginSlug' => 'social-meta-tags',
			'pluginVersion' => '1.0'
		);
		add_action('wp_head', array(&$this, 'init'));	
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		add_action('wp_head', array(&$this, 'run'));
	}

	public function enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-front-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-front.css', __FILE__));		
		wp_enqueue_script($this->Signature['pluginSlug'].'-front-js', plugins_url('js/'.$this->Signature['pluginSlug'].'-front.js', __FILE__));
	}

	public function init(){
		$url = plugin_dir_url(__FILE__).'/images/512.png';
		if(has_post_thumbnail())
			$url = wp_get_attachment_url(get_post_thumbnail_id());		
		?> 
		<!-- 
			<?php echo $this->Signature['pluginSlug'].' | '.$this->Signature['pluginVersion'];?>
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
	
	public function run(){
		if(is_single() AND get_post_type() == 'post'){
			function my_metaTags($content){
				global $post;		
				
				// echo '<pre>';print_r($post);echo '</pre>';
				return $post->post_content.'<div class="social-meta-tags-container">
					<div class="social-meta-tags-social social-meta-tags-facebook">
						<a target="_blank" href="https://www.facebook.com/sharer.php?u='.urlencode(post_permalink($post->ID)).'">Facebook</a>
						<span></span></div>
					<div class="social-meta-tags-social social-meta-tags-twitter">
						<a target="_blank" href="https://twitter.com/intent/tweet?text='.urlencode($post->post_title).'&url='.urlencode(post_permalink($post->ID)).'">Twitter</a>
						<span></span>
					</div>
					<div class="social-meta-tags-social social-meta-tags-linkedin">						
						<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&title='.urlencode($post->post_title).'&url='.urlencode(post_permalink($post->ID)).'&summary='.urlencode($post->post_excerpt).'">Linkedin</a>	
						<span></span></div>
					<div class="social-meta-tags-social social-meta-tags-google">
						<a target="_blank" href="https://plus.google.com/share?url='.urlencode(post_permalink($post->ID)).'">Google</a>						
						<span></span>
					</div>
				</div>';
			}
			add_action('the_content', 'my_metaTags');
			// self::get();
		}
	}
}	 
?>