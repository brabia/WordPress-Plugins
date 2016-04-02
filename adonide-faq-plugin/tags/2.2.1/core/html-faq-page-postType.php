<?php 
/***************************************************************
@
@	HTML FAQ PAGE WP class
@	bassem.rabia@hotmail.co.uk
@
/**************************************************************/  
class faqPage_postType{  
	/***************************************************************
	@
	@	Construct
	@
	/**************************************************************/
	public function __construct($name, $ver) {
		$this->plugin_name 					= $name;
		$this->plugin_version				= $ver;    
		
		$this->post_type_name = 'adonide_faq';  
		$this->faqPage_plugin_get_signature();  
		add_action('init',array(&$this,'faqPage_init_language')); 
		add_action('init',array(&$this,'add_faqPage_button')); 
		add_action('init',array(&$this,'faqPage_postBuild'));    
		add_action('wp_enqueue_scripts',array(&$this,'faqPage_css'));
		add_action('wp_enqueue_scripts',array(&$this,'faqPage_js')); 
		add_action('admin_enqueue_scripts',array(&$this,'faqPage_admin')); 
		add_action('init',array(&$this,'faqPage_buildTaxonomy')); 
		add_shortcode('faq', array($this, 'faqPage_short_code')); 
	} 
	
	/** 
		@ ------------------------------------------------------
		@	Front CSS
		@ ------------------------------------------------------ 
	**/  
	function add_faqPage_button() {
		if(!current_user_can('edit_posts') && ! current_user_can('edit_pages')){
			return;
		} 
		if(get_user_option('rich_editing') == 'true'){
			add_filter('mce_external_plugins', 'add_faqPage_tinymce_plugin');
			add_filter('mce_buttons', 'register_faqPage_button');
		} 
		function register_faqPage_button($buttons) {
		   array_push($buttons, "|", "faqPage_button");
		   return $buttons;
		}

		function add_faqPage_tinymce_plugin($plugin_array) {
		   $plugin_array['faqPage_button'] = plugins_url('js/faqPage.js', __FILE__);
		   return $plugin_array;
		}
		function faqPage_refresh_mce($ver) {
			$ver += 3;
			return $ver;
		} 
		add_filter( 'tiny_mce_version', 'faqPage_refresh_mce'); 
	}

	
	/** 
		@ ------------------------------------------------------
		@	Front CSS
		@ ------------------------------------------------------ 
	**/  
	public function faqPage_css(){  
		wp_enqueue_style( 'faqPage-style', plugins_url('css/faqPage_front.css', __FILE__) );   
	} 
	
	/** 
		@ ------------------------------------------------------
		@	Front JS
		@ ------------------------------------------------------ 
	**/  	
	public function faqPage_js(){ 
		wp_enqueue_script( 'faqPage-jq', plugins_url('js/jquery.js', __FILE__) );
		wp_enqueue_script( 'faqPage-js', plugins_url('js/faqPage_front.js', __FILE__) );  
	} 
	
	/** 
		@ ------------------------------------------------------
		@	Front Admin JS
		@ ------------------------------------------------------ 
	**/  	
	public function faqPage_admin(){ 
		wp_enqueue_script( 'faqPage-admin', plugins_url('js/faqPage_front_admin.js', __FILE__) ); 
	} 
		
	/**
		@ ------------------------------------------------------
		@	Short Code
		@ ------------------------------------------------------  
	**/
	public function faqPage_short_code($atts){
		$cat = $atts['catid'];
		// echo 'catId = '.$catId;
		?>
		<!--    
			@ ------------------------------------------------------
			@	HTML FAQ PAGE 2.0
			@	Author: Bassem Rabia 2013
			@ ------------------------------------------------------  
		 -->
		<div id="html_faq_page"> 
			<?php 
				global $query_string; 
				$terms = get_terms('taxonomies');  
				$args = array(
					'post_type' => 'adonide_faq',   
					'orderby' => 'menu_order', 
					'order' => 'ASC'
					); 
					
				if(isset($cat) AND $cat!='cat'){
				$args['tax_query'] = array(
						array(
							'taxonomy' => 'taxonomies',
							'field' => 'term_id',
							'terms' => $cat
						)
					);
				}   
				$my_query = new WP_Query($args); 
				if($my_query->have_posts()){  
					$i=1;
					$adonide_faq = '';
					while($my_query->have_posts()){ 
						$my_query->the_post();  
						$custom = get_post_custom(get_the_ID());  
						$adonide_faq .= '<li>
							<a class="faq_page open" href="javascript:void(0)">'.get_the_title().'</a><div class="faqPage_content" id="html_faq_page_'.$i.'"><div class="answer">'.get_the_content().'</div></div></li>';
					$i++;
					}
				}
				wp_reset_postdata();
				return $adonide_faq;
			?> 
		</div><?php
	}
	
