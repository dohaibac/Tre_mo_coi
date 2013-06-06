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
}