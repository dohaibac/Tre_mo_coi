<?php

global $post_type_name, $post_type_label;
$post_type_name = 'tre-mo-coi';
$post_type_label = 'Trẻ mồ côi';		
// registration code for post type 
function register_custom_posttype() { 
	global $post_type_name, $post_type_label;
	$label = 'Trẻ mồ côi';
	$post_type_name = 'tre-mo-coi';
	$labels = array( 
		'name' => _x( $label, 'post type general name' ),
		'singular_name' => _x( $label, 'post type singular name' ),
		'add_new' => _x( 'Add New', $label),
		'add_new_item' => __( 'Add New '.$label), 
		'edit_item' => __( 'Edit '.$label), 
		'new_item' => __( 'New '.$label), 
		'view_item' => __( 'View '.$label), 
		'search_items' => __( 'Search '.$label),
		'not_found' => __( 'No Service found' ),
		'not_found_in_trash'=> __( 'No '.$label.' found in Trash' ),
		'parent_item_colon' => ''
	);
 
	$supports = array('title','editor','author','thumbnail','excerpt'); 
	$post_type_args = array(
		'labels' => $labels, 
		'singular_label' => __($label),
		'public' => true, 'show_ui' => true, 
		'publicly_queryable'=> true, 
		'query_var' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => $post_type_name),
		'supports' => $supports,
		'menu_position' => 5,
		'menu_icon' => '' 
	);
	register_post_type( $post_type_name,$post_type_args);
 } 
add_action('init', 'register_custom_posttype', $post_type_name);
