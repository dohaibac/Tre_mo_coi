<?php
global $orphan_prefix;
$orphan_prefix = 'orphan_';
global $post_type_album, $post_type_album_label;
$post_type_album = 'hinh-anh';
$post_type_album_label = 'Hình ảnh';
function orphan_register_album() { 
	global $post_type_album, $post_type_album_label;
	$label = $post_type_album_label;
	$post_type_album = $post_type_album;
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
 
	$supports = array('title','excerpt','author','thumbnail','editor'); 
	$post_type_args = array(
		'labels' => $labels, 
		'singular_label' => __($label),
		'public' => true, 'show_ui' => true, 
		'publicly_queryable'=> true, 
		'query_var' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => $post_type_album),
		'supports' => $supports,
		'menu_position' => 5,
		'menu_icon' => get_bloginfo('template_directory').'/images/family.png'
	);
	register_post_type( $post_type_album,$post_type_args);
 } 
add_action('init', 'orphan_register_album');

function orphan_meta_box_to_manage_post_album($column_name, $post_id) {
		global $orphan_prefix, $orphan_fields_info_array;
        if($column_name == 'thumbnail'){
			$thumbnail = orphan_get_post_with_album($post_id);
			echo ('<img width="60" src="'.$thumbnail.'"/>');
		}
    }
	
/**
* Function name:	orphan_add_new_manage_columns
* Description : 	add columns meta_box to manage post
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add columns meta_box to manage post
*/
	function orphan_add_new_manage_columns_album($my_columns) {
		global $orphan_prefix, $orphan_fields_info_array;
			$new_my_columns['cb'] = '<input type="checkbox" />';	
			$new_my_columns['thumbnail'] = __('Hình ảnh');			
			$new_my_columns['title'] = __('Tên hình ảnh');
			$new_my_columns['author'] = __('Người đăng');			
			$new_my_columns['date'] = ('Ngày đăng');		
			return $new_my_columns;
		}
// Add to admin_init function $post_type_album
if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == $post_type_album){
	add_filter('manage_posts_columns', 'orphan_add_new_manage_columns_album');
	add_action('manage_posts_custom_column', 'orphan_meta_box_to_manage_post_album', 10, 2);
}


function orphan_get_post_with_album($post_id){
	$src_img = '';
	if (has_post_thumbnail()){ 
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail');
		if(isset($image[0])){
			$src_img = $image[0];
		} else {
			$src_img = get_thumbnail_with_album_by_post_content($post_id);
		}
	} else{
		$src_img = get_thumbnail_with_album_by_post_content($post_id);
	}
	return $src_img;
}

function get_thumbnail_with_album_by_post_content($post_id = null){
	$post = get_post($post_id );
	$src_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	if(isset($matches [1] [0]))
	$src_img = $matches [1] [0];

	if(empty($src_img)){ //Defines a default image
		$src_img = get_bloginfo('template_directory')."/images/no_image.png";
	}
	return $src_img;
}

function orphan_get_all_gallery($post_id = null){
	$post = get_post($post_id );
	$imgs = array();
	if($post){
		ob_start();
		ob_end_clean();
		preg_match_all('/<img[^>]+>/i',$post->post_content, $result); 
		if(isset($result[0] )){
			$i=0;
			foreach( $result[0] as $img_tag){
				preg_match_all('/(src)=("[^"]*")/i',$img_tag, $info_img);
				$img = str_replace(array('src="','"'),'',$info_img[0][0]);
				if(isset($img)){
					$imgs[$i]['href'] = $img;
					$imgs[$i]['title'] = $post->post_title;
				}
				$i++;
			}
		}
	} 
	if(empty($imgs)){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail');
		if(isset($image[0])){
			$src_img = $image[0];
			$imgs[0]['href'] = str_replace(array('src="','"'),'',$info_img[0][0]);
			$imgs[0]['title'] = $post->post_title;
		}
	}
	return $imgs;
}