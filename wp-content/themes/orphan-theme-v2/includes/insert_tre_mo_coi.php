<?php
//add_action('wp_ajax_insert_tre_mo_coi', 'insert_tre_mo_coi');
add_action( 'wp_ajax_nopriv_insert_tre_mo_coi', 'insert_tre_mo_coi' );  
add_action( 'wp_ajax_insert_tre_mo_coi', 'insert_tre_mo_coi' );
function insert_tre_mo_coi(){
	global $orphan_prefix;
	global $current_user;
	$results['status_login'] = 'true';
	$results['message'] = 'Đã có lỗi trong quá trình nhập dữ liệu. Vui lòng thử lại sau';
	$results['status'] = 'false';
	if(isset($current_user->ID)){
	$data = array();
   if(isset($_POST['data_from'])){
    parse_str($_POST['data_from'], $data);
   }
   if(isset($data['txt-name'])){
		$title = $data["txt-name"];
		// Create post object
		$my_post = array(
		  'post_title'    => $title,
		  'post_type'    => 'tre-mo-coi',
		  'post_content'  => 'Trẻ mồ côi',
		  'post_status'   => 'pending',
		  'post_author'   => $current_user->ID
		);
		$birthday = $data["birthday_datepicker"];
		// Insert the post into the database
		$post_id  = wp_insert_post( $my_post );
		//echo $post_id;
		if($post_id){
			add_post_meta( $post_id, $orphan_prefix.'new-name', $data["chk-newname"] );
			add_post_meta( $post_id, $orphan_prefix.'birthday', $birthday );
			add_post_meta( $post_id, $orphan_prefix.'gender', $data["txt-gender"] );
			add_post_meta( $post_id, $orphan_prefix.'cv-address', $data["txt-place"] ); 
			add_post_meta( $post_id, $orphan_prefix.'cv-time', $data["txt-time"] );
			add_post_meta( $post_id, $orphan_prefix.'cv-content', $data["txt-content"] );
			add_post_meta( $post_id, $orphan_prefix.'photo', $data["url-hinhanh"] );
			add_post_meta( $post_id, $orphan_prefix.'cv-auth',$current_user->user_email);
			$results['status'] = 'true';
			$results['message'] = 'Nhập dữ liệu thành công';
		} else {
			
		}
	}else{
		
	}
	}else
	{
		$results['status_login'] = 'false';
		$results['message'] = 'Hãy đăng nhập để tiếp tục nhập dữ liệu';
	}
	
	die(orphan_get_json($results));
}