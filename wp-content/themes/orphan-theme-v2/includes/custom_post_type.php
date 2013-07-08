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
		'not_found' => __( 'No '.$label.' found' ),
		'not_found_in_trash'=> __( 'No '.$label.' found in Trash' ),
		'parent_item_colon' => ''
	);
 
 
	$supports = array('title',/*'editor','thumbnail',*/'author','excerpt'); 
	$post_type_args = array(
		'labels' => $labels, 
		'singular_label' => __($label),
		'public' => false, 'show_ui' => true,
		'exclude_from_search' => true,
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

/* META BOX */
/*==========Begin Info Meta======================*/
global $orphan_save_meta_post;
global $orphan_fields_info_array;

$orphan_fields_info_array = array(
	// Name
	// tên, năm sinh, giới tính, hoàn cảnh (trc khi nhận vào trại trẻ), user id (người bảo trợ), ảnh,
	orphan_result_meta(
		array(
			'name' 			=> 'photo',
			'label'			=> 'Photo',
			'description' 	=> 'Nhập đường dẫn ảnh',
			'type'			=> 'upload',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'birthday',
			'label'			=> 'Ngày sinh',
			'description' 	=> 'Nhập ngày sinh',
			'type'			=> 'date',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'gender',
			'label'			=> 'Gới tính',
			'description' 	=> 'Chọn giới tính của trẻ',
			'type'			=> 'radio',
			'rich_editor'	=> false,
			'options'		=> array(
				'Nam',
				'Nữ'
			)
		)
	)
);
$orphan_save_meta_post[] = $orphan_fields_info_array;
/**
* Function name:	orphan_get_info_meta_box
* Description : 	get info fields of post type orphan
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			get info fields of post type orphan
*/
function orphan_get_info_meta_box(){
	global $orphan_fields_info_array;
	return $orphan_fields_info_array;
}

/**
* Function name:	orphan_add_meta_box
* Description : 	Add custom field to wordpress
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add meta post
*/
add_action('admin_menu', 'orphan_add_info_meta_box');
function orphan_add_info_meta_box(){
	global $orphan_prefix, $orphan_fields_info_array, $post_type_name;
	
	$meta_box_fields = array(
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $orphan_fields_info_array
	);
	add_meta_box($orphan_prefix.'metabox_info_orphan', 'Thông tin trẻ em', 'orphan_show_meta_box', $post_type_name, 'advanced', 'default', $meta_box_fields);
}

/*==========End Info Meta======================*/

/*==========Begin Info Meta CV======================*/
global $orphan_fields_cv_array;

$orphan_fields_cv_array = array(
	// Name
	// tên, năm sinh, giới tính, hoàn cảnh (trc khi nhận vào trại trẻ), user id (người bảo trợ), ảnh,
	orphan_result_meta(
		array(
			'name' 			=> 'cv-address',
			'label'			=> 'Địa điểm',
			'description' 	=> 'Nhập địa điểm khi gặp trẻ',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'cv-time',
			'label'			=> 'Thời gian gặp trẻ',
			'description' 	=> 'Nhập thời gian khi gặp trẻ',
			'type'			=> 'date',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'cv-content',
			'label'			=> 'Tình trạng khi gặp trẻ',
			'description' 	=> 'Nhập tình trạng khi gặp trẻ',
			'type'			=> 'textarea',
			'rich_editor'	=> true,
			'options'		=> null
		)
	),
	orphan_result_meta(
		array(
			'name' 			=> 'cv-auth',
			'label'			=> 'Người gặp trẻ',
			'description' 	=> 'Nhập thông tin người gặp trẻ',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	)
);
$orphan_save_meta_post[] = $orphan_fields_cv_array;
/**
* Function name:	orphan_get_all_meta_box
* Description : 	get all fields of post type orphan
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			get all fields of post type orphan
*/
function orphan_fields_cv_array(){
	global $orphan_fields_cv_array;
	return $orphan_fields_cv_array;
}

/**
* Function name:	orphan_add_meta_box
* Description : 	Add custom field to wordpress
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add meta post
*/
add_action('admin_menu', 'orphan_add_info_meta_cv_box');
function orphan_add_info_meta_cv_box(){
	global $orphan_prefix, $orphan_fields_cv_array, $post_type_name;
	
	$meta_box_fields = array(
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $orphan_fields_cv_array
	);
	add_meta_box($orphan_prefix.'metabox_info_cv_orphan', 'Hoàn cảnh nhận trẻ', 'orphan_show_meta_box', $post_type_name, 'advanced', 'default', $meta_box_fields);
}
/*==========End Info Meta CV======================*/
/**
* Function name:	orphan_show_meta_box
* Description : 	Add custom field to wordpress
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			show meta post
*/
function orphan_result_meta($meta_info = null){
	global $ecpt_prefix;
	$name = $meta_info['name'];
	$label = $meta_info['label'];
	$decription = isset($meta_info['description']) ? $meta_info['description'] :  $label;
	$type = $meta_info['type'];
	$rich_editor = $meta_info['rich_editor'];
	$options = $meta_info['options'];
	$name = orphan_process_string_post($name);
	
	return array(
			'name' 			=> orphan_process_string_post($name),
			'desc' 			=> $decription,
			'label' 		=> $label,
			'id' 			=> $ecpt_prefix . $name,
			'class' 		=> $ecpt_prefix . $name,
			'type' 			=> $type,
			'rich_editor' 	=> $rich_editor,
			'options' 		=> $options
		);
}

/**
* Function name:	orphan_replace_character_utf_8
* Description : 	replace character utf-8
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			replace character utf-8
*/
function orphan_replace_character_utf_8($str) {
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	//$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
	return $str;
}

/**
* Function name:	orphan_process_string_post
* Description : 	Replace special character
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			Replace special character
*/
function orphan_process_string_post($name = null, $character = null){
	if($name == null){
		return null;
	}
	if($character == null){
		$character = '-';
	} 
	return preg_replace('/[^a-zA-Z0-9!@#$"\'\/()\.,]/', $character, orphan_replace_character_utf_8(str_replace(array(' \ ',' /','/ ',' / ','/'),'-',str_replace('  ',' ', strtolower(trim($name))))));
}

/**
* Function name:	orphan_show_meta_box
* Description : 	Add custom field to wordpress
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			show meta post
*/
function orphan_show_meta_box($post, $metabox)	{
	global $post,$orphan_prefix,$meta_name;
	
	wp_enqueue_script('jquery-ui',get_bloginfo('template_directory').'/includes/js/jquery-ui.js');
	wp_enqueue_script('ui.datepicker-vi',get_bloginfo('template_directory').'/includes/js/ui.datepicker-vi.js');
	wp_enqueue_script('orphan-script-admin',get_bloginfo('template_directory').'/includes/js/orphan-script-admin.js');
	
	echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />';
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/includes/css/custom-meta-post.css" />';

	echo '<input type="hidden" name="'.$orphan_prefix.'meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';
    foreach ($metabox['args']['fields'] as $field) {
		$field['id'] = $orphan_prefix.$field['id'];
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['label'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '
', $field['desc'];
                break;
				
			case 'date':
                echo '<input type="text" class="'.$orphan_prefix.'datepicker" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '
', $field['desc'];
                break;

			case 'upload':
				$src_img  = $meta ? $meta : $field['std'];
				$load_image = '<img id="image_'.$field['id'].'" width="50" height="50" src="'.$src_img.'" style=" float:right; display:'.(($src_img != '')? "block;" : 'none;').'" />';
                echo '<input type="text" class="'.$orphan_prefix.'upload_field" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:75%" /><input class="upload_image_button" data="'.$orphan_prefix.'image_'.$field['id'].'" type="button" value="Upload Image" />',$load_image,'<br/>', '

', $field['desc'];
                break;

            case 'textarea':
				if($field['rich_editor'] == 1) {
					echo '<div style="width: 97%; border: 1px solid #DFDFDF;">';
					$args = array(
						'textarea_rows' => 5,
						'teeny' => true,
						'quicktags' => false
					);
					 $settings = array(
						'textarea_name' => $field['id'],
						'textarea_rows' => 5,
						'media_buttons' => true,
						'tinymce' => array(
							'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
								'bullist,blockquote,|,justifyleft,justifycenter' .
								',justifyright,justifyfull,|,link,unlink,|' .
								',spellchecker,wp_fullscreen,wp_adv'
						)
					);
					wp_editor( ($meta ? $meta : $field['std']), $field['id'], $settings );
					echo '</div>';
				} else {
					echo '<div style="width: 100%;"><textarea name="', $field['id'], '" class="', $field['class'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea></div>', '

', $field['desc'];				

				}
				echo $field['desc'];
                break;

            case 'select':
				if(!empty($field['options'])){
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
					echo '<option value="' . $option . '"', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>', '', $field['desc'];
				}
                break;

            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option, '"', $meta == $option ? ' checked="checked"' : '', ' />&nbsp;', $option;
                }
				echo '<br/>' . $field['desc'];
                break;

            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />&nbsp;';
				echo $field['desc'];
                break;
        }
        echo     '<td>',
            '</tr>';

    }
	echo '</table><style>.ui-datepicker{}</style>';
	echo orphan_add_meta_script();
}

/**
* Function name:	orphan_save_meta_data
* Description : 	Save data from meta box
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			Save data from meta box
*/
add_action('save_post', 'orphan_save_meta_data');
function orphan_save_meta_data($post_id) {

    global $wpdb,$orphan_save_meta_post, $orphan_prefix;

    if (isset($_POST[$orphan_prefix.'meta_box_nonce']) && (!wp_verify_nonce($_POST[$orphan_prefix.'meta_box_nonce'], basename(__FILE__)))) {

        return $post_id;

    }
	
    // check autosave

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

        return $post_id;

    }
    // check permissions

    if (isset($_POST['post_type']) && ('page' == $_POST['post_type'])) {

        if (!current_user_can('edit_page', $post_id)) {

            return $post_id;

        }

    } elseif (!current_user_can('edit_post', $post_id)) {

        return $post_id;

    }

    if(isset($_POST['post_type'])){

	// first get the metaboxes associated with this post
		if($orphan_save_meta_post){
			
			foreach( $orphan_save_meta_post as $fields_meta){
				foreach( $fields_meta as $key => $field){
					$old = get_post_meta($post_id, $orphan_prefix . $field['name'], true);
					$data = $_POST[$orphan_prefix . $field['name']];
					if($field->type == 'textarea') {
						$new = wpautop($data);
					}  else {
						$new = $data;
					}
					if ($new && $new != $old) {
						update_post_meta($post_id, $orphan_prefix . $field['name'], $new);
					} elseif ('' == $new && $old) {
						delete_post_meta($post_id, $orphan_prefix . $field['name'], $old);
					}
				}
			}
		}
		
		
	}
}

/**
* Function name:	orphan_add_meta_script
* Description : 	add script to meta-post
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add script to meta-post
*/
function orphan_add_meta_script(){
	global $orphan_prefix;
?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
				jQuery(".<?php echo $orphan_prefix; ?>datepicker").datepicker({
					dateFormat: "dd/mm/yy",
					yearRange: "-90:+0",
					changeMonth: true, 
					changeYear: true
				});
		})
	</script>
