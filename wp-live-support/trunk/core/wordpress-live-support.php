<?php
/***************************************************************
	@
	@	WordPressLiveSupport class
	@	bassem.rabia@hotmail.co.uk
	@
/**************************************************************/
class WordPressLiveSupport{   
	/***************************************************************
	@
	@	WordPress Live Support Construct
	@
	/**************************************************************/
	public function __construct($name, $ver){
		$this->plugin_name 					= $name;
		$this->plugin_version				= $ver;  
		$this->WordPressLiveSupportSignature();   
		add_action('admin_menu',array(&$this,'WordPressLiveSupportMenu'));  
		add_action('admin_enqueue_scripts',array(&$this,'WordPressLiveSupportStyle'));  
		add_action('in_admin_footer',array(&$this,'WordPressLiveSupportZopim'));  
		add_action('admin_enqueue_scripts',array(&$this,'WordPressLiveSupportScript'));
		add_action('wp_dashboard_setup',array(&$this,'WordPressLiveSupportDashboard')); 
	} 
	
	/***************************************************************
	@
	@	WordPress Live Support Remote Script
	@
	/**************************************************************/
	public function WordPressLiveSupportScript(){
		wp_enqueue_script('WordPressLiveSupportScript', plugins_url('js/WordPressLiveSupportScript.js', __FILE__)); 
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Remote Information
	@
	/**************************************************************/
	public function WordPressLiveSupportRemoteInformation($Data){
		$GetWordPressLiveSupportSignature = get_option('WordPressLiveSupportSignature'); 
		$Remote = 'http://norfolky.com/RemoteData/index.php'; 
		$api_params = array( 
            'WordPressLiveSupportAction'	=> $Data, 
            'WordPressLiveSupportUser'		=> urlencode(get_option('admin_email')),
            'WordPressLiveSupportLicense'	=> urlencode($GetWordPressLiveSupportSignature['WordPressLiveSupportKey'])
        );   
		$response = wp_remote_get(add_query_arg($api_params, $Remote)); 
		if(is_wp_error($response)){
		   $error_message = $response->get_error_message();
		   echo "Something went wrong: $error_message";
		}else{ 
			return($response['body']) ;
		} 	
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Dashboard
	@
	/**************************************************************/
	public function WordPressLiveSupportDashboard(){ 
		wp_add_dashboard_widget('dashboard_widget', $this->plugin_name .' '.$this->plugin_version, 'WordPressLiveSupportDashboardFunction'); 
		function WordPressLiveSupportDashboardFunction($post, $callback_args){
			$WordPressLiveSupportHash = hash('sha256', 'UserID'-'UserSlat');
			?>
			<ul class="WordPressLiveSupportDashboard">
				<li class="WordPressLiveSupportDashboardLogin"><a href=""><?php _e('My Account', 'wordpress-live-support');?></a></li>
				<li class="WordPressLiveSupportDashboardSettings"><a href="admin.php?page=wordpress-live-support-menu"><?php _e('Configure', 'wordpress-live-support');?></a></li> 
			</ul>
			<?php
		}
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Style
	@
	/**************************************************************/
	public function WordPressLiveSupportZopim(){ 
		// echo 'WordPressLiveSupportZopim';
		$GetWordPressLiveSupportSignature = get_option('WordPressLiveSupportSignature'); 
		?>
		<!--Start of Zopim Live Chat Script-->
		<script type="text/javascript">
			window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
			d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
			_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
			$.src='//v2.zopim.com/?2eLJjKHcskgd7DZEgA24IS0iZc658oDU';z.t=+new Date;$.
			type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
			$zopim(function(){
				$zopim.livechat.set({
					name: '<?php echo get_bloginfo('url');?>',
					phone: '<?php echo $GetWordPressLiveSupportSignature['WordPressLiveSupportKey'];?>',
					email: '<?php echo $GetWordPressLiveSupportSignature['WordPressLiveSupportUser'];?>' 
				});
			}); 
		</script> 
		<!--End of Zopim Live Chat Script-->
		<?php 
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Style
	@
	/**************************************************************/
	public function WordPressLiveSupportStyle(){ 
		wp_enqueue_style('wordpress-live-support-style', plugins_url('css/WordPressLiveSupport.css', __FILE__));  
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Menu
	@
	/**************************************************************/
	public function WordPressLiveSupportMenu(){
		add_menu_page('WP Live Support', 'WP Live Support', 'manage_options', 'wordpress-live-support-menu', array(&$this,'WordPressLiveSupportPage'), plugins_url('wp-live-support/core/images/icon.png'), 100); 		
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Pro
	@
	/**************************************************************/
	public function WordPressLiveSupportPro($WordPressLiveSupportKey){ 
		global $wp_roles;
		$UsersRole = $wp_roles->get_names(); 
		$GetWordPressLiveSupportSignature = get_option('WordPressLiveSupportSignature');
		$WordPressLiveSupportSignature = array(
			'WordPressLiveSupportName'			=> $GetWordPressLiveSupportSignature['WordPressLiveSupportName'],
			'WordPressLiveSupportVersion'		=> $GetWordPressLiveSupportSignature['WordPressLiveSupportVersion'],
			'WordPressLiveSupportUser'			=> $GetWordPressLiveSupportSignature['WordPressLiveSupportUser'], 
			'WordPressLiveSupportKey'			=> $WordPressLiveSupportKey
		); 
		foreach($UsersRole as $role){  
			$WordPressLiveSupportSignature['WordPressLiveSupport'.$role] = $GetWordPressLiveSupportSignature['WordPressLiveSupport'.$role];
		} 
		update_option('WordPressLiveSupportSignature', $WordPressLiveSupportSignature); 
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Page
	@
	/**************************************************************/
	public function WordPressLiveSupportPage(){ 
		if(isset($_POST['WordPressLiveSupportPro'])){
			$this->WordPressLiveSupportPro($_POST['WordPressLiveSupportPro']);
		}  
		$GetWordPressLiveSupportSignature = get_option('WordPressLiveSupportSignature');  
		// echo '<pre>';
			// print_r($GetWordPressLiveSupportSignature);
		// echo '</pre>';
		?>
		<div class="wrap columns-2">
				<div id="WordPressLiveSupportMenu" class="icon32"></div>  
				<h2><?php echo $this->plugin_name .' '.$this->plugin_version; ?></h2>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-1" class="postbox-container">
							<div class="postbox">
								<h3><span><?php _e('Purchase', 'wordpress-live-support') ?></span></h3>
								<div class="inside"> 
									<form method="POST" action=""> 
										<input class="wordpresslivesupportpro" type="text" name="WordPressLiveSupportPro" value="<?php echo $GetWordPressLiveSupportSignature['WordPressLiveSupportKey'];?>"/>
										<input class="button button-primary" type="submit" value="<?php _e('Submit', 'wordpress-live-support'); ?>" />
									</form> 
								</div>  
							</div>
							<div class="postbox">
								<h3><span><?php _e('Support remain time', 'wordpress-live-support') ?></span></h3>
								<div class="inside"> 
									<p class="WordPressLiveSupportRemainTime">
										<?php
											$WordPressLiveSupportRemainTime= $this->WordPressLiveSupportRemoteInformation('WordPressLiveSupportRemainTime');
											echo $WordPressLiveSupportRemainTime;
										?>
									</p> 
								</div>  
							</div> 
							<div class="postbox">
								<h3><span><?php _e('User Guide', 'wordpress-live-support'); ?></span></h3>
								<div class="inside"> 
									<ol>
										<li><?php _e('Install', 'wordpress-live-support'); ?></li>
										<li><?php _e('Purchase', 'wordpress-live-support'); ?></li>
										<li><?php _e('Ask for Support', 'wordpress-live-support'); ?> !</li>
									</ol>
								</div>
							</div>
						</div>
						<div id="postbox-container-2" class="postbox-container"> 
							<div id="WordPressLiveSupportTabs">
								<div name="WordPressLiveSupportOffers" class="WordPressLiveSupportTab WordPressLiveSupportActiveTab"><?php echo $this->plugin_name;?></div>
								<div id="WordPressLiveSupportOffers" class="WordPressLiveSupportContent WordPressLiveSupportActiveContent">
									<?php
										$WordPressLiveSupportOffer = $this->WordPressLiveSupportRemoteInformation('WordPressLiveSupportOffer');
										echo $WordPressLiveSupportOffer;
									?>   
									<div class="WordPressLiveSupportClear"></div> 
									<div class="WordPressLiveSupportPub">
										<div class="inside" style="overflow: auto;">  
											<div class="advPlugin"><a target="_blank" href="https://wordpress.org/plugins/adonide-faq-plugin/"><img src="<?php echo plugins_url('images/wp-live-support.png', __FILE__);?>"/></a></div>
											<div class="advPlugin"><a target="_blank" href="https://wordpress.org/plugins/plug-and-play/"><img src="<?php echo plugins_url('images/plug-and-play.png', __FILE__);?>"/></a></div>
											<div class="advPlugin"><a target="_blank" href="https://wordpress.org/plugins/facebook-ogg-meta-tags/"><img src="<?php echo plugins_url('images/facebook-ogg-meta-tags.png', __FILE__);?>"/></a></div>
										</div>
									</div>
								</div> 
							</div> 
						</div> 
					</div>
				</div>
			</div> 
		<?php
	}
	
	/***************************************************************
	@
	@	WordPress Live Support Signature
	@
	/**************************************************************/
	public function WordPressLiveSupportSignature(){
		$WordPressLiveSupportSignature = array(
			'WordPressLiveSupportName'			=> $this->plugin_name,
			'WordPressLiveSupportVersion'		=> $this->plugin_version,
			'WordPressLiveSupportUser'			=> get_option('admin_email'),
			'WordPressLiveSupportAdministrator'	=> 1,
			'WordPressLiveSupportEditor'		=> 1,
			'WordPressLiveSupportAuthor'		=> 1,
			'WordPressLiveSupportContributor'	=> 1,
			'WordPressLiveSupportSubscriber'	=> 1,
			'WordPressLiveSupportKey'			=> 'FREE' 
		);  
		$GetWordPressLiveSupportSignature = get_option('WordPressLiveSupportSignature');   
		if(!empty($GetWordPressLiveSupportSignature)){
			$GetWordPressLiveSupportSignatureDiff = array_diff($WordPressLiveSupportSignature, $GetWordPressLiveSupportSignature); 
		}  
		if(count($GetWordPressLiveSupportSignature)==1){  
			add_option('WordPressLiveSupportSignature', $WordPressLiveSupportSignature, '', 'yes'); 
		} 
		if(count($GetWordPressLiveSupportSignatureDiff)>1){  
			update_option('WordPressLiveSupportSignature', $WordPressLiveSupportSignature); 
		}
	}	 
}	 
?>