	/***************************************************************
	@
	@	Init Language
	@
	/**************************************************************/
	public static function faqPage_init_language(){   
		load_plugin_textdomain( 'html-faq-page', false, basename(dirname(__FILE__) ).'/core/lang');  
	} 
	
	/***************************************************************
	@
	@	get Options
	@
	/**************************************************************/
	public function faqPage_plugin_get_signature(){  
		$faqPage_Options = get_option('faqPage_plugin_signature');
		return($faqPage_Options);
	} 
	
	/***************************************************************
	@
	@	HTML FAQ PAGE custom post type building
	@
	/**************************************************************/ 
	public function faqPage_postBuild(){  
		register_post_type( $this->post_type_name,
			array(
				'labels' => array(
					'name'                  => __( 'Questions', 'html-faq-page' ),  
					'singular_name'         => __( 'Question', 'html-faq-page' ),  
					'add_new'               => __( 'Nouvelle Question', 'html-faq-page' ),  
					'add_new_item'          => __( 'Ajouter une nouvelle Question', 'html-faq-page' ),  
					'edit_item'             => __( 'Modification', 'html-faq-page' ),  
					'new_item'              => __( 'Nouvelle Question ', 'html-faq-page' ),  
					'all_items'             => __( 'Toutes les Questions', 'html-faq-page' ),  
					'view_item'             => __( 'Afficher les Questions', 'html-faq-page' ),  
					'search_items'          => __( 'Recherche', 'html-faq-page' ),  
					'not_found'             => __( 'Aucune Question n&apos;a &eacute;t&eacute; trouv&eacute;e', 'html-faq-page'),  
					'not_found_in_trash'    => __( 'Aucune Question n&apos;a &eacute;t&eacute; trouv&eacute;e dans le corbeille', 'html-faq-page'),   
					'parent_item_colon'     => '',  
					'menu_name'             => __( 'Questions', 'html-faq-page') 
				), 
				'public' => true,
				'menu_position' => 15,
				'rewrite' => array('slug' => '/adonide/faq'),
				'supports' => array( 'title', 'editor', 'author', 'comments', 'thumbnail', 'excerpt', 'custom-fields' ),
				'taxonomies' => array( '' ),
				'menu_icon' => plugins_url( 'images/icon.png', __FILE__ ),
				'has_archive' => true
			)
		);
		add_action('admin_menu',array(&$this,'faqPage_addSubmenu')); 
	}   
	
	/***************************************************************
	@
	@	HTML FAQ PAGE sub menu
	@
	/**************************************************************/ 
	public function faqPage_addSubmenu(){  
		add_submenu_page('edit.php?post_type=adonide_faq', __('Aide', 'html-faq-page') , __('Aide', 'html-faq-page') , 'manage_options', __FILE__, array(&$this,'help_configPage'));
	}   
	
	/***************************************************************
	@
	@	Taxonomy
	@
	/**************************************************************/ 
	public function faqPage_buildTaxonomy(){  
		register_taxonomy( 
			__('taxonomies', 'html-faq-page'), 
			strtolower($this->post_type_name), 
			array( 'hierarchical' => true, 
			'label' => __('Taxonomies', 'html-faq-page'), 
			'query_var' => true,
			'rewrite'             => array( 'slug' => ''.strtolower($this->post_type_name).'-taxonomies' )
			) 
		);   	
	}
	
