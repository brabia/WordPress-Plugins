<?php
/***************************************************************
	@
	@	whisper
	@	bassem.rabia@gmail.com
	@
/**************************************************************/
class whisper{
	public function __construct(){
		$this->Signature = array(
			'pluginName' => 'Whisper',
			'pluginNiceName' => 'Whisper',
			'pluginSlug' => 'whisper',
			'pluginVersion' => '1.0',
			'installationId' => $this->installationId(),
			'remoteURL' => 'https://api.norfolky.com/whisper/',
		);
		add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
		add_action('admin_menu', array(&$this, 'menu'));		
		add_action('add_meta_boxes', array(&$this, 'meta_boxes_setup'));		
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		add_action('wp_head', array(&$this, 'run'));
	}
	
	public function meta_boxes_setup(){		
		add_meta_box(
			$this->Signature['pluginSlug'].'-meta_box',
			$this->Signature['pluginNiceName'], 
			array(&$this, 'meta_box'),
			'post',
			'side',
			'high',
			null
		);
	}
	
	public function meta_box($post, $box){
		$pluginOptions = get_option($this->Signature['pluginSlug']);		
		$fields = array
		(		
			'ApiKey' => $pluginOptions['api'],
			'title' => urlencode(get_the_title()), 
			'url' => esc_url(get_permalink($post->ID)),
			'body' => urlencode(get_the_title()),
			'installationId' => $pluginOptions['installationId'],
			'image' => wp_get_attachment_url(get_post_thumbnail_id($post->ID)),
			'lang' => get_locale(),
			'action' => 'MonetizeMe'
		);
		// print_r($fields);
		$url = $this->Signature['remoteURL'].'whisper.php?'.http_build_query($fields);
		// echo $url;
		?>
		<div url="<?php echo $url;?>" class="Whisper preview button"><?php _e('Whisper', 'whisper'); ?></div>
		<div class="whisper-response"></div>
		<div class="whisper-response-notice notice is-dismissible"><p></p></div>
		<div class="clear"></div>
		<?php 
	}

