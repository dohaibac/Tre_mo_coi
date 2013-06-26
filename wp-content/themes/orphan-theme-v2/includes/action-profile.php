<?php 
add_action('wp_ajax_edit_email', 'edit_email');
function edit_email()
{
	global $current_user;

	/*** AUTHOR INFO ***/
  	$email = $_POST['txt_email'];
	wp_update_user(array("ID" => $current_user->ID, "user_email" => $email));    
 	/*~~ AUTHOR INFO ~~*/		
	
	echo json_encode(array('Success' => true));
	exit();
}