<?php }


/**
* Function name:	orphan_shortcode_meta_box
* Description : 	add action shortcode metabox of orphan
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add action shortcode metabox of orphan
*/
function orphan_shortcode_meta_box(){
	global $orphan_prefix;
	return $orphan_prefix;
}

/**
* Function name:	orphan_meta_box_to_manage_post
* Description : 	add data meta_box to manage post
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add data meta_box to manage post
*/
    function orphan_meta_box_to_manage_post($column_name, $post_id) {
		global $orphan_prefix, $orphan_fields_info_array;
            $width = (int) 60;
            $height = (int) 60;
			if(isset($orphan_fields_info_array)){
				foreach($orphan_fields_info_array as $field_value){
					$key_value = $orphan_prefix.$field_value['name'];
					if ( $key_value == $column_name ) {
						$meta_values = get_post_meta($post_id, $key_value, true);
						if($meta_values){
							if($field_value['type'] == 'upload'){
								echo ('<img width="60" src="'.$meta_values.'"/>');
							} else {
								echo $meta_values;
							}
						} else {
							echo 'Update...';
						}
					}
				}
			}
    }
	
/**
* Function name:	orphan_add_new_manage_columns
* Description : 	add columns meta_box to manage post
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 4, 2013		Vinh.le			add columns meta_box to manage post
*/
	function orphan_add_new_manage_columns($my_columns) {
		global $orphan_prefix, $orphan_fields_info_array;
			$new_my_columns['cb'] = '<input type="checkbox" />';	 
			$new_my_columns['title'] = __('Họ tên');
			foreach($orphan_fields_info_array as $field_value){
				$key_colum = $orphan_prefix.$field_value['name'];
				$new_my_columns[$key_colum] = ($field_value['label']);
			}
			$new_my_columns['author'] = __('Người đăng');			
			$new_my_columns['date'] = ('Ngày đăng');		
			return $new_my_columns;
		}
	// Add to admin_init function $post_type_name
if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == $post_type_name){
	add_filter('manage_posts_columns', 'orphan_add_new_manage_columns');
	add_action('manage_posts_custom_column', 'orphan_meta_box_to_manage_post', 10, 2);
}
/* ========END TRE MO COI=============== */