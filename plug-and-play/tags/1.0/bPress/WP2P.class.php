<?php
/***************************************************************
	@
	@	'WP Plug & Play
	@	bassem.rabia@hotmail.co.uk
	@
/**************************************************************/

class WP2P{
	public function __construct(){
		$this->bPressSignature = array(
			'pluginName' => 'Plug & Play',
			'pluginNiceName' => 'WP Plug & Play',
			'pluginSlug' => 'plug-and-play',
			'pluginVersion' => '1.0',
			'pluginRemoteURL' => 'http://store.norfolky.com/',
		); 		
		// echo '<pre>';print_r($this->bPressSignature);echo '</pre>'; 
		
		
		add_action('admin_enqueue_scripts',array(&$this, 'bPress_admin_enqueue'));
		add_action('admin_menu', array(&$this, 'bPress_menu'));
									
		/* Basic feature start here */
		add_action('wp_head', array(&$this, 'bPress_run_api'));
		add_action('login_enqueue_scripts', array(&$this, 'bPress_run_login'));
		if(is_admin()==''){
			add_action('init', array(&$this, 'bPress_run_admin_bar'));
			add_action('init', array(&$this, 'bPress_run_remove_version'));
			add_action('wp_footer', array(&$this, 'bPress_run'));
		}
	}
	
	public function bPress_run_login(){
		$selectedCategory = $this->bPress_selectedCategory(get_option('bPressServices'), 'customizer');
		// echo '<pre>';print_r($selectedCategory['category']['products']);echo '</pre>';
		$selectedProduct = $this->bPress_selectedProductIndex($selectedCategory['category']['products'], 'Login Logo');	
		// echo '<pre>';print_r($selectedProduct);echo '</pre>';		
		$isEnabled = (isset($selectedProduct['enabled']) AND $selectedProduct['enabled']==1)?1:0;		
		$data = (isset($selectedProduct['data']))?$selectedProduct['data']:'';
		// echo 'data = '.$data;	
		if($isEnabled==1){
			global $Logo_Signup_Page;
			$Logo_Signup_Page = $data;
			// echo 'bPress_run_login';	
			function bPress_run_my_login_logo(){
				global $Logo_Signup_Page;
				echo '<style type="text/css">h1 a {background-image: url('.$Logo_Signup_Page.') !important; </style>';
			}
			add_action('login_head', 'bPress_run_my_login_logo');			
			function bPress_run_my_login_logo_url(){return home_url();}
			add_filter('login_headerurl', 'bPress_run_my_login_logo_url');
		}
	}
	/* admin_bar */
	public function bPress_run_admin_bar(){
		$selectedCategory = $this->bPress_selectedCategory(get_option('bPressServices'), 'customizer');
		// echo '<pre>';print_r($selectedCategory['category']['products']);echo '</pre>';
		$selectedProduct = $this->bPress_selectedProductIndex($selectedCategory['category']['products'], 'Hide Admin Bar');	
		// echo '<pre>';print_r($selectedProduct);echo '</pre>';		
		$isEnabled = (isset($selectedProduct['enabled']) AND $selectedProduct['enabled']==1)?1:0;
		if($isEnabled==1){
			// echo 'wpToolkit_run_admin_bar';	
			add_filter('show_admin_bar', '__return_false');
		}
	}
	
	/* remove_version */
	public function bPress_run_remove_version(){
		$selectedCategory = $this->bPress_selectedCategory(get_option('bPressServices'), 'security_tools');
		// echo '<pre>';print_r($selectedCategory);echo '</pre>';
		$selectedProduct = $selectedCategory['category']['products'][0];		
		// echo '<pre>';print_r($selectedProduct);echo '</pre>';
		$isEnabled = (isset($selectedProduct['enabled']) AND $selectedProduct['enabled']==1)?1:0;		
		if($isEnabled==1){
			// echo 'wpToolkit_run_remove_version';	
			add_filter('the_generator', '__return_false');
		}		
	}
	
