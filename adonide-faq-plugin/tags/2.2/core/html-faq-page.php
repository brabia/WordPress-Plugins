<?php
/***************************************************************
@
@	HTML FAQ PAGE WP class
@	bassem.rabia@hotmail.co.uk
@
/**************************************************************/
class faqPage{   
	/***************************************************************
	@
	@	Construct
	@
	/**************************************************************/
	public function __construct($name, $ver) {
		$this->plugin_name 					= $name;
		$this->plugin_version				= $ver;      
		add_action('admin_init',array(&$this,'coreFiles'));     
		$this->beforeInit();  
	} 	 
	
	/***************************************************************
	@
	@	before Init
	@
	/**************************************************************/
	public function beforeInit(){   
		$faqPage_plugin_signature = array(
			'faqPage_plugin_name' => $this->plugin_name,
			'faqPage_plugin_version' => $this->plugin_version,
			'faqPage_plugin_clientID' => get_option('admin_email'),
			'faqPage_plugin_signature' => md5('demo') 
		); 
		$get_faqPage_plugin_signature = get_option('faqPage_plugin_signature');   
		if(isset($get_faqPage_plugin_signature)){ 
			/***************************************************************
			@
			@	HTML FAQ PAGE WP was never been installed
			@
			/**************************************************************/  
			add_option('faqPage_plugin_signature', $faqPage_plugin_signature, '', 'yes'); 
		} 	 
	}
	  
	/***************************************************************
	@
	@	core Files
	@
	/**************************************************************/
	public function coreFiles(){   
		wp_register_style( 'faqPage-style', plugins_url('css/faqPage.css', __FILE__) );
		wp_enqueue_style( 'faqPage-style' ); 	
	} 
	
	/***************************************************************
	@
	@	getRemote Information
	@
	/**************************************************************/
	public function getRemoteInformation(){  
		$args = array(
			'method'      =>    'GET',
			'timeout'     =>    5,
			'redirection' =>    5,
			'httpversion' =>    '1.0',
			'blocking'    =>    true,
			'headers'     =>    array(),
			'body'        =>    null,
			'cookies'     =>    array()
		);
		$response = wp_remote_get( 'http://wordpress.org/plugins/adonide-faq-plugin/', $args );
		if( is_wp_error( $response ) ) {
		   $error_message = $response->get_error_message();
		   echo "Something went wrong: $error_message";
		} else { 
			return($response['body']) ;
		} 	
	} 
}	 
?>