<?php
global $orphan_prefix;
$orphan_prefix = 'orphan_';
global $post_type_ncn, $post_type_ncn_label;
$post_type_ncn = 'nhan-con-nuoi';
$post_type_ncn_label = 'Nhận con nuôi';
function orphan_register_nhan_con_nuoi_type() { 
	global $post_type_ncn, $post_type_ncn_label;
	$label = $post_type_ncn_label;
	$post_type_ncn = $post_type_ncn;
	$labels = array( 
		'name' => _x( $label, 'post type general name' ),
		'singular_name' => _x( $label, 'post type singular name' ),
		'add_new' => _x( 'Add New', $label),
		'add_new_item' => __( 'Add New '.$label), 
		'edit_item' => __( 'Edit '.$label), 
		'new_item' => __( 'New '.$label), 
		'view_item' => __( 'View '.$label), 
		'search_items' => __( 'Search '.$label),
		'not_found' => __( 'No '.$label.' found' ),
		'not_found_in_trash'=> __( 'No '.$label.' found in Trash' ),
		'parent_item_colon' => ''
	);
 
	$supports = array('title','excerpt','author','thumbnail',); 
	$post_type_args = array(
		'labels' => $labels, 
		'singular_label' => __($label),
		'public' => true, 'show_ui' => true, 
		'publicly_queryable'=> true, 
		'query_var' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => $post_type_ncn),
		'supports' => $supports,
		'menu_position' => 5,
		'menu_icon' => get_bloginfo('template_directory').'/images/family.png'
	);
	register_post_type( $post_type_ncn,$post_type_args);
 } 
add_action('init', 'orphan_register_nhan_con_nuoi_type');

global $taxonomy_ncn, $taxonomy_ncn_label;
$taxonomy_ncn  = 'chuyen-muc-nhan-con-nuoi';
$taxonomy_ncn_label = 'Chuyên mục nhận con nuôi';
function orphan_register_chuyen_muc_nhan_con_nuoi_taxonomy() {
	global $taxonomy_ncn, $taxonomy_ncn_label, $post_type_ncn;
	$labels = array(
		'name' 					=> _x( $taxonomy_ncn_label, 'taxonomy general name' ),
		'singular_name' 		=> _x( $taxonomy_ncn_label, 'taxonomy singular name' ),
		'add_new' 				=> _x( 'Add New '.$taxonomy_ncn_label, $taxonomy_ncn_label),
		'add_new_item' 			=> __( 'Add New '.$taxonomy_ncn_label ),
		'edit_item' 			=> __( 'Edit '.$taxonomy_ncn_label ),
		'new_item' 				=> __( 'New '.$taxonomy_ncn_label ),
		'view_item' 			=> __( 'View '.$taxonomy_ncn_label ),
		'search_items' 			=> __( 'Search '.$taxonomy_ncn_label ),
		'not_found' 			=> __( 'No '.$taxonomy_ncn_label.' found' ),
		'not_found_in_trash' 	=> __( 'No '.$taxonomy_ncn_label.' found in Trash' ),
	);
	$pages = array($post_type_ncn);
	$args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __($taxonomy_ncn_label),
		'public' 			=> true,
		'show_ui' 			=> true,
		'hierarchical' 		=> true,
		'show_tagcloud' 	=> true,
		'show_in_nav_menus' => true,
		'rewrite' 			=> array('slug' => $taxonomy_ncn),
	 );
	register_taxonomy($taxonomy_ncn, $pages, $args);
}

add_action('init', 'orphan_register_chuyen_muc_nhan_con_nuoi_taxonomy');

/**add box admin*/
global $orphan_fields_ncn_array;
global $orphan_save_meta_post;
$orphan_fields_ncn_array = array(
	// ly do nhan con nuoi
	// gioi tinh
	// nam sinh
	// ghi chu
	// thoi gian nhan mail
	orphan_result_meta(
		array(
			'name' 			=> 'ncn-ly-do',
			'label'			=> 'Lý do nhận con nuôi',
			'description' 	=> 'lý do nhận con nuôi',
			'type'			=> 'textarea',
			'required'		=> true,
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'ncn-ngay-sinh',
			'label'			=> 'Năm sinh',
			'description' 	=> 'Nhập năm sinh',
			'type'			=> 'date',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),

	orphan_result_meta(
		array(
			'name' 			=> 'ncn-gioi-tinh',
			'label'			=> 'Giới tính',
			'description' 	=> 'Giới tính của trẻ',
			'type'			=> 'radio',
			'rich_editor'	=> false,
			'options'		=> array(
				'Nam',
				'Nữ'
			)
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'ncn-ghi-chu',
			'label'			=> 'Ghi chú thông tin',
			'description' 	=> 'Nhập thông tin ghi chú',
			'type'			=> 'textarea',
			'rich_editor'	=> false,
			'options'		=> null
		)
	)
	,
	orphan_result_meta(
		array(
			'name' 			=> 'ncn-month-email',
			'label'			=> 'Thời gian nhận email',
			'description' 	=> 'Nhập thời gian nhận email',
			'type'			=> 'radio',
			'rich_editor'	=> false,
			'options'		=> array(
				'1 Tháng',
				'3 Tháng',
				'6 Tháng'
			)
		)
	)
);

$orphan_save_meta_post[] = $orphan_fields_ncn_array;
function orphan_fields_ncn_array(){
 global $orphan_fields_ncn_array;
 return $orphan_fields_ncn_array;
}
add_action('admin_menu', 'orphan_add_meta_box_ncn');
function orphan_add_meta_box_ncn(){
	global $orphan_prefix, $orphan_fields_ncn_array, $post_type_ncn;
	
	$meta_box_fields = array(
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $orphan_fields_ncn_array
	);
	add_meta_box($orphan_prefix.'metabox_thong_tin_nhan_con_nuoi', 'Thông tin nhận con nuôi', 'orphan_show_meta_box', $post_type_ncn, 'advanced', 'default', $meta_box_fields);
}