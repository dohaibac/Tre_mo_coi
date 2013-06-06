<?php

function insert_tre_mo_coi($data){
	global $orphan_prefix;
	//var_dump($data);

	$title = $data["txt-name"];
	// Create post object
	$my_post = array(
	  'post_title'    => $title,
	  'post_type'    => 'tre-mo-coi',
	  'post_content'  => 'This is my post.',
	  'post_status'   => 'pending',
	  'post_author'   => 1
	);
	$birthday = $data["cbx-day"].'/'.$data["cbx-month"].'/'.$data["cbx-year"];
	// Insert the post into the database
	$post_id  = wp_insert_post( $my_post );
	//echo $post_id;
	if($post_id){
		add_post_meta( $post_id, $orphan_prefix.'birthday', $birthday );
		add_post_meta( $post_id, $orphan_prefix.'gender', $data["txt-gender"] );
		add_post_meta( $post_id, $orphan_prefix.'cv-address', $data["txt-place"] ); 
		add_post_meta( $post_id, $orphan_prefix.'cv-time', $data["txt-time"] );
		add_post_meta( $post_id, $orphan_prefix.'cv-content', $data["txt-content"] );
		wp_redirect(home_url('/nhap-thong-tin-tre-thanh-cong'));
		exit;
	} else {
		
	}


}