	/***************************************************************
	@
	@	HTML FAQ PAGE sub menu
	@
	/**************************************************************/ 
	public function help_configPage(){    
		?>  
			<div class="wrap columns-2">
				<div id="faqPage" class="icon32"></div>  
				<h2><?php echo $this->plugin_name .' '.$this->plugin_version; ?></h2>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-1" class="postbox-container">
							<div class="postbox">
								<h3><span><?php _e('Guide d&apos;utilisation', 'html-faq-page'); ?></span></h3>
								<div class="inside"> 
									<ol>
										<li><?php _e('S&eacute;lectionner Questions dans le menu &agrave; gauche.', 'html-faq-page'); ?>
										</li>
										<li><?php _e('Ajouter des Questions et des Réponses', 'html-faq-page'); ?>
										</li>
										<li>
											<?php _e('Utiliser le nouveau bouton depuis votre WYSIWYG', 'html-faq-page'); ?> 
										</li><li>
											<?php _e('Pour une catégorie spécifique ', 'html-faq-page'); ?><code>[faq catId=2]</code>
										</li>
										<li><?php _e("C'est fini", 'html-faq-page'); ?> !</li>
									</ol>
								</div>
							</div>
							<div class="postbox">
								<h3><span><?php _e('Aimez-vous ce plugins?', 'html-faq-page'); ?></span></h3>
								<div class="inside">
									<p>
										<?php _e('S&apos;il vous plaît prenez quelques secondes pour soutenir', 'html-faq-page'); ?>
										<ol>
												<li><a target="blank" href="http://wordpress.org/extend/plugins/adonide-faq-plugin/"><?php _e('&Eacute;valuer nous sur WordPress.org', 'html-faq-page'); ?></a></li>
												<li>
												<a target='_blank' href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MEUX57DRQRHY4'>
												<?php _e('Faire un don', "html-faq-page"); ?></a>
												</li>
										</ol>
										<center><img src="<?php echo plugins_url('images/paypal.gif', __FILE__);?>" alt="paypal" /></center><br/>
										<?php _e('Merci pour votre soutien', "html-faq-page"); ?>
									</p>
								</div>
							</div>
							<div class="postbox">
								<h3><span><?php _e('Support', 'html-faq-page') ?></span></h3>
								<div class="inside">
									<p> 
										<span class="faqPage_pro"></span>
										<a class="show-popup" target="_blank" href="https://wordpress.org/plugins/wp-live-support/"><?php _e('Demander du Support', 'html-faq-page'); ?></a>   
									</p>
								</div>
							</div>
						</div>
						<div id="postbox-container-2" class="postbox-container adonide_faq">
							<div class="stuffbox">
								<h3><label><?php _e('Listes des Questions', 'html-faq-page' ); ?></label></h3>
								<div class="inside" style="overflow: auto;">  
								<?php 
									$terms = get_terms('taxonomies');
									$count = count($terms);
									if($count>0){ 
										?>
										<div id="faqPage_response"></div>										
										<?php
										foreach($terms as $term){ 
											?>
											<div id="faqPagelist">
												<fieldset class="faqPage_question">
													<legend><?php echo $term->name;?> </legend>
													<?php
														$args = array(
																'post_type' => $this->post_type_name,  
																'orderby' => 'menu_order', 
																'order' => 'ASC',  
																'tax_query' => array(
																	array(
																		'taxonomy' => 'taxonomies',
																		'field' => 'term_id',
																		'terms' => $term->term_id
																	)
																)  
															);  
														// print_r($args); 
														$my_query = new WP_Query( $args );
														if ( $my_query->have_posts() ) {  
															?><ul id="liste"><?php
															while ( $my_query->have_posts() ) { 
																$my_query->the_post();  
																?> 
																<li id="arrayorder_<?php echo get_the_ID();?>" class="faqPage_item"><?php echo get_the_title();?></li>
																<?php
															}
															?></ul><?php
														}
														wp_reset_postdata(); 
													?>
												</fieldset>
											</div>
											<?php 
										} 
									} 
								?>  
								</div>   

								<script src="http://code.jquery.com/jquery-1.8.2.js"></script> 
								<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
								<script type="text/javascript">  
								jQuery(document).ready(function(){ 
									jQuery(function() {
										jQuery("#faqPagelist ul").sortable({ opacity: 0.8, cursor: 'move', update: function() { 
											var order = jQuery(this).sortable("serialize") + '&update=update';  
											$("#faqPage_response").fadeIn();
											jQuery.post( '<?php echo plugins_url('updateList.php', __FILE__);?>' , order, function(theResponse){ 
												jQuery("#faqPage_response").html(theResponse);
											});   
										}								  
										});
									});

								});	
								</script>  
							</div>
							<div class="stuffbox">
								<h3><label><?php _e('Nous vous recommandons', 'html-faq-page' ); ?></label></h3>
								<div class="inside" style="overflow: auto;">  
									<div class="adonidePlugin"><a target="_blank" href="https://wordpress.org/plugins/wp-live-support/"><img src="<?php echo plugins_url('images/wp-live-support.png', __FILE__);?>"/></a></div>
									<div class="adonidePlugin"><a target="_blank" href="https://wordpress.org/plugins/plug-and-play/"><img src="<?php echo plugins_url('images/plug-and-play.png', __FILE__);?>"/></a></div>
									<div class="adonidePlugin"><a target="_blank" href="https://wordpress.org/plugins/facebook-ogg-meta-tags/"><img src="<?php echo plugins_url('images/facebook-ogg-meta-tags.png', __FILE__);?>"/></a></div>
								</div>
							</div>
						</div> 
					</div>
				</div>
			</div> 
		<?php
	} 
	
} 