	/* bPress_run_api */
	public function bPress_run_api(){
		wp_enqueue_style('bPress-style', plugins_url('css/bPress-wp.css', __FILE__));
		wp_enqueue_script('bPress-script', plugins_url('js/bPress-wp.js', __FILE__));
		wp_enqueue_script('bPress-remote-api', $this->bPressSignature['pluginRemoteURL'].'bPress.js');	
		wp_enqueue_style('bPress-remote-style', $this->bPressSignature['pluginRemoteURL'].'bPress.css');	
	}	
	public function bPress_run(){		
		$selectedCategory = $this->bPress_selectedCategory(get_option('bPressServices'), 'versus');
		// echo '<pre>';print_r($selectedCategory);echo '</pre>';
		$selectedProduct = $selectedCategory['category']['products'][0];		
		// echo '<pre>';print_r($selectedProduct);echo '</pre>';
		$isEnabled = (isset($selectedProduct['enabled']) AND $selectedProduct['enabled']==1)?1:0;		
		$data = (isset($selectedProduct['data']))?$selectedProduct['data']:'bPress Versus';	
		$config = (isset($selectedProduct['config']))?$selectedProduct['config']:'3';	
		if($isEnabled==1){
			$isPost = is_singular('post');		
			// echo 'isPost = '.$isPost;		
			if($isPost){
				$pId = get_the_ID();	
				$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($pId), '');
				
				$bPress_post = array();	
				$versusPost = new stdClass;
				$versusPost->title = get_the_title($pId);
				$versusPost->excerpt = mb_substr(get_the_excerpt(), 0, 80);
				$versusPost->img = $thumb['0'];

				array_push($bPress_post, $versusPost);
				// echo '<pre>';print_r($bPress_post);echo '</pre>';
				$bPress_post = json_encode($bPress_post);
				?><script>
				var bPress_p = JSON.parse('<?php echo $bPress_post;?>');				
				var pVersus = 
				{
					title: bPress_p[0].title,
					excerpt: bPress_p[0].excerpt,
					img: bPress_p[0].img,
					url: location.href
				};

				var i = setInterval(function(){
					if(typeof bApi == 'object'){
						clearInterval(i);
						bApi.versusSet();
						
						bQuery('#bPress_versus .versusPost:last').attr('style', 'margin-right:0');
						bQuery('#bPress_versus .versusContent').width((bQuery('#bPress_versus .versusPost').outerWidth(true)*bQuery('#bPress_versus .versusPost').size()))
					}
				}, 10)
				setTimeout(function(){clearInterval(i);}, 1000*15);				
				</script><?php 
			}
			?><script>
			var j = setInterval(function(){
				if(typeof bApi == 'object'){
					clearInterval(j);
					var bPress_Versus = JSON.parse(bApi.localStorageGet('bPress_Versus'))||[];					
					if(bPress_Versus.length>='<?php echo $config;?>'){
						bApi.versus();
						bQuery('#bPress_versus .versusLuncher .txt').text('<?php echo $data;?>');	
					}
				}
			}, 10)
			setTimeout(function(){clearInterval(j);}, 1000*15);				
			</script><?php
		}		
	}
	
	
	public function bPress_admin_enqueue(){
		wp_enqueue_style('bPress-admin-style', plugins_url('css/bPress-admin.css', __FILE__));  
		wp_enqueue_script('bPress-admin-script', plugins_url('js/bPress-admin.js', __FILE__));
	}
		
	/***************************************************************
	@	Get Remote Information
	/**************************************************************/
	public function bPress_RemoteInformation($Data){
		$url = $this->bPressSignature['pluginRemoteURL'].'/bPress.php?'; 
		$params = array( 
            'action'	=> $Data, 
            'user'		=> urlencode(get_option('admin_email'))
        );
		$response = wp_remote_get(add_query_arg($params, $url));
		// echo '<pre>';print_r($response);echo '</pre>';
		if(is_wp_error($response)){
		   $error_message = $response->get_error_message();
		   echo "Something went wrong: $error_message";
		}else{ 
			return($response['body']) ;
		}
	}
	
	public function bPress_menu(){		
		add_menu_page('', 
			$this->bPressSignature['pluginNiceName'].' <!--span class="awaiting-mod"><span class="pending-count">1</span--></span>', 
			'manage_options', 
			strtolower($this->bPressSignature['pluginSlug']).'-main-menu', 
			array(&$this,'bPress_page'), 
			plugins_url(strtolower($this->bPressSignature['pluginSlug']).'/bPress/images/16.png'),
			150
		);
				
		$bPressServices = get_option('bPressServices');		
		// echo count($bPressServices);
		// echo '<pre>';print_r($bPressServices);echo '</pre>';
		if(count(get_option('bPressServices'))==1){
			$bPressServices = json_decode($this->bPress_RemoteInformation('customizer'), true);
			// echo '<pre>';print_r($bPressServices[0]['category']['title']);echo '</pre>';			
			add_option('bPressServices', $bPressServices, '', 'yes');
			$bPressServices = get_option('bPressServices');			
		}
		
		for($i=0;$i<count($bPressServices);$i++){
			$mName = ucwords(str_replace('_', ' ', $bPressServices[$i]['category']['title']));
			add_submenu_page($this->bPressSignature['pluginSlug'].'-main-menu', __($mName, 'bPress'), __($mName, 'bPress'), 'manage_options', $this->bPressSignature['pluginSlug'].'-'.strtolower(str_replace(' ', '-', $mName)).'-menu', array(&$this,'bPress_page'));
		}
		remove_submenu_page($this->bPressSignature['pluginSlug'].'-main-menu', $this->bPressSignature['pluginSlug'].'-main-menu');
	}
	
	public function bPress_selectedProductIndex($array, $selectedService){
		// echo 'selectedService = '.$selectedService.'<br>';			
		for($i=0;$i<count($array);$i++){
			if($selectedService == $array[$i]['name'])
				$serviceIndex = $i;
		}
		return $array[$serviceIndex];
	}
	public function bPress_selectedCategoryIndex($array, $selectedService){
		// echo 'selectedService = '.$selectedService.'<br>';			
		for($i=0;$i<count($array);$i++){
			if($selectedService == $array[$i]['category']['title'])
				$serviceIndex = $i;
		}
		return $serviceIndex;
	}
	public function bPress_selectedCategory($array, $selectedService){
		// echo 'selectedService = '.$selectedService.'<br>';			
		for($i=0;$i<count($array);$i++){
			if($selectedService == $array[$i]['category']['title'])
				$serviceIndex = $i;
		}
		return $array[$serviceIndex];
	}
	
	public function bPress_save_services(){
		$bPressServices = get_option('bPressServices');
		// echo '<pre>';print_r($bPressServices);echo '</pre>';
		$bPress_SelectedProductIndex = $_POST['bPress_SelectedProductIndex'];		
		$bPess_SelectedCategory = $_POST['bPess_SelectedCategory'];
		$bPress_SelectedProduct = $_POST[$_POST['bPress_SelectedProduct']];
		
		$bCategoryIndex = $this->bPress_selectedCategoryIndex(get_option('bPressServices'), $bPess_SelectedCategory);
		// echo '<br>bCategoryIndex = '.$bCategoryIndex;
		$bCategory = $this->bPress_selectedCategory(get_option('bPressServices'), $bPess_SelectedCategory);
		// echo '<br>bCategoryIndex = '.$bCategoryIndex;

		$selectedCategory = $this->bPress_selectedCategory(get_option('bPressServices'), $bPess_SelectedCategory);
		// echo '<pre>';print_r($selectedCategory);echo '</pre>';
		$selectedProduct = $selectedCategory['category']['products'][$bPress_SelectedProductIndex];		
		// echo '<pre>';print_r($selectedProduct);echo '</pre>';	

		$data_key = strtolower(str_replace(' ', '_', $selectedProduct['name'])).'_data';
		$config_key = strtolower(str_replace(' ', '_', $selectedProduct['name'])).'_config';
		$bPress_SelectedProductData = $_POST[$data_key];
		$bPress_SelectedProductConfig = (isset($_POST[$config_key]))?$_POST[$config_key]:'';
		// echo '<br>config_key = '.$config_key.' ==> '.$bPress_SelectedProductConfig.'<br>'; 
		// echo '<pre>';print_r($bCategory);echo '</pre>---------------------<br>';

		// echo 'bPess_SelectedCategory = '.$bPess_SelectedCategory.' <br> bPress_SelectedProduct = '.$bPress_SelectedProduct.'<br>bPress_SelectedProductIndex = '.$bPress_SelectedProductIndex.'<br>bPress_SelectedProductData = '.$bPress_SelectedProductData;
		
		// $bCategoryIndex = $this->bPress_selectedCategoryIndex(get_option('bPressServices'), $bPess_SelectedCategory);
		// echo '<br>bCategoryIndex = '.$bCategoryIndex;
		// $bCategory = $this->bPress_selectedCategory(get_option('bPressServices'), $bPess_SelectedCategory);
		
		// echo '<pre>';print_r($bCategory);echo '</pre>---------------------<br>';
		
		$bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['name'] = $bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['name'];
		$bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['icon'] = $bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['icon'];
		$bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['desc'] = $bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['desc'];
		$bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['enabled'] = $bPress_SelectedProduct;
		$bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['data'] = $bPress_SelectedProductData;
		$bPressServices[$bCategoryIndex]['category']['products'][$bPress_SelectedProductIndex]['config'] = $bPress_SelectedProductConfig;
		// echo '<pre>';print_r($bPressServices);echo '</pre>';
		
		update_option('bPressServices', $bPressServices);
		?>
		<div class="accordion-header accordion-notification accordion-notification-success">
			<i class="fa dashicons dashicons-no-alt"></i>
			<span class="dashicons dashicons-megaphone"></span>
			<?php echo $this->bPressSignature['pluginName'];?>
			<?php echo __('has been successfully updated', 'wordpress-toolkit');?>.
		</div> 
		<?php 
	}
	
	public function bPress_page(){
		?>
		<div class="wrap columns-2">
			<div id="bPress" class="icon32"></div>  
			<h2><?php echo $this->bPressSignature['pluginNiceName'] .' '.$this->bPressSignature['pluginVersion']; //echo get_locale();?></h2>			
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="postbox-container-1" class="postbox-container">
						<div class="postbox">
							<h3><span><?php _e('User Guide', 'wordpress-live-support'); ?></span></h3>
							<div class="inside"> 
								<ol>
									<li><?php _e('Install', 'bPress'); ?></li>
									<li><?php _e('Run', 'bPress'); ?></li>
									<li><?php _e('Enjoy', 'bPress'); ?></li>
									<li><?php _e('Ask for Support if you need', 'bPress'); ?> !</li>
								</ol>
							</div>
						</div>
					</div>				
					<div id="postbox-container-2" class="postbox-container">
						<div id="bPress_container">
							<div class="bPress_content">
								<?php		
									if(isset($_POST['bPess_SelectedCategory']) AND isset($_POST['bPress_SelectedProduct']) AND isset($_POST['bPress_SelectedProductIndex'])){
										 $this->bPress_save_services();
										// echo '<pre>';print_r($_POST);echo '</pre>';		
									}
									
									if(isset($_GET['page']) AND $_GET['page']!=''){
										$page = $_GET['page'];
										// echo $page.'<br>';												
										switch($page){
											case $this->bPressSignature['pluginSlug'].'-versus-menu':
												$bPress_cat = 'versus';
												$selectedService = $this->bPress_selectedCategory(get_option('bPressServices'), $bPress_cat);
												// echo '<pre>';print_r($selectedService);echo '</pre>';
												for($i=0;$i<count($selectedService['category']['products']);$i++){
													$pName = ucwords($selectedService['category']['products'][$i]['name']);
													?>
													<div name="bPress<?php echo str_replace(' ', '_', $pName);?>" class="accordion-header">
														<i class="fa dashicons dashicons-arrow-down"></i>
														<span class="dashicons <?php echo $selectedService['category']['products'][$i]['icon'];?>"></span>
														<?php echo __($pName, 'bPress');?>
													</div>
													
													<div id="bPress<?php echo str_replace(' ', '_', $pName);?>" class="bPress_service_content <?php echo ($i==0)?'bPress_service_content_active':'';?>">
														<form method="POST" action="" />
															<?php
															$_val = str_replace(' ', '_', $pName);
															if($_val=='Versus'){
																$isEnabled = (isset($selectedService['category']['products'][$i]['enabled']) AND $selectedService['category']['products'][$i]['enabled']==1)?1:0;
																$data = (isset($selectedService['category']['products'][$i]['data']))?$selectedService['category']['products'][$i]['data']:'';
																$config = (isset($selectedService['category']['products'][$i]['config']))?$selectedService['category']['products'][$i]['config']:'';
																?>
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==1)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="1" /> <?php echo __('Enable', 'bPress');?>
																</div>	
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==0)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="0" /> <?php echo __('Disable', 'bPress');?>
																</div>
																
																<div class="bPress_Config">
																	<span class="description"><?php echo __('Versus Title', 'bPress');?></span>
																	<input placeholder="<?php echo __('Versus Title', 'bPress');?>" class="bPress_input" type="text" name="<?php echo strtolower(str_replace(' ', '_', $pName));?>_data" value="<?php echo $data;?>" />
																</div>
																
																<div class="bPress_Config">
																	<span class="description"><?php echo __('Show after (X) posts', 'bPress');?></span>
																	<input placeholder="<?php echo __('Show after (X) posts', 'bPress');?>" class="bPress_input" type="text" name="<?php echo strtolower(str_replace(' ', '_', $pName));?>_config" value="<?php echo $config;?>" />
																</div>																
																<?php
															}
															?>
															<input type="hidden" name="bPess_SelectedCategory" value="<?php echo $bPress_cat;?>" />
															<input type="hidden" name="bPress_SelectedProduct" value="<?php echo $_val;?>" />
															<input type="hidden" name="bPress_SelectedProductIndex" value="<?php echo $i;?>" />
															<input class="bPress_submit" type="submit" value="<?php echo __('Save', 'bPress');?>" />
														</form>
														<?php
														// echo '<pre>';print_r($selectedService->category->products[$i]);echo '</pre>';
														?>
														<p class="description"><?php echo $selectedService['category']['products'][$i]['desc'];?></p>
													</div>
													<?php 
												}
											break;											
											case $this->bPressSignature['pluginSlug'].'-customizer-menu':
												$bPress_cat = 'customizer';
												$selectedService = $this->bPress_selectedCategory(get_option('bPressServices'), $bPress_cat);
												// echo '<pre>';print_r($selectedService);echo '</pre>';
												for($i=0;$i<count($selectedService['category']['products']);$i++){
													$pName = ucwords($selectedService['category']['products'][$i]['name']);
													?>
													<div name="bPress<?php echo str_replace(' ', '_', $pName);?>" class="accordion-header">
														<i class="fa dashicons dashicons-arrow-down"></i>
														<span class="dashicons <?php echo $selectedService['category']['products'][$i]['icon'];?>"></span>
														<?php echo __($pName, 'bPress');?>
													</div>
													
													<div id="bPress<?php echo str_replace(' ', '_', $pName);?>" class="bPress_service_content <?php echo ($i==0)?'bPress_service_content_active':'';?>">
														<form method="POST" action="" />
															<?php
															$_val = str_replace(' ', '_', $pName);
															if($_val=='Login_Logo'){
																$isEnabled = (isset($selectedService['category']['products'][$i]['enabled']) AND $selectedService['category']['products'][$i]['enabled']==1)?1:0;
																$data = (isset($selectedService['category']['products'][$i]['data']))?$selectedService['category']['products'][$i]['data']:'';
																?>  
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==1)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="1" /> <?php echo __('Enable', 'bPress');?>
																</div>	
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==0)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="0" /> <?php echo __('Disable', 'bPress');?>
																</div>

																<input class="bPress_input" type="text" name="<?php echo strtolower(str_replace(' ', '_', $pName));?>_data" value="<?php echo $data;?>" />																
																<?php
															}
															if($_val=='Hide_Admin_Bar'){
																$isEnabled = (isset($selectedService['category']['products'][$i]['enabled']) AND $selectedService['category']['products'][$i]['enabled']==1)?1:0;
																?>
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==1)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="1" /> <?php echo __('Hide', 'bPress');?>
																</div>	
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==0)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="0" /> <?php echo __('Show', 'bPress');?>
																</div>														
																<?php
															}
															?>
															<input type="hidden" name="bPess_SelectedCategory" value="<?php echo $bPress_cat;?>" />
															<input type="hidden" name="bPress_SelectedProduct" value="<?php echo $_val;?>" />
															<input type="hidden" name="bPress_SelectedProductIndex" value="<?php echo $i;?>" />
															<input class="bPress_submit" type="submit" value="<?php echo __('Save', 'bPress');?>" />
														</form>
														<?php
														// echo '<pre>';print_r($selectedService->category->products[$i]);echo '</pre>';
														?>
														<p class="description"><?php echo $selectedService['category']['products'][$i]['desc'];?></p>
													</div>
													<?php 
												}											
											break;
											case $this->bPressSignature['pluginSlug'].'-security-tools-menu':
												$bPress_cat = 'security_tools';
												$selectedService = $this->bPress_selectedCategory(get_option('bPressServices'), $bPress_cat);
												// echo '<pre>';print_r($selectedService);echo '</pre>';
												for($i=0;$i<count($selectedService['category']['products']);$i++){
													$pName = ucwords($selectedService['category']['products'][$i]['name']);
													?>
													<div name="bPress<?php echo str_replace(' ', '_', $pName);?>" class="accordion-header">
														<i class="fa dashicons dashicons-arrow-down"></i>
														<span class="dashicons <?php echo $selectedService['category']['products'][$i]['icon'];?>"></span>
														<?php echo __($pName, 'bPress');?>
													</div>
													
													<div id="bPress<?php echo str_replace(' ', '_', $pName);?>" class="bPress_service_content <?php echo ($i==0)?'bPress_service_content_active':'';?>">
														<form method="POST" action="" />
															<?php
															$_val = str_replace(' ', '_', $pName);
															if($_val=='WP_Generator_Meta_Tag_Remover'){
																$isEnabled = (isset($selectedService['category']['products'][$i]['enabled']) AND $selectedService['category']['products'][$i]['enabled']==1)?1:0;
																?>
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==1)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="1" /> <?php echo __('Hide', 'bPress');?>
																</div>	
																<div class="bPress_Opt">
																	<input <?php echo ($isEnabled==0)?'checked':'';?> class="wpToolkit_radio" type="radio" name="<?php echo str_replace(' ', '_', $pName);?>" value="0" /> <?php echo __('Show', 'bPress');?>
																</div>														
																<?php
															}
															?>
															<input type="hidden" name="bPess_SelectedCategory" value="<?php echo $bPress_cat;?>" />
															<input type="hidden" name="bPress_SelectedProduct" value="<?php echo $_val;?>" />
															<input type="hidden" name="bPress_SelectedProductIndex" value="<?php echo $i;?>" />
															<input class="bPress_submit" type="submit" value="<?php echo __('Save', 'bPress');?>" />
														</form>
														<?php
														// echo '<pre>';print_r($selectedService->category->products[$i]);echo '</pre>';
														?>
														<p class="description"><?php echo $selectedService['category']['products'][$i]['desc'];?></p>
													</div>
													<?php 
												}
											break; 
											case $this->bPressSignature['pluginSlug'].'main-menu':
												$pName = 'Announcement';
												?>
												<div name="bPress<?php echo str_replace(' ', '_', $pName);?>" class="accordion-header">
													<i class="fa dashicons dashicons-arrow-down"></i>
													<span class="dashicons dashicons-megaphone"></span>
													<?php echo __('Announcement', 'bPress');?>
												</div>
												<div id="bPress<?php echo str_replace(' ', '_', $pName);?>" class="bPress_service_content bPress_service_content_active">
													<?php echo $this->bPressSignature['pluginName'] .' Announcement';?>
												</div>
												
												<?php
												$pName = 'Report';
												?>
												<div name="bPress<?php echo str_replace(' ', '_', $pName);?>" class="accordion-header">
													<i class="fa dashicons dashicons-arrow-down"></i>
													<span class="dashicons dashicons-chart-pie"></span>
													<?php echo __('Report', 'bPress');?>
												</div>
												<div id="bPress<?php echo str_replace(' ', '_', $pName);?>" class="bPress_service_content">
													<?php echo $this->bPressSignature['pluginName'] .' Report';?>
												</div>		

												<?php
												$pName = 'Store';
												?>												
												<div name="bPress<?php echo str_replace(' ', '_', $pName);?>" class="accordion-header">
													<i class="fa dashicons dashicons-arrow-down"></i>
													<span class="dashicons dashicons-store"></span>
													<?php echo __('Store', 'bPress');?>
												</div>
												<div id="bPress<?php echo str_replace(' ', '_', $pName);?>" class="bPress_service_content">
													<?php echo $this->bPressSignature['pluginName'] .' Store';?>
												</div>
												<?php													
											break;
										}
									}										
								?>
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