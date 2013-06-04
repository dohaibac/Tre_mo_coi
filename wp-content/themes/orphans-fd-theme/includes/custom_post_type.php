<?php
/*
Registration post_type, taxonomy for wordpress
prefix : orphan_

*/

/* ========TRE MO COI=============== */
/**
* Function name:	orphan_register_orphan_posttype
* Description : 	registration code for tre-mo-coi post type
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			Post type : 'tre-mo-coi'
*/
global $orphan_prefix;
$orphan_prefix = 'orphan_';
global $post_type_name, $post_type_label;
$post_type_name = 'tre-mo-coi';
$post_type_label = 'Trẻ mồ côi';
function orphan_register_orphan_posttype() { 
	global $post_type_name, $post_type_label;
	$label = $post_type_label;
	$post_type_name = $post_type_name;
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
		'menu_icon' => get_bloginfo('template_directory').'/images/family.png'
	);
	register_post_type( $post_type_name,$post_type_args);
 } 
add_action('init', 'orphan_register_orphan_posttype', $post_type_name);

/**
* Function name:	orphan_register_chuyen_muc_tre_mo_coi_taxonomy
* Description : 	registration taxonomy 'chuyen-muc-tre-mo-coi' for wordpress
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			taxonomy 'chuyen-muc-tre-mo-coi'
*/
global $taxonomy_name, $taxonomy_label;
$taxonomy_name  = 'chuyen-muc-tre-mo-coi';
$taxonomy_label = 'Chuyên mục trẻ mồ côi';
function orphan_register_chuyen_muc_tre_mo_coi_taxonomy() {
	global $taxonomy_name, $taxonomy_label, $post_type_name;
	$labels = array(
		'name' 					=> _x( $taxonomy_label, 'taxonomy general name' ),
		'singular_name' 		=> _x( $taxonomy_label, 'taxonomy singular name' ),
		'add_new' 				=> _x( 'Add New '.$taxonomy_label, $taxonomy_label),
		'add_new_item' 			=> __( 'Add New '.$taxonomy_label ),
		'edit_item' 			=> __( 'Edit '.$taxonomy_label ),
		'new_item' 				=> __( 'New '.$taxonomy_label ),
		'view_item' 			=> __( 'View '.$taxonomy_label ),
		'search_items' 			=> __( 'Search '.$taxonomy_label ),
		'not_found' 			=> __( 'No '.$taxonomy_label.' found' ),
		'not_found_in_trash' 	=> __( 'No '.$taxonomy_label.' found in Trash' ),
	);
	$pages = array($post_type_name);
	$args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __($taxonomy_label),
		'public' 			=> true,
		'show_ui' 			=> true,
		'hierarchical' 		=> true,
		'show_tagcloud' 	=> true,
		'show_in_nav_menus' => true,
		'rewrite' 			=> array('slug' => $taxonomy_name),
	 );
	register_taxonomy($taxonomy_name, $pages, $args);
}

add_action('init', 'orphan_register_chuyen_muc_tre_mo_coi_taxonomy');


/* ========END TRE MO COI=============== */
