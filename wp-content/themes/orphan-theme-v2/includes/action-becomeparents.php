<?php 
add_action('wp_ajax_insert_becomeparents', 'insert_becomeparents');
function insert_becomeparents()
{
	global $current_user,$orphan_prefix;
	$orphan_prefix = 'orphan_';
	
	$errors = new WP_Error();

	$captcha_instance = new ReallySimpleCaptcha();		
	if(!$captcha_instance->check( $_POST['captcha_prefix'], $_POST['txt_captcha'] ))
	{
		$captcha_error = true;	
	}
	$captcha_instance->remove( $_POST['captcha_prefix'] );	
	
	// Gen new captcha		
	$captcha = create_captcha(); 
	$prefix = $captcha['prefix'];
	$file = $captcha['file'];
	
	if($captcha_error)
	{
		$errors->add( 'captcha_error', __( "Mã bảo mật không đúng, vui lòng nhập lại." ) );
		
		echo json_encode(array_merge(array('captcha_new' => $captcha), (array)$errors));
		die();
	}
	else 
	{	
	 	/*** AUTHOR INFO ***/
	    $address_home = $_POST['txt_address']; //dia chi
	    $address_district = $_POST['txt_district'];  // quan(huyen)
	    $address_province = $_POST['txt_province']; //tinh
	    $phone = $_POST['txt_phone']; // dien thoai
	    $phone_static = $_POST['txt_phone_static']; // dt co dinh
	    $job = $_POST['txt_job']; // nghe nghiep
	    $income = $_POST['txt_income'];  // thu nhap
	  	
		update_user_meta($current_user->ID, "address", $address_home);
		update_user_meta($current_user->ID, "district", $address_district);
		update_user_meta($current_user->ID, "province", $address_province);
		update_user_meta($current_user->ID, "phone", $phone);
		update_user_meta($current_user->ID, "phone_static", $phone_static);
		update_user_meta($current_user->ID, "job", $job);
		update_user_meta($current_user->ID, "income", $income);    
	 	/*~~ AUTHOR INFO ~~*/
		
		
	 	/*** POST INFO ***/
		$reason = $_POST['txt_reason'];
		$email_duration = $_POST['rbn_email_duration']; 
		$birth_year = $_POST['sel_birthyear']; // nam sinh
		$gender = $_POST['rbn_gender'];
		$note = $_POST['txt_note'];
		
		$my_post = array(
		  	'post_author'   => $current_user->ID,
		  	'post_type'     => 'nhan-con-nuoi',
		  	'post_title'    => 'Đón nhận yêu thương',
			'post_content' 	=> $reason,
			'post_status' 	=> 'private'
		);
	
		// Insert the post into the database
		$post_id = wp_insert_post( $my_post );
		
		update_post_meta($post_id, $orphan_prefix .'ncn_ly_do', $reason);
		update_post_meta($post_id, $orphan_prefix .'ncn_finished_date', get_finished_date(intval($email_duration)));
		update_post_meta($post_id, $orphan_prefix .'ncn_nam_sinh', $birth_year);
		update_post_meta($post_id, $orphan_prefix .'ncn_gioi_tinh', $gender);
		update_post_meta($post_id, $orphan_prefix .'ncn_ghi_chu', $note);
	 	/*~~ POST INFO ~~*/  
		
		
		// REDIRECT
		echo json_encode(array_merge(array('captcha_new' => $captcha), array('Success' => true)));
	}
	
	exit();
}