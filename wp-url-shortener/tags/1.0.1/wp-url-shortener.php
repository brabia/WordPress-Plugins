<?php
/* 
Plugin Name: WP URL Shortener
Plugin URI: http://www.tunicontact.com/nous-contactez/
Description: Earn money by making your Wordpress articles shorter
Version: 1.0.1
Author: Adonide WP Team
Author URI: http://www.tunicontact.com/nous-contactez/
/* ----------------------------------------------*/     
add_filter('manage_posts_columns', 'add_url_columns', 10, 2);
function add_url_columns($posts_columns, $post_type)
{
    $posts_columns['url_columns'] = 'Short Url'; 
    return $posts_columns;
}
function url_bitly($input_url){  
	$login = get_option('wp_url_shortener_user_name');
	$api_key = get_option('wp_url_shortener_api_key');  
	if(empty($login) OR empty($api_key) ){
		echo 'Invalid <a href="admin.php?page=wp-url-shortener/wp-url-shortener.php">Login data !</a>';
	}else{
		$local = array('localhost', '127.0.0.1');
		if (!in_array($input_url, $local)) {
			if(!filter_var($input_url, FILTER_VALIDATE_URL)){
					echo 'Invalid URL.'; 
				}
				else{
					$url_enc = urlencode($input_url);
					$version = '2.0.1';
					$login = get_option('wp_url_shortener_user_name');
					$api_key = get_option('wp_url_shortener_api_key');  
					$format = 'json';
					$data = file_get_contents('http://api.bit.ly/shorten?version='.$version.'&login='.$login.'&apiKey='.$api_key.'&longUrl='.$url_enc.'&format='.$format);
					$json = json_decode($data, true);  
					// print_r( $json ) ; 
					foreach($json['results'] as $val){
						echo $val['shortUrl'];
					}
				}
		}else{
			echo "Invalid URL, you are on local!";
		}
	} 
}
function my_custom_columns( $column ) {
  global $post;
  switch ( $column ) {
    case 'url_columns':  
		?> 
		<span><?php url_bitly( get_permalink() );?></span>
		<?php  
		break; 
  }
}
add_action( 'manage_posts_custom_column' , 'my_custom_columns' );   
add_action('admin_menu', 'wp_url_shortener_menu');  
function wp_url_shortener_menu() { 
	add_menu_page('wp-url-shortener Settings', 'Url Shortener', 'administrator', __FILE__, 'wp_url_shortener_settings_page',plugins_url('/images/1339255633_url.png', __FILE__));
} 
 
function wp_url_shortener_settings_page() { 
	$siteurl = get_option('siteurl');
    $url_css = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/style.css';
    $url_js = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery.min.js';
	echo '<link rel="stylesheet" type="text/css" href='.$url_css.' />';
	 
	if(isset($_POST['wp_url_shortener_user_name'])){
	update_option('wp_url_shortener_user_name', $_POST['wp_url_shortener_user_name']);
	}
	if(isset($_POST['wp_url_shortener_api_key'])){
	update_option('wp_url_shortener_api_key', $_POST['wp_url_shortener_api_key']);
	}
	?>  
	<div class="Tabs">
		<a href="#" class="Active">Configuration</a>
		<a target="_blank" href="http://www.tunicontact.com/nous-contactez/">Contact</a>
	</div>
	<div class="TabBody">
		<div class="left">
			<h1>bit.ly login data:</h1>
			<form action="" method="post">
				<table cellpadding="3" cellspacing="2">
					<tr>
						<td>
							User Name
						</td>
						<td>
							<input class="input" type="text" name="wp_url_shortener_user_name" value="<?php echo get_option('wp_url_shortener_user_name'); ?>" />
						</td>
					</tr>
					<tr>
						<td>
							API Key
						</td>
						<td>
							<input class="input" type="text" name="wp_url_shortener_api_key" value="<?php echo get_option('wp_url_shortener_api_key'); ?>" />
						</td>
					</tr>
					<tr>
						<td> 
						</td>
						<td>
							<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
						</td>
					</tr> 
					 
				</table>
			</form> 
		</div>
		<div class="right">
			<div class="adv">
				Adv over here  
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="bassem.rabia@hotmail.co.uk">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/fr_XC/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
					<img alt="" border="0" src="https://www.paypalobjects.com/fr_XC/i/scr/pixel.gif" width="1" height="1">
				</form>

			</div> 
		</div> 
	</div>  
<?php 
} 
?>