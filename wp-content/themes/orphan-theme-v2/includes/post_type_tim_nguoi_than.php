<?php
global $orphan_prefix;
$orphan_prefix = 'orphan_';
global $post_type_parent_tnt, $post_type_parent_tnt_label;
$post_type_parent_tnt = 'bo-me-tim-con';
$post_type_parent_tnt_label = 'Bố mẹ tìm con';
function orphan_register_parent_tnt() { 
	global $post_type_parent_tnt, $post_type_parent_tnt_label;
	$label = $post_type_parent_tnt_label;
	$post_type_tnt = $post_type_parent_tnt;
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
 
	$supports = array('title'); 
	$post_type_args = array(
		'labels' => $labels, 
		'singular_label' => __($label),
		'public' => true, 'show_ui' => true, 
		'publicly_queryable'=> true, 
		'query_var' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => $post_type_tnt),
		'supports' => $supports,
		'menu_position' => 5,
		'menu_icon' => get_bloginfo('template_directory').'/images/family.png'
	);
	register_post_type( $post_type_tnt,$post_type_args);
 } 
add_action('init', 'orphan_register_parent_tnt');

/* Begin Info parent looking for children */
global $orphan_fields_parent_tnt_children_array;
global $orphan_save_meta_post;
$orphan_fields_parent_tnt_children_array = array(
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_name',
			'label'			=> 'Tên con',
			'description' 	=> 'Nhập nhập tên con',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_birthday',
			'label'			=> 'Tuổi(hiện nay)',
			'description' 	=> 'Nhập tuổi hiện nay',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_gender',
			'label'			=> 'Giới tính',
			'description' 	=> 'Chọn giới tính của trẻ',
			'type'			=> 'radio',
			'rich_editor'	=> false,
			'options'		=> array(
				'Nam',
				'Nữ'
			)
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_time_lost',
			'label'			=> 'Thời gian thất lạc',
			'description' 	=> 'Nhập thời gian thất lạc',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_clothing',
			'label'			=> 'Quần áo lúc thất lạc',
			'description' 	=> 'Nhập quần áo lúc thất lạc',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_place_lost',
			'label'			=> 'Địa điểm thất lạc',
			'description' 	=> 'Nhập địa điểm thất lạc',
			'type'			=> 'textarea',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_description',
			'label'			=> 'Đặc điểm chung',
			'description' 	=> 'Nhập đặc điểm chung',
			'type'			=> 'textarea',
			'rich_editor'	=> true,
			'options'		=> null
		)
	)
);

$orphan_save_meta_post[] = $orphan_fields_parent_tnt_children_array;
function orphan_fields_parent_tnt_children_array(){
 global $orphan_fields_parent_tnt_children_array;
 return $orphan_fields_parent_tnt_children_array;
}
add_action('admin_menu', 'orphan_add_meta_box_parent_tnt_children');
function orphan_add_meta_box_parent_tnt_children(){
	global $orphan_prefix, $orphan_fields_parent_tnt_children_array, $post_type_parent_tnt;
	
	$meta_box_fields = array(
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $orphan_fields_parent_tnt_children_array
	);
	add_meta_box($orphan_prefix.'metabox_bo_me_tim_con_2', 'Thông tin tìm con', 'orphan_show_meta_box', $post_type_parent_tnt, 'advanced', 'default', $meta_box_fields);
}
/* End Info parent looking for children */
function orphan_result_meta_tnt($meta_info = null){
	global $ecpt_prefix;
	$name = $meta_info['name'];
	$label = $meta_info['label'];
	$decription = isset($meta_info['description']) ? $meta_info['description'] :  $label;
	$type = $meta_info['type'];
	$rich_editor = $meta_info['rich_editor'];
	$options = $meta_info['options'];
	
	return array(
			'name' 			=> $name,
			'desc' 			=> $decription,
			'label' 		=> $label,
			'id' 			=> $ecpt_prefix . $name,
			'class' 		=> $ecpt_prefix . $name,
			'type' 			=> $type,
			'rich_editor' 	=> $rich_editor,
			'options' 		=> $options
		);
}