	public function s4($n){
		$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($str), 0, $n);		
	}
	
	public function installationId(){
		return $this->s4(10).'-'.$this->s4(5).'-'.$this->s4(5).'-'.$this->s4(5).'-'.$this->s4(15);
	}
	public function admin_enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-admin-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-admin.css', __FILE__)); 
		wp_enqueue_script($this->Signature['pluginSlug'].'-admin-script', plugins_url('js/'.$this->Signature['pluginSlug'].'-admin.js', __FILE__));
	}
	
	public function menu(){
		add_options_page( 
			$this->Signature['pluginNiceName'], 
			$this->Signature['pluginNiceName'],
			'manage_options',
			strtolower($this->Signature['pluginSlug']).'-main-menu', 
			array(&$this, 'page')
		);
		$pluginOptions = get_option($this->Signature['pluginSlug']);
		if(count($pluginOptions)==1){
			add_option($this->Signature['pluginSlug'], $this->Signature, '', 'yes');
		}
	}
	
	public function page(){
		?>
		<div class="wrap columns-2 <?php echo $this->Signature['pluginSlug'];?>_wrap">
			<div id="<?php echo $this->Signature['pluginSlug'];?>" class="icon32"></div>  
			<h2><?php echo $this->Signature['pluginName'] .' '.$this->Signature['pluginVersion']; //echo get_locale();?></h2>			
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="postbox-container-1" class="postbox-container <?php echo $this->Signature['pluginSlug'];?>_container">
						<div class="postbox">
							<h3><span><?php _e('User Guide', 'whisper'); ?></span></h3>
							<div class="inside"> 
								<ol>
									<li><?php _e('Install', 'whisper'); ?></li>
									<li><?php _e('Run', 'whisper'); ?></li>
									<li><?php _e('Enjoy', 'whisper'); ?></li>
									<li><?php _e('Ask for Support if you need', 'whisper'); ?> !</li>
								</ol>
							</div>
						</div>
					</div>									
								
					<div id="postbox-container-2" class="postbox-container">
						<div id="<?php echo $this->Signature['pluginSlug'];?>_container">
							<?php	
								$pluginOptions = get_option($this->Signature['pluginSlug']);								
								// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								if(isset($_POST[$this->Signature['pluginSlug'].'-related'])){
									$pluginOptions['related'] = empty($_POST[$this->Signature['pluginSlug'].'-related'])?'Popular In the Community':$_POST[$this->Signature['pluginSlug'].'-related'];
									$pluginOptions['postsNumber'] = empty($_POST[$this->Signature['pluginSlug'].'-postsNumber'])?'4':$_POST[$this->Signature['pluginSlug'].'-postsNumber'];
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
									update_option($this->Signature['pluginSlug'], $pluginOptions);		
									?>
									<div class="accordion-header accordion-notification accordion-notification-success">
										<i class="fa dashicons dashicons-no-alt"></i>
										<span class="dashicons dashicons-megaphone"></span>
										<?php echo $this->Signature['pluginName'];?>
										<?php echo __('has been successfully updated', 'whisper');?>.
									</div> <?php
									$pluginOptions = get_option($this->Signature['pluginSlug']);								
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								}
								$pluginOptions = get_option($this->Signature['pluginSlug']);								
								// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								if(isset($_POST[$this->Signature['pluginSlug'].'-api'])){
									$pluginOptions['api'] = $_POST[$this->Signature['pluginSlug'].'-api'];
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
									update_option($this->Signature['pluginSlug'], $pluginOptions);		
									?>
									<div class="accordion-header accordion-notification accordion-notification-success">
										<i class="fa dashicons dashicons-no-alt"></i>
										<span class="dashicons dashicons-megaphone"></span>
										<?php echo $this->Signature['pluginName'];?>
										<?php echo __('has been successfully updated', 'whisper');?>.
									</div> <?php
									$pluginOptions = get_option($this->Signature['pluginSlug']);								
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								}
							?>
							
							<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content">
								 <div class="accordion-header">
									<i class="fa dashicons dashicons-arrow-down"></i>
									<span class="dashicons dashicons-hidden"></span>
									<?php echo __('API Key', 'whisper');?>
								</div>		
								<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content <?php echo $this->Signature['pluginSlug'];?>_service_content_active">
									<form method="POST" action="" />
										<input placeholder="<?php echo __('API Key', 'whisper');?>.." class="<?php echo $this->Signature['pluginSlug'];?>_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-api" value="<?php echo $pluginOptions['api'];?>" /> 
										<p class="description"><?php echo __('API Key', 'whisper');?></p>
										<input class="<?php echo $this->Signature['pluginSlug'];?>_submit" type="submit" value="<?php echo __('Save', 'whisper');?>" />
										
										
										<?php
										$fields = array
										(		
											'PartnerEmail' => get_option('admin_email'),
											'PartnerName' => get_bloginfo('name'), 
											'PartnerURL' => esc_url(get_bloginfo('url')),
											'action' => 'Register',
											'installationId' => $this->Signature['installationId']
										);
										// print_r($fields);
										$url = $this->Signature['remoteURL'].'whisper.php?'.http_build_query($fields);	
										// echo $url;
										?>										
										<a target="_blank" class="<?php echo $this->Signature['pluginSlug'];?>_register" href="<?php echo $url;?>"><?php echo __('Register', 'web-push-notifications');?></a>
		
										<div class="clear"></div>
									</form>
								</div>
							</div>
							<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content">
								 <div class="accordion-header">
									<i class="fa dashicons dashicons-arrow-down"></i>
									<span class="dashicons dashicons-hidden"></span>
									<?php echo __('Settings', 'whisper');?>
								</div>		
								<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content <?php echo $this->Signature['pluginSlug'];?>_service_content_active">
									<form method="POST" action="" />
										<input placeholder="<?php echo __('Related articles', 'whisper');?>.." class="<?php echo $this->Signature['pluginSlug'];?>_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-related" value="<?php echo $pluginOptions['related'];?>" /> 
										<p class="description"><?php echo __('Related articles', 'whisper');?></p>
										<input placeholder="<?php echo __('Show X posts', 'whisper');?>.." class="<?php echo $this->Signature['pluginSlug'];?>_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-postsNumber" value="<?php echo $pluginOptions['postsNumber'];?>" /> 
										<p class="description"><?php echo __('Show X posts', 'whisper');?></p>
										
										<input class="<?php echo $this->Signature['pluginSlug'];?>_submit" type="submit" value="<?php echo __('Save', 'whisper');?>" />	
										<div class="clear"></div>
									</form>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
	
	public function enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-front-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-front.css', __FILE__));		
		wp_enqueue_script($this->Signature['pluginSlug'].'-front-js', plugins_url('js/'.$this->Signature['pluginSlug'].'-front.js', __FILE__));
	}
	
	public function get(){
		$pluginOptions = get_option($this->Signature['pluginSlug']);
		// echo '<pre>';print_r($pluginOptions);echo '</pre>';
		$fields = array
		(
			'action' => 'GetRelated',
			'apiKey' => $pluginOptions['api'],
			'lang' => get_locale(),										
		);
		// print_r($fields);
		$url = $this->Signature['remoteURL'].'whisper.php?'.http_build_query($fields);	
		// echo $url;
		?>
		<script>
		jQuery(document).ready(function(){
			var callback = function(){
				jQuery('.whisper-container h3').text('<?php echo ($pluginOptions['related'] == '')?__('Related articles', 'whisper'):$pluginOptions['related'];?>');	
			}			
			whisper.get('<?php echo $url;?>', callback);
		}) 
		</script>
		<?php 
	}
	
	public function run(){
		if(is_single() AND get_post_type() == 'post'){
			function my_content($content){
				global $post;		
				return $post->post_content.'<div class="whisper-container"></div>';
			}
			add_action('the_content', 'my_content');
			self::get();
		}
	}
}	 
?>