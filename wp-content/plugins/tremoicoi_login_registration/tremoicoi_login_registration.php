<?php
/*
Plugin Name: TreMoCoi- Đăng ký, Đăng nhập
Plugin URI: 
Description:  Chức năng đăng ký, đăng nhập website Trẻ Mồ Côi
Version: 1.0
Author: Hien Tran & Hieu Tran
Author URI:
License: MIT License
*/

require_once( dirname( __FILE__ ) . '/ui.php' );
require( ABSPATH . WPINC . '/ms-functions.php' );

add_action('init', 'check_user_activation_key');
add_action('wp_ajax_nopriv_tmc_login', 'tmc_login');
add_action('wp_ajax_nopriv_tmc_register', 'tmc_register');

function tmc_login(){
	$user = wp_signon('' , false );
	if ( is_wp_error($user) ){
		echo json_encode(array('Success' => false));
	}
	else{
		echo json_encode(array('Success' => true, 'Redirect' =>  get_site_url()));
	}
	die();
}

function tmc_register(){
	if(!isset($_POST['captcha']) || !isset($_POST['captcha_prefix']))
		$captcha_error = true;
	
	$captcha_instance = new ReallySimpleCaptcha();
	
	if(!$captcha_instance->check( $_POST['captcha_prefix'], $_POST['captcha'] ))
		$captcha_error = true;
		
	$captcha_instance->remove( $prefix );
	
	if($captcha_error)
	{
		$captcha = create_captcha();
		
		echo json_encode(array('errors' => array('captcha' => true), 'captcha' => array('prefix' => $captcha['prefix'], 'file' => $captcha['file'])));
		
		die();
	}
	
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $_POST['user_login'] );
	$user_email = apply_filters( 'user_registration_email', $_POST['email']);

	
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( 'Hãy nhập Tên đăng nhập.' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( 'Tên đăng nhập không hợp lệ.' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( 'Tên đăng nhập đã tồn tại' ) );
	}

	
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( 'Hãy nhập email.' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( 'Email không hợp lệ.' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( 'Email đã tồn tại.' ) );
	}
	
	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
	{
		$captcha = create_captcha();
		$errors->captcha = array('prefix' => $captcha['prefix'], 'file' => $captcha['file']);
		echo json_encode($errors);
		die();
	}
	else
	{
		$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	
		if ( ! $user_id ) {
			$errors->add( 'registerfail', sprintf( __( 'Không thể tạo tài khoản, hãy liên hệ <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
			
			$captcha = create_captcha();
			$errors->captcha = array('prefix' => $captcha['prefix'], 'file' => $captcha['file']);
			echo json_encode($errors);
			die();
		}
		wp_update_user( array ( 'ID' => $user_id, 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'] ));
		
		wp_set_password($_POST['pwd'], $user_id);
		
		$key = substr( md5( time() . rand() . $sanitized_user_login ), 0, 16 );
		
		add_user_meta( $user_id, 'tmc_activation_key', $key);
		
		add_user_meta( $user_id, 'address', $_POST['address']);
		add_user_meta( $user_id, 'district', $_POST['district']);
		add_user_meta( $user_id, 'province', $_POST['province']);
		add_user_meta( $user_id, 'phone', $_POST['phone']);
		
		wp_new_user_notification( $user_id);
		
		echo json_encode(array('Success' => true));
	}

	die();
}

function check_user_activation_key(){
	if(isset($_GET['activation_key']) && isset($_GET['userlogin']))
	{
		$user = get_user_by('login', $_GET['userlogin']);
		
		if($user)
		{
			$key = get_user_meta($user->ID, 'tmc_activation_key', true);
			
			if(trim($_GET['activation_key']) == $key)
			{
				update_user_meta($user->ID, 'tmc_activation_key', '');
				wp_set_auth_cookie($user->ID, false, false);
				do_action('wp_login', $user->user_login, $user);
				wp_redirect( home_url() . '?activation=success');
				exit;
			}
		}
	}
	
	if(isset($_GET['activation']) && $_GET['activation'] == 'success')
	{
		add_action('wp_head', 'tmc_add_user_activation_success_javascript');
		add_action('wp_footer', 'tmc_add_user_activation_success_box', 101);
	}
}

function tmc_add_user_activation_success_box(){
	echo <<<EOF
<div id="user_activation_success_box">Bạn đã kích hoạt tài khoản thành công, chúc mừng bạn đã là thành viên của TreMoCoi.Org.Vn.</div>
EOF;
}

function tmc_add_user_activation_success_javascript()
{
	echo <<<EOF
	<script language="javascript">
		$(document).ready(function(){
			$.fancybox(
             $("#user_activation_success_box").html(), //fancybox works perfect with hidden divs
             {scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}}
			);
		});
	</script>
EOF;
}

function create_captcha(){
	$captcha_plugin_url = plugins_url() . '/really-simple-captcha/tmp/';
	$captcha_instance = new ReallySimpleCaptcha();
	$captcha_instance->img_size = array( 72, 30 );
	$captcha_instance->font_size = 16;
	$captcha_instance->base = array( 9, 20 );
	$word = $captcha_instance->generate_random_word();
	$prefix = mt_rand();	
	$file = $captcha_instance->generate_image( $prefix, $word );
	
	return array('prefix' => $prefix, 'file' => $captcha_plugin_url.$file);
}

if ( !function_exists('wp_new_user_notification') ) :
	
	function wp_new_user_notification( $user_id, $plaintext_pass = '' )
	{
		$user = get_user_by('id', $user_id);
		
		$key = get_user_meta($user->ID, 'tmc_activation_key', true);

		$user_login = stripslashes($user->user_login); 
		$user_email = stripslashes($user->user_email); 

		$message  = __('Tài khoản sau vừa được đăng ký.') . "\r\n\r\n"; 
		$message .= __('Tên đăng nhập: '. $user_login) . "\r\n\r\n"; 
		$message .= __('E-mail: '. $user_email) . "\r\n"; 
		$message .= "\r\n\r\n";

		@wp_mail(get_option('admin_email'), __("Tài khoản $user_login vừa được đăng ký."), $message); 
 
     	$message  = __('Chào mừng bạn đến với website TreMoCoi.Org.Vn') . "\r\n\r\n"; 
     	$message .= __('Tên đăng nhập: '. $user_login) . "\r\n"; 
		$message .= __('E-mail: '. $user_email) . "\r\n"; 
		$message .= __('Click vào liên kết bên dưới để kích hoạt tài khoản:') . "\r\n"; 
		
     	$message .= home_url().'?userlogin='.$user_login."&activation_key=$key\r\n"; 
		$message .= "\r\n\r\n";

		wp_mail($user_email, __('Kích hoạt tài khoản Trẻ Mồ Côi'), $message);	
	}
endif;