add_action( 'wp_ajax_nopriv_ajax_insert_parent_looking_for_children', 'ajax_insert_parent_looking_for_children' );  
add_action( 'wp_ajax_ajax_insert_parent_looking_for_children', 'ajax_insert_parent_looking_for_children' );
function ajax_insert_parent_looking_for_children(){
	global $orphan_prefix, $current_user ,$post_type_parent_tnt;
	$results['status_login'] = 'true';
	$results['message'] = 'Đã có lỗi trong quá trình nhập dữ liệu. Vui lòng thử lại sau';
	$results['status'] = 'false';
	$results['user_update'] = '';
	$check_captcha['captcha_error'] = 'false';
	if(isset($current_user->ID)){
		$dataForm = array();
	   if(isset($_POST['data_from'])){
		parse_str($_POST['data_from'], $dataForm);
	   }
	  // var_dump($dataForm); die;
	   $check_captcha = orphan_check_captcha($dataForm);
	   if($check_captcha['status'] == 'false'){
			$check_captcha['status_login'] = 'true';
			$check_captcha['captcha_error'] = 'true';
			$results = $check_captcha;
	   } else {
		   if(isset($dataForm['txt-name']) && isset($dataForm["txt-children_name"])){
				//var_dump($dataForm); die;
				//Update info user
				$user_id = $current_user->ID;
				$data_user_update = array();
				$data_user_update['ID'] = $user_id;
				if($dataForm['txt-email'] != ''){
					//$data_user_update['user_email'] = $dataForm['txt-email'];
				}
				if($dataForm['txt-name'] != ''){
					$data_user_update['display_name '] = $dataForm['txt-name'];
				}
				$results['user_update'] = wp_update_user( $data_user_update) ;

				if($dataForm['txt-phone']!=''){
					update_usermeta( $user_id, 'phone', $dataForm['txt-phone']);
				}
				if($dataForm['txt-address']!=''){
					update_usermeta( $user_id, 'address', $dataForm['txt-address']);
				}
				if($dataForm['txt-job']!=''){
					update_usermeta( $user_id, 'job', $dataForm['txt-job']);
				}
				if($dataForm['url-photo']!=''){
					update_usermeta( $user_id, 'user_avatars', $dataForm['url-photo']);
				}
				
				$title = $dataForm["txt-children_name"];
				// Create post object
				$my_post = array(
				  'post_title'    => $title,
				  'post_type'    => $post_type_parent_tnt,
				  'post_status'   => 'pending',
				  'post_author'   => $current_user->ID
				);
				// Insert the post into the database
				$post_id  = wp_insert_post( $my_post );
				//echo $post_id;
				if($post_id){
					if($dataForm["txt-children_name"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_name', $dataForm["txt-children_name"]);
					}
					if($dataForm["txt-children_birthday"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_birthday', $dataForm["txt-children_birthday"]);
					}
					if($dataForm["txt-children_gender"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_gender', $dataForm["txt-children_gender"]);
					}
					if($dataForm["url-children_photo"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_photo', $dataForm["url-children_photo"]);
					}
					if($dataForm["txt-children_time_lost"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_time_lost', $dataForm["txt-children_time_lost"]);
					}
					if($dataForm["txt-children_clothing"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_clothing', $dataForm["txt-children_clothing"]);
					}
					if($dataForm["txt-children_place_lost"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_place_lost', $dataForm["txt-children_place_lost"]);
					}
					if($dataForm["children_description"] != ''){
						add_post_meta( $post_id, $orphan_prefix.'children_description', $dataForm["children_description"]);
					}
					$results['status'] = 'true';
					$results['message'] = 'Nhập dữ liệu thành công. Hệ thống sẽ tự chuyển về trang chủ sau 3 giây.';
				} else {
					$results['message'] = 'Đăng thông tin không thành công hãy thử lại.';
				}
			}else{
				$results['message'] = 'Nhập tên của bố-mẹ.';
			}
		}
	}else
	{
		$results['status_login'] = 'false';
		$results['message'] = 'Hãy đăng nhập để tiếp tục nhập dữ liệu';
	}
	die(orphan_get_json($results));
}

add_filter('get_avatar', 'orphan_custom_avatars', 10, 3);

function orphan_custom_avatars($avatar, $id_or_email, $size){
  if(is_numeric($id_or_email)){
    $image_url = get_user_meta($id_or_email, 'user_avatars', true);
    if($image_url !== ''){
      return '<img src="'.$image_url.'" class="avatar photo" width="'.$size.'" height="'.$size.'" />';
	}
  }
  return $avatar;
}

function orphan_parent_looking_for_relatives(){ 
	global $current_user;
	$captcha = create_captcha(); 
	$prefix = $captcha['prefix'];
	$file = $captcha['file'];

?>
	<section>
		<p class="title" data-section-title><a href="#panel1">Bố-Mẹ tìm con</a></p>
		<div class="content" data-section-content>
			<div data-alert="" class="show_message_error alert-box alert" style="display:none;margin:15px 0 10px 0; padding:5px;" id="message_error_container_parent"></div>
			<form class="custom" action="#" method="POST" id="lfr_parent_form" onsubmit="parent_looking_for_children()">
				<input type="hidden" name="action" value="1" />
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo $current_user->display_name; ?>" readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-name" id="txt-name" placeholder="Nhập họ tên" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-email" class="inline">Email <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo $current_user->user_email; ?>"  readonly="readonly"  style="margin:0px 0 4px 0;" type="text" name="txt-email" id="txt-email" placeholder="Nhập email" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-phone" class="inline">Điện thoại di động <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo get_user_meta($current_user->ID, "phone", true); ?>"  readonly="readonly"  style="margin:0px 0 4px 0;" type="text" name="txt-phone" id="txt-phone" placeholder="Nhập điện thoại di động" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-address" class="inline">Địa chỉ <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input  value="<?php echo get_user_meta($current_user->ID, "address", true); ?>"  readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-address" id="txt-address" placeholder="Nhập địa chỉ liên lạc" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-job" class="inline">Nghề nghiệp <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo get_user_meta($current_user->ID, "job", true); ?>"   readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-job" id="txt-job" placeholder="Nhập nghề nghiệp" />
					</div>
					<div class="small-3 columns"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label for="url-photo" class="inline">Hình ảnh</label>
					</div>							
					<div class="small-6 columns">
						<input type="text" name="url-photo" placeholder="Nhập url hình ảnh"  id="url-photo" value="" class="inline" size="50"/>
						<a href="#_upload" data="url-photo" class="button upload_image_button prefix" style="z-index:1">Đăng hình ảnh</a>
					</div>
					<div class="small-3 columns">
						<img style="border:1px solid #d5d5d5;" id="image_url-photo" width="80" src="<?php echo get_template_directory_uri();  ?>/images/no-avatar.png"/>
					</div>						
				</div>

				<div class="panel">
					<center><h6> Thông tin tìm con(thông tin lúc thất lạc): </h4></center>
					<hr />
					<div class="row">
						<div class="large-3 columns">
							<label for="txt-children_name" class="inline">Tên con<span class="require">*</span></label>								
						</div>
						<div class="large-9 columns" style="margin-bottom: 15px;">
							<input style="margin:0px 0 4px 0;" type="text" name="txt-children_name" id="txt-children_name" placeholder="Nhập tên con" />
						</div>
					</div>
					<div class="row">
						<div class="large-3 columns">
							<label for="txt-children_birthday" class="inline">Tuổi(hiện nay)<span class="require">*</span></label>								
						</div>
						<div class="large-9 columns" style="margin-bottom: 15px;">
							<input style="margin:0px 0 4px 0;" type="text" name="txt-children_birthday" id="txt-children_birthday" placeholder="Nhập tuôi(hiện nay)" />
						</div>
					</div>
					<div class="row">
						<div class="small-3 columns">
							<label class="inline">Giới tính</label>
						</div>
						
						<div class="small-2 columns">
							<label for="txt-children_gender" class="inline">
							<input type="radio" style="display:none;" name="txt-children_gender" id="txt-children_gender1" value="Nam" checked="checked" /> Nam</label>
						</div>
						<div class="small-7 columns">
							<label for="txt-children_gender2" class="inline"><input type="radio" style="display:none;" name="txt-children_gender" id="txt-children_gender2" value="Nữ" /> Nữ</label>
						</div>							
					</div>
					<div class="row">
						<div class="small-3 columns">
							<label for="url-children_photo" class="inline">Hình ảnh</label>
						</div>							
						<div class="small-6 columns">
							<input type="text" name="url-children_photo" placeholder="Nhập url hình ảnh"  id="url-children_photo" value="" class="inline" size="50"/>
							<a href="#_upload" data="url-children_photo" class="button upload_image_button prefix" style="z-index:1">Đăng hình ảnh</a>
						</div>
						<div class="small-3 columns">
							<img style="border:1px solid #d5d5d5;" id="image_url-children_photo" width="80" src="<?php echo get_template_directory_uri();  ?>/images/no-avatar.png"/>
						</div>						
					</div>
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-children_time_lost" class="inline">Thời gian thất lạc<span class="require">*</span></label>
						</div>
						<div class="small-6 columns"  style="margin-bottom: 15px;">
						  <input style="margin:0px 0 4px 0;" type="text" name="txt-children_time_lost" id="txt-children_time_lost" placeholder="Nhập thời gian thất lạc"/>
						</div>
						<div class="small-3 columns"></div>
					</div>
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-children_clothing" class="inline">Quần áo lúc thất lạc<span class="require">*</span></label>
						</div>
						<div class="small-9 columns"  style="margin-bottom: 15px;">
						  <input style="margin:0px 0 4px 0;" type="text" name="txt-children_clothing" id="txt-children_clothing" placeholder="Nhập quần áo lúc thất lạc" />
						</div>
					</div>
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-children_place_lost" class="inline">Địa điểm thất lạc</label>
						</div>
						<div class="small-9 columns"  style="margin-bottom: 15px;">
						  <input style="margin:0px 0 4px 0;" type="text" name="txt-children_place_lost" id="txt-children_lost_address" placeholder="Nhập địa điểm thất lạc" />
						</div>
					</div>
					<div class="row">
						<div class="large-3 columns">
							<label for="txt-content" class="inline">Đặc điểm chung</label>								
						</div>
						<div class="large-12 columns" style="margin-bottom: 15px;">
							<?php 
								$field = 'children_description';
								 $settings = array(
									'textarea_name' => $field,
									'textarea_rows' => 5,
									'media_buttons' => false,
									'tinymce' => array(
										'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
											'bullist,blockquote,|,justifyleft,justifycenter' .
											',justifyright,justifyfull,|,link,unlink,|' .
											',spellchecker,wp_fullscreen,wp_adv'
									)
								);
								wp_editor( '', $field, $settings );
							?>
							<label style="padding: 5px 0px 0px;">Miêu tả thông tin chi tiết để chúng tôi phân tích và gởi thông tin cho quí khách.</label>
						</div>
					</div>
										
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-captcha" class="inline">Mã bảo mật <span class="require">*</span></label>
						</div>
						<div class="small-9 columns" style="margin-bottom: 15px;">
						  <div class="left"><input style="margin:0px 0 4px 0;" type="text" style="width:100px;" name="txt-captcha" id="txt-captcha" placeholder="Mã bảo mật"></div>
						  <div class="left" style="margin-top:1px;"> &nbsp; <img style="padding:0px; margin:0px 0 4px 0;" id="captcha_file" src="<?php echo $file; ?>" /></div>
						  <input type="hidden" name="captcha_prefix" id="captcha_prefix" value="<?php echo $prefix; ?>" />
						</div>
					</div>
				</div>						
				<div class="row">
					<div class="large-12 columns text-center">
						<button id="submit_parent_looking_for_children">Đăng thông tin</button>
					</div>
				</div>
			</form>
			<script type="text/javascript">
				jQuery(function($){				
					$("#submit_parent_looking_for_children").click(function(){parent_looking_for_children();return false;});
				
					var check_parent_looking_for_children = $('#lfr_parent_form').bind("invalid-form.validate", function() {
						 $("#message_error_container_parent").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.").show();
					 }).validate({
						rules:{
							'txt-name': "required",
							'txt-email': {
								required: true,
								email: true
							},
							'txt-phone': {
								required: true,
								number: true,
								minlength: 10,
								maxlength: 12
							},
							'txt-address': "required",
							'txt-job': "required",
							'txt-children_name': "required",
							'txt-children_birthday': {
								required: true,
								number: true,
								min:1,
								max:18
							},
							'txt-children_time_lost': "required",
							'txt-children_clothing' : "required",
							'txt-children_place_lost' : "required",
							'txt-captcha': {
								required:true,
								minlength:4,
								maxlength:4
							}
						},
						messages: {
							'txt-name': "Nhập họ tên bố-mẹ.",
							'txt-email': {
								required: 'Nhập địa chỉ email.',
								email: 'Địa chỉ email không hợp lệ.'
							},
							'txt-phone': {
								required: 'Nhập điện thoại.',
								number: 'Nhập chữ số.',
								minlength: 'Số điện thoại tối thiểu 8 chữ số',
								maxlength: 'Số điện thoại lớn nhất 12 chữ số'
							},
							'txt-address': "Nhập địa chỉ của bố-mẹ.",
							'txt-job': "Nhập nghề nghiệp của bố mẹ.",
							'txt-children_name': "Nhập tên con",
							'txt-children_birthday': {
								required: 'Nhập tuổi của trẻ em.',
								number: 'Nhập chữ số.',
								min: 'Tuổi ít nhất 1 tuổi',
								max: 'Tuổi lớn nhất bằng 18 tuổi.'
							},
							'txt-children_time_lost': 'Nhập thời gian thất lạc',
							'txt-children_clothing' : "Áo quần lúc lạc",
							'txt-children_place_lost' : "Địa điểm lúc lạc",
							'txt-captcha': {
								required:"Nhập mã bảo mật.",
								minlength: 'Mã bảo mật 4 ký tự.',
								maxlength: 'Mã bảo mật 4 ký tự.'
							}
						},
						wrapper : 'div',
						debug: false
					  });
					
					function parent_looking_for_children(){
						var content;
						inputid = 'children_description';
						var editor = tinyMCE.get(inputid);
						if (editor) {
							// Ok, the active tab is Visual
							content = editor.getContent();
						} else {
							// The active tab is HTML, so just query the textarea
							content = $('#'+inputid).val();
						}
						jQuery('form#lfr_parent_form textarea#'+inputid).html(content);
						if(check_parent_looking_for_children.form()){
							jQuery.ajax({  
								type: 'POST',  
								url: ajaxurl,  
								data: {  
									action: 'ajax_insert_parent_looking_for_children',  
									data_from : $("form#lfr_parent_form").serialize()
								},   
								dataType: 'json',
								beforeSend: function(){
									jQuery('div.message_overflow').fadeIn();
								},
								success: function(response){ 
									if(response.status_login == 'true'){
										if(response.status == 'true'){
											$("#message_error_container_parent").text(response.message);
											$("#message_error_container_parent").show();
											jQuery('div.message_overflow strong.info').html(response.message).fadeIn();
											//alert(response.message);
											$("#submit_parent_looking_for_children").attr('disabled', 'disabled');
											setTimeout(function() {
												window.location = url_home+'/bo-me-tim-con';
										   }, 3000);
										}
										else{											
											jQuery('div.message_overflow').fadeOut();
											$("#message_error_container_parent").text(response.message);
											$("#message_error_container_parent").show();
											if(response.captcha_error == 'true'){
												$('form#lfr_parent_form input#txt-captcha').val('');
												$('form#lfr_parent_form img#captcha_file').attr('src', response.captcha_file).fadeIn();
												$('form#lfr_parent_form input#captcha_prefix').val(response.captcha_prefix);
											}
										}
									} 
									else{
										jQuery('a#tmc_login_button').click();
									}
								}
							}); 
						}
					}
				});
			
				</script>
				<style>
					#children_description_ifr{background:#fff;}
				</style>
		</div>
	  </section>
	
<?php }

    function orphan_meta_box_parent_tnt_to_manage_post($column_name, $post_id) {
		global $orphan_prefix, $orphan_fields_parent_tnt_children_array;
		$get_post = get_post($post_id, ARRAY_A);
		if($column_name == 'parent_photo'){
			$photo = get_avatar(  $get_post['post_author'], 60 );
			//$photo = get_user_meta($get_post['post_author'], "user_avatars", true);
			echo $photo;
		} else if($column_name == 'children_photo'){
			$photo =  get_post_meta($post_id, $orphan_prefix.$column_name, true);
			if($photo){
				echo ('<img width="60" height="60" src="'.$photo.'"/>');
			}
		} else if($column_name == 'parent_info'){
			
			if($get_post && isset($get_post['post_author'])){
				$html = '';
				$get_userdata =  get_userdata( $get_post['post_author'] ); 
				$html .= '<li>Tên bố/mẹ : '.$get_userdata->display_name.'</li>';
				$phone = get_user_meta($get_post['post_author'], "phone", true);
				if($phone){
					$html .= '<li>Điện thoại : '.$phone.'</li>';
				}
				if(isset($get_userdata->user_email)){
					$html .= '<li>Email : '.$get_userdata->user_email.'</li>';
				}
				$address = get_user_meta($get_post['post_author'], "address", true);
				if($address){
					$html .= '<li>Địa chỉ : '.$address.'</li>';
				}
				if($html != ''){
					echo '<ul>'.$html.'</ul>';
				}
			}
		} else if($column_name == 'children_info'){
			$html = '';
			$children_name = get_post_meta($post_id, $orphan_prefix.'children_name', true);
			if($children_name){
				$html .= '<li>Tên con : '.$children_name.'</li>';
			}

			$children_time_lost = get_post_meta($post_id, $orphan_prefix.'children_time_lost', true);
			if($children_time_lost){
				$html .= '<li>Thời gian lạc : '.$children_time_lost.'</li>';
			}
			$children_place_lost = get_post_meta($post_id, $orphan_prefix.'children_place_lost', true);
			if($children_place_lost){
				$html .= '<li>Nơi lạc : '.$children_place_lost.'</li>';
			}
			if($html != ''){
				echo '<ul>'.$html.'</ul>';
			}
			
		} else {
			echo  get_post_meta($post_id, $orphan_prefix.$column_name, true);
		}
    }

function orphan_add_new_parent_tnt_manage_columns($my_columns) {
	global $orphan_prefix, $orphan_fields_parent_tnt_children_array;
	$new_my_columns['cb'] = '<input type="checkbox" />';	 
	$new_my_columns['title'] = __('Họ tên con');
	$new_my_columns['children_photo'] = __('Hình ảnh con');		
	$new_my_columns['children_info'] = __('Thông tin con');
	$new_my_columns['parent_photo'] = __('Hình ảnh bố/mẹ');
	$new_my_columns['parent_info'] = __('Thông tin bố mẹ');	
	$new_my_columns['date'] = __('Ngày đăng');		
	return $new_my_columns;
}
// Add to admin_init function $post_type_parent_tnt
if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == $post_type_parent_tnt){
	add_filter('manage_posts_columns', 'orphan_add_new_parent_tnt_manage_columns');
	add_action('manage_posts_custom_column', 'orphan_meta_box_parent_tnt_to_manage_post', 10, 2);
}


 /*Children looking for parent */
global $orphan_prefix;
$orphan_prefix = 'orphan_';
global $post_type_children_tnt, $post_type_children_tnt_label;
$post_type_children_tnt = 'con-tim-bo-me';
$post_type_children_tnt_label = 'Con tìm bố mẹ';
function orphan_register_children_tnt() { 
	global $post_type_children_tnt, $post_type_children_tnt_label;
	$label = $post_type_children_tnt_label;
	$post_type_tnt = $post_type_children_tnt;
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
 
	$supports = array('title'); 
	$post_type_args = array(
		'labels' => $labels, 
		'singular_label' => __($label),
		'public' => true, 'show_ui' => true, 
		'publicly_queryable'=> true, 
		'query_var' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => $post_type_tnt),
		'supports' => $supports,
		'menu_position' => 5,
		'menu_icon' => get_bloginfo('template_directory').'/images/family.png'
	);
	register_post_type( $post_type_tnt,$post_type_args);
 } 
add_action('init', 'orphan_register_children_tnt');

/* Begin Info children  looking for parent */
global $orphan_fields_children_tnt_parent_array;
global $orphan_save_meta_post;
$orphan_fields_children_tnt_parent_array = array(
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_name',
			'label'			=> 'Tên con',
			'description' 	=> 'Nhập nhập tên con',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_birthday',
			'label'			=> 'Tuổi(hiện nay)',
			'description' 	=> 'Nhập tuổi hiện nay',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_gender',
			'label'			=> 'Giới tính',
			'description' 	=> 'Chọn giới tính của trẻ',
			'type'			=> 'radio',
			'rich_editor'	=> false,
			'options'		=> array(
				'Nam',
				'Nữ'
			)
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_time_lost',
			'label'			=> 'Thời gian thất lạc',
			'description' 	=> 'Nhập thời gian thất lạc',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_clothing',
			'label'			=> 'Quần áo lúc thất lạc',
			'description' 	=> 'Nhập quần áo lúc thất lạc',
			'type'			=> 'text',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_place_lost',
			'label'			=> 'Địa điểm thất lạc',
			'description' 	=> 'Nhập địa điểm thất lạc',
			'type'			=> 'textarea',
			'rich_editor'	=> false,
			'options'		=> null
		)
	),
	orphan_result_meta_tnt(
		array(
			'name' 			=> 'children_description',
			'label'			=> 'Đặc điểm chung',
			'description' 	=> 'Nhập đặc điểm chung',
			'type'			=> 'textarea',
			'rich_editor'	=> true,
			'options'		=> null
		)
	)
);

$orphan_save_meta_post[] = $orphan_fields_children_tnt_parent_array;
function orphan_fields_children_tnt_parent_array(){
 global $orphan_fields_children_tnt_parent_array;
 return $orphan_fields_children_tnt_parent_array;
}
add_action('admin_menu', 'orphan_add_meta_box_children_tnt_parent');
function orphan_add_meta_box_children_tnt_parent(){
	global $orphan_prefix, $orphan_fields_children_tnt_parent_array, $post_type_children_tnt;
	
	$meta_box_fields = array(
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $orphan_fields_children_tnt_parent_array
	);
	add_meta_box($orphan_prefix.'metabox_bo_me_tim_con_2', 'Thông tin tìm con', 'orphan_show_meta_box', $post_type_children_tnt, 'advanced', 'default', $meta_box_fields);
}
function orphan_check_captcha($captcha = null){
	$result = array();
	$result['status'] = 'true';
	$result['captcha_prefix'] = '';
	$result['captcha_file'] = '';
	$result['message'] = '';
	if (!class_exists('ReallySimpleCaptcha')) {
		$result['status'] = 'false';
		$result['message'] = 'Class "ReallySimpleCaptcha" không tồn tại. Cài plugin : "really-simple-captcha" để tiếp tục';
	} else {
		$captcha_instance = new ReallySimpleCaptcha();
		if(!$captcha_instance->check( $captcha['captcha_prefix'], $captcha['txt-captcha'] )){
			$result['status'] = 'false';
		}
		$captcha_instance->remove( $prefix );
		if($result['status'] == 'false'){
			$captcha = create_captcha();
			$result['captcha_prefix'] =  $captcha['prefix'];
			$result['captcha_file'] =  $captcha['file'];
			$result['message'] = 'Mã bảo mật không chính xác';
		}
	}
	return $result;
}
add_action( 'wp_ajax_nopriv_ajax_insert_children_looking_for_parent', 'ajax_insert_children_looking_for_parent' );  
add_action( 'wp_ajax_ajax_insert_children_looking_for_parent', 'ajax_insert_children_looking_for_parent' );
function ajax_insert_children_looking_for_parent(){
	global $orphan_prefix, $current_user ,$post_type_children_tnt;
	$results['status_login'] = 'true';
	$results['message'] = 'Đã có lỗi trong quá trình nhập dữ liệu. Vui lòng thử lại sau';
	$results['status'] = 'false';
	$results['captcha_error'] = 'false';
	if(isset($current_user->ID)){
		$dataForm = array();
	   if(isset($_POST['data_from'])){
		parse_str($_POST['data_from'], $dataForm);
	   }
	   
	   $check_captcha = orphan_check_captcha($dataForm);
	   if($check_captcha['status'] == 'false'){
			$check_captcha['status_login'] = 'true';
			$check_captcha['captcha_error'] = 'true';
			$results = $check_captcha;
	   } else {
		   if(isset($dataForm['txt-name']) && isset($dataForm["txt-parent_name"])){
				//Update info user
				$user_id = $current_user->ID;
				$data_user_update = array();
				$data_user_update['ID'] = $user_id;
				if($dataForm['txt-email'] != ''){
					//$data_user_update['user_email'] = $dataForm['txt-email'];
				}
				if($dataForm['txt-name'] != ''){
					$data_user_update['display_name '] = $dataForm['txt-name'];
				}
				wp_update_user( $data_user_update) ;
				if($dataForm['txt-gender']!=''){
					update_usermeta( $user_id, 'gender', $dataForm['txt-gender']);
				}
				if($dataForm['txt-phone']!=''){
					update_usermeta( $user_id, 'phone', $dataForm['txt-phone']);
				}
				if($dataForm['url-photo']!=''){
					update_usermeta( $user_id, 'user_avatars', $dataForm['url-photo']);
				}
				if($dataForm['txt-address']!=''){
					update_usermeta( $user_id, 'address', $dataForm['txt-address']);
				}
				if($dataForm['txt-job']!=''){
					update_usermeta( $user_id, 'job', $dataForm['txt-job']);
				}
				
				
				$title = $title = $dataForm["txt-parent_name"];
				// Create post object
				$my_post = array(
				  'post_title'    => $title,
				  'post_type'    => $post_type_children_tnt,
				  'post_status'   => 'pending',
				  'post_author'   => $current_user->ID
				);
				// Insert the post into the database
				$post_id  = wp_insert_post( $my_post );
				//echo $post_id;
				if($post_id){
					if($dataForm["txt-parent_name"] !=''){
						add_post_meta( $post_id, $orphan_prefix.'parent_name', $dataForm["txt-parent_name"]);
					}
					if($dataForm["txt-parent_job"] !=''){
						add_post_meta( $post_id, $orphan_prefix.'parent_job', $dataForm["txt-parent_job"]);
					}
					if($dataForm["url-parent_photo"] !=''){
						add_post_meta( $post_id, $orphan_prefix.'parent_photo', $dataForm["url-parent_photo"]);
					}
					if($dataForm["txt-parent_time_lost"] !=''){
						add_post_meta( $post_id, $orphan_prefix.'parent_time_lost', $dataForm["txt-parent_time_lost"]);
					}
					if($dataForm["txt-parent_place_lost"] !=''){
						add_post_meta( $post_id, $orphan_prefix.'parent_place_lost', $dataForm["txt-parent_place_lost"]);
					}
					if($dataForm["parent_description"] !=''){
						add_post_meta( $post_id, $orphan_prefix.'parent_description', $dataForm["parent_description"]);
					}
					
					$results['status'] = 'true';
					$results['message'] = 'Nhập dữ liệu thành công. Hệ thống sẽ tự chuyển về trang chủ sau 3 giây.';
				} else {
					$results['message'] = 'Đăng thông tin không thành công hãy thử lại.';
				}
			}else{
				$results['message'] = 'Nhập tên của bố-mẹ.';
			}
		}
	} else
	{
		$results['status_login'] = 'false';
		$results['message'] = 'Hãy đăng nhập để tiếp tục nhập dữ liệu';
	}
	die(orphan_get_json($results));
}

function orphan_children_looking_for_relatives(){ 
	global $current_user;
	$captcha = create_captcha(); 
	$prefix = $captcha['prefix'];
	$file = $captcha['file'];

?>
	<section>
		<p class="title" data-section-title><a href="#panel1">Con tìm bố mẹ</a></p>
		<div class="content" data-section-content>
			<div data-alert="" class="show_message_error alert-box alert" style="display:none;margin:15px 0 10px 0; padding:5px;" id="message_error_container_children"></div>
			<form class="custom" action="#" method="POST" id="lfr_children_form" onsubmit="children_looking_for_parent()">
				<input type="hidden" name="action" value="1" />
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo $current_user->display_name; ?>"  readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-name" id="txt-name" placeholder="Nhập họ tên" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label class="inline">Giới tính</label>
					</div>
					
					<div class="small-2 columns">
						<label for="txt-children_gender3" class="inline">
						<input type="radio" style="display:none;" name="txt-gender"  readonly="readonly" id="txt-children_gender3" value="Nam" checked="checked" /> Nam</label>
					</div>
					<div class="small-7 columns">
						<label for="txt-children_gender4" class="inline"><input type="radio"  readonly="readonly" style="display:none;" name="txt-gender" id="txt-children_gender4" value="Nữ" /> Nữ</label>
					</div>							
				</div>
				<div class="row">
					<div class="large-3 columns">
						<label for="txt-birthday" class="inline">Tuổi(hiện nay)</label>								
					</div>
					<div class="large-6 columns" style="margin-bottom: 15px;">
						<input style="margin:0px 0 4px 0;" type="text" name="txt-birthday"  readonly="readonly" id="txt-birthday" placeholder="Nhập tuôi(hiện nay)" />
					</div>
					<div class="large-3 columns"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-email" class="inline">Email <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo $current_user->user_email; ?>"   readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-email" id="txt-email" placeholder="Nhập email" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-phone" class="inline">Điện thoại di động <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo get_user_meta($current_user->ID, "phone", true); ?>"  readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-phone" id="txt-phone" placeholder="Nhập điện thoại di động" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-address" class="inline">Địa chỉ <span class="require">*</span></label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input  value="<?php echo get_user_meta($current_user->ID, "address", true); ?>"  readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-address" id="txt-address" placeholder="Nhập địa chỉ liên lạc" />
					</div>
					<div class="small-3 columns"  style="margin-bottom: 15px;"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
					  <label for="txt-job" class="inline">Nghề nghiệp </label>
					</div>
					<div class="small-6 columns"  style="margin-bottom: 15px;">
					  <input value="<?php echo get_user_meta($current_user->ID, "job", true); ?>"   readonly="readonly" style="margin:0px 0 4px 0;" type="text" name="txt-job" id="txt-job" placeholder="Nhập nghề nghiệp" />
					</div>
					<div class="small-3 columns"></div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label for="url-photo" class="inline">Hình ảnh</label>
					</div>							
					<div class="small-6 columns">
						<input type="text" name="url-photo" placeholder="Nhập url hình ảnh"  id="url-photo" value="" class="inline" size="50"/>
						<a href="#_upload" data="url-photo" class="button upload_image_button prefix" style="z-index:1">Đăng hình ảnh</a>
					</div>
					<div class="small-3 columns">
						<img style="border:1px solid #d5d5d5;" id="image_url-photo" width="80" src="<?php echo get_template_directory_uri();  ?>/images/no-avatar.png"/>
					</div>						
				</div>

				<div class="panel">
					<center><h6> Thông tin tìm bố mẹ(thông tin lúc thất lạc): </h4></center>
					<hr />
					<div class="row">
						<div class="large-3 columns">
							<label for="txt-parent_name" class="inline">Tên bố/mẹ</label>								
						</div>
						<div class="large-9 columns" style="margin-bottom: 15px;">
							<input style="margin:0px 0 4px 0;" type="text" name="txt-parent_name" id="txt-parent_name" placeholder="Nhập tên bố/mẹ" />
						</div>
					</div>
					
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-parent_job" class="inline">Nghề nghiệp</label>
						</div>
						<div class="small-9 columns"  style="margin-bottom: 15px;">
						  <input value=""  style="margin:0px 0 4px 0;" type="text" name="txt-job" id="txt-job" placeholder="Nhập nghề nghiệp" />
						</div>
					</div>
					<div class="row">
						<div class="small-3 columns">
							<label for="url-parent_photo" class="inline">Hình ảnh</label>
						</div>							
						<div class="small-6 columns">
							<input type="text" name="url-parent_photo" placeholder="Nhập url hình ảnh"  id="url-parent_photo" value="" class="inline" size="50"/>
							<a href="#_upload" data="url-parent_photo" class="button upload_image_button prefix" style="z-index:1">Đăng hình ảnh</a>
						</div>
						<div class="small-3 columns">
							<img style="border:1px solid #d5d5d5;" id="image_url-parent_photo" width="80" src="<?php echo get_template_directory_uri();  ?>/images/no-avatar.png"/>
						</div>						
					</div>
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-parent_time_lost" class="inline">Thời gian thất lạc</label>
						</div>
						<div class="small-6 columns"  style="margin-bottom: 15px;">
						  <input style="margin:0px 0 4px 0;" type="text" name="txt-parent_time_lost" id="txt-parent_time_lost" placeholder="Nhập thời gian thất lạc"/>
						</div>
						<div class="small-3 columns"></div>
					</div>
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-parent_place_lost" class="inline">Địa điểm thất lạc</label>
						</div>
						<div class="small-9 columns"  style="margin-bottom: 15px;">
						  <input style="margin:0px 0 4px 0;" type="text" name="txt-parent_place_lost" id="txt-parent_place_lost" placeholder="Nhập địa điểm thất lạc" />
						</div>
					</div>
					<div class="row">
						<div class="large-3 columns">
							<label for="txt-content" class="inline">Đặc điểm chung</label>								
						</div>
						<div class="large-12 columns" style="margin-bottom: 15px;">
							<?php 
								$field = 'parent_description';
								 $settings = array(
									'textarea_name' => $field,
									'textarea_rows' => 5,
									'media_buttons' => false,
									'tinymce' => array(
										'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
											'bullist,blockquote,|,justifyleft,justifycenter' .
											',justifyright,justifyfull,|,link,unlink,|' .
											',spellchecker,wp_fullscreen,wp_adv'
									)
								);
								wp_editor( '', $field, $settings );
							?>
							<label style="padding: 5px 0px 0px;">Miêu tả thông tin chi tiết để chúng tôi phân tích và gởi thông tin cho quí khách.</label>
						</div>
					</div>
										
					<div class="row">
						<div class="small-3 columns">
						  <label for="txt-captcha" class="inline">Mã bảo mật <span class="require">*</span></label>
						</div>
						<div class="small-9 columns" style="margin-bottom: 15px;">
						  <div class="left"><input style="margin:0px 0 4px 0;" type="text" style="width:100px;" name="txt-captcha" id="txt-captcha" placeholder="Mã bảo mật"></div>
						  <div class="left" style="margin-top:1px;"> &nbsp; <img style="padding:0px; margin:0px 0 4px 0;" id="captcha_file" src="<?php echo $file; ?>" /></div>
						  <input type="hidden" name="captcha_prefix" id="captcha_prefix2" value="<?php echo $prefix; ?>" />
						</div>
					</div>
				</div>						
				<div class="row">
					<div class="large-12 columns text-center">
						<button id="submit_children_looking_for_parent">Đăng thông tin</button>
					</div>
				</div>
			</form>
			<script type="text/javascript">
				jQuery(function($){
					$('#txt-birthday').datepicker({
						dateFormat:'d/m/yy',
						maxDate: new Date,
						yearRange: "-90:+0",
						changeMonth: true, 
						changeYear: true
					});
					$("#submit_children_looking_for_parent").click(function(){children_looking_for_parent();return false;});
				
					var check_children_looking_for_parent = $('#lfr_children_form').bind("invalid-form.validate", function() {
						 $("#message_error_container_children").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.").show();
					 }).validate({
						rules:{
							'txt-name': "required",
							'txt-birthday': {
								required: true
							},
							'txt-email': {
								required: true,
								email: true
							},
							'txt-phone': {
								required: true,
								number: true,
								minlength: 10,
								maxlength: 12
							},
							'txt-address': "required",
							//'txt-job': "required",
							'txt-parent_name': "required",
							'txt-parent_job': {
								minlength : 2
							},
							'txt-captcha': {
								required:true,
								minlength:4,
								maxlength:4
							}
						},
						messages: {
							'txt-name': "Nhập họ tên con.",
							'txt-email': {
								required: 'Nhập địa chỉ email.',
								email: 'Địa chỉ email không hợp lệ.'
							},
							'txt-birthday': {
								required: 'Nhập tuổi của trẻ em.'
							},
							'txt-phone': {
								required: 'Nhập điện thoại.',
								number: 'Nhập chữ số.',
								minlength: 'Số điện thoại tối thiểu 8 chữ số',
								maxlength: 'Số điện thoại lớn nhất 12 chữ số'
							},
							'txt-address': "Nhập địa chỉ của con.",
							//'txt-job': "Nhập nghề nghiệp của con.",
							'txt-parent_name': "Nhập tên bố mẹ",
							'txt-parent_job':{
								minlength : 'Nghề nghiệp lớn hơn 2 ký tự'
							},
							'txt-captcha': {
								required:"Nhập mã bảo mật.",
								minlength: 'Mã bảo mật 4 ký tự',
								maxlength: 'Mã bảo mật 4 ký tự'
							}
						},
						wrapper : 'div',
						debug: false
					  });
					
					function children_looking_for_parent(){
						var content;
						inputid = 'parent_description';
						var editor = tinyMCE.get(inputid);
						if (editor) {
							// Ok, the active tab is Visual
							content = editor.getContent();
						} else {
							// The active tab is HTML, so just query the textarea
							content = $('#'+inputid).val();
						}
						jQuery('form#lfr_children_form textarea#'+inputid).html(content);
						if(check_children_looking_for_parent.form()){
							jQuery.ajax({  
								type: 'POST',  
								url: ajaxurl,  
								data: {  
									action: 'ajax_insert_children_looking_for_parent',  
									data_from : $("form#lfr_children_form").serialize()
								},   
								dataType: 'json',
								beforeSend: function(){
									jQuery('div.message_overflow').fadeIn();
								},
								success: function(response){ 
									
									if(response.status_login == 'true'){
										if(response.status == 'true'){
											$("#message_error_container_children").text(response.message);
											$("#message_error_container_children").show();
											jQuery('div.message_overflow strong.info').html(response.message).fadeIn();
											//alert(response.message);
											$("#submit_children_looking_for_parent").attr('disabled', 'disabled');
											setTimeout(function() {
												window.location = url_home+'/con-tim-bo-me';
										   }, 3000);
										} else{ 
											jQuery('div.message_overflow').fadeOut();
											$("#message_error_container_children").text(response.message);
											$("#message_error_container_children").show();
											if(response.captcha_error == 'true'){
												$('form#lfr_children_form input#txt-captcha').val('');
												$('form#lfr_children_form img#captcha_file').attr('src', response.captcha_file).fadeIn();
												$('form#lfr_children_form input#captcha_prefix2').val(response.captcha_prefix);
											}
										}
									} 
									else{
										jQuery('a#tmc_login_button').click();
									}
								}
							}); 
						}
					}
				});
			
				</script>
				<style>
					#parent_description_ifr{background:#fff;}
				</style>
		</div>
	  </section>
	
<?php }

    function orphan_meta_box_children_tnt_to_manage_post($column_name, $post_id) {
		global $orphan_prefix, $orphan_fields_info_array;
		$get_post = get_post($post_id, ARRAY_A);
		if($column_name == 'parent_photo'){
			$meta_values =   get_post_meta($post_id, $orphan_prefix.$column_name, true);
			if($meta_values){
				echo ('<img width="60" height="60" src="'.$meta_values.'"/>');
			}
		} else if($column_name == 'children_photo'){
			$photo = get_avatar(  $get_post['post_author'], 60 );
			//$photo = get_user_meta($get_post['post_author'], "user_avatars", true);
			echo $photo;
		} else if($column_name == 'children_info'){
			
			if($get_post && isset($get_post['post_author'])){
				$html = '';
				$get_userdata =  get_userdata( $get_post['post_author'] ); 
				$user_name = $get_userdata->display_name;
				if($user_name){
					$html .= '<li>Tên con : '.$user_name.'</li>';
				}
				$gender = get_user_meta($get_post['post_author'], "gender", true);
				if($gender){
					$html .= '<li>Giới tính : '.$gender.'</li>';
				}
				$phone = get_user_meta($get_post['post_author'], "phone", true);
				if($phone){
					$html .= '<li>Điện thoại : '.$phone.'</li>';
				}
				if(isset($get_userdata->user_email)){
					$html .= '<li>Email : '.$get_userdata->user_email.'</li>';
				}
				$address = get_user_meta($get_post['post_author'], "address", true);
				if($address){
					$html .= '<li>Địa chỉ : '.$address.'</li>';
				}
				if($html != ''){
					echo '<ul>'.$html.'</ul>';
				}
			}
		} else if($column_name == 'parent_info'){
			$html = '';
			$parent_name = get_post_meta($post_id, $orphan_prefix.'parent_name', true);
			if($parent_name){
				$html .= '<li>Tên Bố/Mẹ : '.$parent_name.'</li>';
			}
			$parent_job = get_post_meta($post_id, $orphan_prefix.'parent_job', true);
			if($parent_job){
				$html .= '<li>Nghề nghiệp : '.$parent_job.'</li>';
			}
			$parent_time_lost = get_post_meta($post_id, $orphan_prefix.'parent_time_lost', true);
			if($parent_time_lost){
				$html .= '<li>Thời gian lạc : '.$parent_time_lost.'</li>';
			}
			$parent_place_lost = get_post_meta($post_id, $orphan_prefix.'parent_place_lost', true);
			if($parent_place_lost){
				$html .= '<li>Nơi lạc : '.$parent_place_lost.'</li>';
			}
			if($html != ''){
				echo '<ul>'.$html.'</ul>';
			}
			
		} else {
			echo  get_post_meta($post_id, $orphan_prefix.$column_name, true);
		}
    }

function orphan_add_new_children_tnt_manage_columns($my_columns) {
	global $orphan_prefix, $orphan_fields_info_array;
	$new_my_columns['cb'] = '<input type="checkbox" />';	 
	$new_my_columns['title'] = __('Họ tên bố/mẹ');
	$new_my_columns['parent_photo'] = __('Hình ảnh Bố/Mẹ');	
	$new_my_columns['parent_info'] = __('Thông tin bố mẹ');
	$new_my_columns['children_photo'] = __('Hình ảnh con');
	$new_my_columns['children_info'] = __('Thông tin con');		
	$new_my_columns['date'] = __('Ngày đăng');		
	return $new_my_columns;
}
// Add to admin_init function $post_type_children_tnt
if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == $post_type_children_tnt){
	add_filter('manage_posts_columns', 'orphan_add_new_children_tnt_manage_columns');
	add_action('manage_posts_custom_column', 'orphan_meta_box_children_tnt_to_manage_post', 10, 2);
}

/* Children looking for parent */
 ?>