<?php
/***************************************************************
	@
	@	jQuery News Ticker
	@	bassem.rabia@gmail.com
	@
/**************************************************************/
class jnewsticker{
	public function __construct(){
		$this->Signature = array(
			'pluginName' => 'jQuery News Ticker',
			'pluginNiceName' => 'jQuery News Ticker',
			'pluginSlug' => 'jnewsticker',
			'pluginVersion' => '1.0',
			'position' => '0',
			'title' => 'Breaking News',
			'bg' => '4AD5C0',
			'title-bg' => '13B7A8'
		); 
		// echo '<pre>';print_r($this->Signature);echo '</pre>';
		// delete_option($this->Signature['pluginSlug'], $pluginOptions);
		
		add_action('admin_menu', array(&$this, 'menu'));
		add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		add_action('wp_footer', array(&$this, 'run'));
	}		
	public function enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-front-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-front.css', __FILE__));
		wp_enqueue_script($this->Signature['pluginSlug'].'-front-js', plugins_url('js/'.$this->Signature['pluginSlug'].'-front.js', __FILE__));
	}
	public function run(){
		$pluginOptions = get_option($this->Signature['pluginSlug']);								
		// echo '<pre>';print_r($pluginOptions);echo '</pre>';
		?>
		<div style="<?php echo ($pluginOptions['position']==1)?'bottom: 0;top: inherit;':'';?>;" id="<?php echo $this->Signature['pluginSlug'];?>">
			<div style="background:#<?php echo $pluginOptions['bg'];?>;" class="<?php echo $this->Signature['pluginSlug'];?>-container">
				<div style="background:#<?php echo $pluginOptions['title-bg'];?>;" class="<?php echo $this->Signature['pluginSlug'];?>-header"><?php echo $pluginOptions['title'];?></div>
				<div class="<?php echo $this->Signature['pluginSlug'];?>-items-container">
					<ul class="<?php echo $this->Signature['pluginSlug'];?>-items">					
						<?php 
						$args = array(
							'posts_per_page'   => 5,
							'offset'           => 0,
							'category'         => '',
							'category_name'    => '',
							'orderby'          => 'date',
							'order'            => 'DESC',
							'include'          => '',
							'exclude'          => '',
							'meta_key'         => '',
							'meta_value'       => '',
							'post_type'        => 'post',
							'post_mime_type'   => '',
							'post_parent'      => '',
							'author'	   => '',
							'post_status'      => 'publish',
							'suppress_filters' => true 
						);
						$myposts = get_posts($args);
						foreach ($myposts as $post):setup_postdata($post);?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
						<?php endforeach; 
						wp_reset_postdata();?>
					</ul>
				</div>
			</div>

		</div>
		<?php
	}
	public function admin_enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-admin-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-admin.css', __FILE__));
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
			<div id="<?php echo $this->Signature['pluginSelector'];?>" class="icon32"></div>  
			<h2><?php echo $this->Signature['pluginName'] .' '.$this->Signature['pluginVersion']; //echo get_locale();?></h2>			
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="postbox-container-1" class="postbox-container <?php echo $this->Signature['pluginSlug'];?>_container">
						<div class="postbox">
							<h3><span><?php _e('User Guide', 'jnewsticker'); ?></span></h3>
							<div class="inside"> 
								<ol>
									<li><?php _e('Install', 'jnewsticker'); ?></li>
									<li><?php _e('Run', 'jnewsticker'); ?></li>
									<li><?php _e('Enjoy', 'jnewsticker'); ?></li>
									<li><?php _e('Ask for Support if you need', 'jnewsticker'); ?> !</li>
								</ol>
							</div>
						</div>
					</div>									
								
					<div id="postbox-container-2" class="postbox-container">
						<div id="<?php echo $this->Signature['pluginSlug'];?>_container">
							<?php	
								$pluginOptions = get_option($this->Signature['pluginSlug']);								
								// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								if(isset($_POST[$this->Signature['pluginSlug'].'-title'])){
									$pluginOptions['title'] = empty($_POST[$this->Signature['pluginSlug'].'-title'])?'Breaking News':$_POST[$this->Signature['pluginSlug'].'-title'];
									$pluginOptions['bg'] = empty($_POST[$this->Signature['pluginSlug'].'-bg'])?'4FC2E5':$_POST[$this->Signature['pluginSlug'].'-bg'];
									$pluginOptions['title-bg'] = empty($_POST[$this->Signature['pluginSlug'].'-title-bg'])?'3BB0D6':$_POST[$this->Signature['pluginSlug'].'-title-bg'];
									$pluginOptions['position'] = $_POST[$this->Signature['pluginSlug'].'-position'];
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
									update_option($this->Signature['pluginSlug'], $pluginOptions);		
									?>
									<div class="accordion-header accordion-notification accordion-notification-success">
										<i class="fa dashicons dashicons-no-alt"></i>
										<span class="dashicons dashicons-megaphone"></span>
										<?php echo $this->Signature['pluginName'];?>
										<?php echo __('has been successfully updated', 'jnewsticker');?>.
									</div> <?php
									$pluginOptions = get_option($this->Signature['pluginSlug']);								
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								}
							?>
							
							<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content">
								 <div class="accordion-header">
									<i class="fa dashicons dashicons-arrow-down"></i>
									<span class="dashicons dashicons-hidden"></span>
									<?php echo __('Settings', 'jnewsticker');?>
								</div>		
								<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content jnewsticker_service_content_active">
									<form method="POST" action="" />
										<input placeholder="<?php echo __('Please insert title', 'jnewsticker');?>.." class="jnewsticker_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-title" value="<?php echo $pluginOptions['title'];?>" /> 
										<p class="description"><?php echo __('Title', 'jnewsticker');?></p>
										<input placeholder="<?php echo __('Please select background color', 'jnewsticker');?>.." class="jnewsticker_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-bg" value="<?php echo $pluginOptions['bg'];?>" /> 
										<p class="description"><?php echo __('Background color', 'jnewsticker');?></p>
										<input placeholder="<?php echo __('Please select title background', 'jnewsticker');?>.." class="jnewsticker_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-title-bg" value="<?php echo $pluginOptions['title-bg'];?>" /> 
										<p class="description"><?php echo __('Title Background', 'jnewsticker');?></p>
										<div class="jnewsticker_Opt">
											<input <?php echo ($pluginOptions['position']==0)?'checked':'';?> class="jnewsticker_radio" type="radio" name="<?php echo $this->Signature['pluginSlug'];?>-position" value="0" /> <?php echo __('Top of the page', 'jnewsticker');?> 
										</div>
										<div class="jnewsticker_Opt">
											<input <?php echo ($pluginOptions['position']==1)?'checked':'';?> class="jnewsticker_radio" type="radio" name="<?php echo $this->Signature['pluginSlug'];?>-position" value="1" /> <?php echo __('Bottom of the page', 'jnewsticker');?> 
										</div>
										<p class="description"><?php echo __('Position', 'jnewsticker');?></p> 
										<br/>
										<input class="jnewsticker_submit" type="submit" value="<?php echo __('Save', 'jnewsticker');?>" />	
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
}	 
?>