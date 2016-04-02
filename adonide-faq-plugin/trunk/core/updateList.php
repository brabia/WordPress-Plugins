<?php 
require_once('../../../../wp-config.php');  
require_once('../../../../wp-includes/wp-db.php');
require_once('../../../../wp-includes/pluggable.php'); 

if ($_POST['update'] == "update"){  
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts'; 
	$order	= $_POST['arrayorder'];   
	$counter = 1; 
	foreach ( $order as $item_id ) { 
		$sql = 'update '.$table_name.' set menu_order = '.$counter.' where ID = '.$item_id.'; ';	 
		$counter++;   
		$wpdb->get_results($sql);
	}  
} 
?>
<div class="warning">
	<span><?php   
	_e( 'L&apos;ordre des questions est mis &agrave; jour avec succ&egrave;s !', 'html-faq-page');	
	?></span>	 
</div>