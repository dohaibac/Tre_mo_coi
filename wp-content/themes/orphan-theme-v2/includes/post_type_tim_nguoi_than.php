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
				update_usermeta( $user_id, 'status_sendmail_tnt', true);
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
/* Mapping info parent loooking for chilren */

function orphan_maping_parent_with_children(){
	global $post_type_parent_tnt, $post_type_children_tnt;
	//get all post type : bo-me-tim-con
	$args = array(
		'post_type' => $post_type_parent_tnt,
		'post_status' => array(
			'publish',
			'pending',
			'future',
			'private'
		),
		'order'	=>'DESC',
		'posts_per_page' => -1,
		'caller_get_posts'=> 1
	);
	$the_query_parent_looking_for = new WP_Query();
	$the_query_parent_looking_for->query($args);
	// The Loop
	if ( $the_query_parent_looking_for->have_posts() ) :
		while ( $the_query_parent_looking_for->have_posts() ) : $the_query_parent_looking_for->the_post();
			//get children with conditions
			$info_children = array();
			$meta_query = array();
			$user_id = get_the_author_meta( 'ID' );
			if(get_user_meta($user_id, "status_sendmail_tnt", true) == true){
				$get_userdata =  get_userdata($user_id ); 
				$info_parent = array();
				$info_parent['name'] = $get_userdata->display_name;
				$info_parent['phone'] = get_user_meta($user_id, "phone", true);
				$info_parent['email'] = $get_userdata->user_email;
				$info_parent['subject'] = 'Thông tin tìm người thân';
				$info_parent['sender'] = 'Kính gởi Ông/Bà: '.$info_parent['parent_name'];		
				$code = base64_encode($user_id."|".md5($user_id.$get_userdata->user_email."aJ#FTUkk"));
				$info_children['mailing_cancel']	= $code;					
				if(get_post_meta( get_the_ID(), 'orphan_children_name', true )){
					$meta_query[] = array(
						'key'     => 'display_name',
						'value'   => get_post_meta( get_the_ID(), 'orphan_children_name', true ),
						'compare' => 'LIKE'
					);
				}
				
				if(get_post_meta( get_the_ID(), 'orphan_children_birthday', true )){
					$info_children['children_birthday'] = get_post_meta( get_the_ID(), 'orphan_children_birthday', true );
					$meta_query[] = array(
						'key'     => 'birthday',
						'value'   => get_post_meta( get_the_ID(), 'orphan_children_birthday', true ),
						'compare' => 'LIKE'
					);
				}
				
				if(get_post_meta( get_the_ID(), 'orphan_children_gender', true )){
					$info_children['children_gender'] = get_post_meta( get_the_ID(), 'orphan_children_gender', true );
					$meta_query[] = array(
						'key'     => 'gender',
						'value'   => get_post_meta( get_the_ID(), 'orphan_children_gender', true ),
						'compare' => '='
					);
				}
				
				if($meta_query){
					$meta_query['relation'] = 'OR';
					if(get_post_meta( get_the_ID(), 'orphan_children_time_lost', true )){
						$info_children['children_time_lost'] = get_post_meta( get_the_ID(), 'orphan_children_time_lost', true );
					}
					
					if(get_post_meta( get_the_ID(), 'orphan_children_place_lost', true )){
						$info_children['children_place_lost'] = get_post_meta( get_the_ID(), 'orphan_children_place_lost', true );
					}
					

					$args_meta_user_query = array(
						'meta_query' => $meta_query
					);
					$user_query = new WP_User_Query( $args_meta_user_query );
					$result_users = $user_query->get_results();
					if($result_users ){
						$id_users = array();
						foreach($result_users  as $user_info){
							$id_users[$user_info->ID] = $user_info->ID;
						}
						if($id_users){
							$str_id_user = implode(',',$id_users);
							$args = array();
							$args = array(
								'post_type' => $post_type_children_tnt,
								'author' => $str_id_user,
								'order'	=>'DESC',
								'post_status' => array(
									'publish',
									'pending',
									'future',
									'private'
								),
								'posts_per_page' => -1,
								'caller_get_posts'=> 1
							);
							
							$children_meta_query = array();
							if(isset($info_children['children_time_lost'] )){
								$children_meta_query[] = array(
									'key'   => 'orphan_parent_time_lost',
									'value' => $info_children['children_time_lost'],
									'compare' => "LIKE"
								);
							}
							if(isset($info_children['children_place_lost'] )){
								$children_meta_query[] = array(
									'key'   => 'orphan_parent_place_lost',
									'value' => $info_children['children_place_lost'],
									'compare' => "LIKE"
								);
							}
							if($children_meta_query){
								$children_meta_query['relation'] = 'AND';
								$args['meta_query'] = $children_meta_query;
							}
							$children_query = new WP_Query( $args );
							if ( $children_query->have_posts() ) : 
								$args_children = array();
								$i=0;
								while ( $children_query->have_posts() ) : $children_query->the_post();
									$user_id = get_the_author_meta( 'ID' );
									$get_userdata =  get_userdata($user_id ); 
									$args_children[$i]['link'] = get_permalink();
									if(isset($get_userdata->display_name)){
										$args_children[$i]['name'] = $get_userdata->display_name;
									}
									if(isset($get_userdata->user_email)){
										$args_children[$i]['email'] = $get_userdata->user_email;
									}
									if(get_user_meta($user_id, "address", true)){
										$args_children[$i]['address'] = get_user_meta($user_id, "address", true);
									}
									if(get_user_meta($user_id, "phone", true)){
										$args_children[$i]['phone'] = get_user_meta($user_id, "phone", true);
									}
									$args_children[$i]['avatar'] = get_avatar( get_the_author_meta( 'ID' ), 50 );
									$args_children[$i]['info'] = '
										<h3><a href="'.$args_children[$i]['link'].'">'.$args_children[$i]['name'].'</a></h3>
										<p>Giới tính : '.get_user_meta($user_id, "orphan_children_gender", true).'</p>
										<p>Ngày sinh : '.get_user_meta($user_id, "orphan_children_birthday", true).'</p>
									';
									$i++;
								endwhile ;
								wp_reset_query(); 
								$info_parent['content'] = 'Ông bà đã đăng thông tin tìm con là một pé '.(isset($info_children['children_gender']) ? $info_children['children_gender'] : null ). 'Chúng tôi đã tìm thấy được một số thông tin:';
								if($args_children){
									orphan_sendmail_tnt($info_parent,$args_children);
								}
							endif;
						}
					}
					//Call send mail
				}
			}
		endwhile ;
		wp_reset_query(); 
	endif;
}

function orphan_sendmail_tnt($info_sendmail = null,$list_data = null){
	$to  = $info_sendmail['email'];		
	$subject = $info_sendmail['title'];
	
	// message
	$message = '
	<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Thông tin trẻ mồ côi đang chờ đón yêu thương</title>
	<style>
	h1 {color: #547159 !important; font-size: 48px; text-shadow: 1px 1px 1px #fff; font-family: Georgia, "Times New Roman", Times, serif; margin: 0; padding: 0;}
	h2 {color: #9faf78 !important; font-size: 30px; margin-bottom: 10px; font-family: Georgia, "Times New Roman", Times, serif; padding: 0;}
	.content p {font-size: 13px; color: #686f64; font-family: Arial, Helvetica, sans-serif; padding: 0; margin: 0 0 10px 0;}
	.content ul, .content ol{margin:0 0 0 30px; padding:0;}
	.content ul li, .content ol li{font-size: 13px; color: #686f64; font-family: Arial, Helvetica, sans-serif; padding: 0; margin: 0 0 10px 0;}
	.content a {color: #9faf78 !important; text-decoration: underline !important;}
	.content a:hover {color: #9faf78 !important; text-decoration: underline !important;}
	.footer p {color: #fff; font-size: 13px; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
	table.table-border-tpo, .table-border-tpo tr, .table-border-tpo td{
		border:1px solid #888888;
		text-align:left;
		font-size:13px;
	}
	</style>
	
	<!--[if gte mso 9]>
	<style type="text/css">
	.body{background: #353732 url("'.get_template_directory_uri().'/images/body-bg.jpg");}	     
	.case {background:none;}
	</style>
	<![endif]-->
	</head>
	<body style="background-color:#58A9F0; background-image: url('.get_template_directory_uri().'/images/bg.png); background-repeat: repeat-x;" class="body" marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
	
	<!--100% body table-->
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#58A9F0; background-image: url('.get_template_directory_uri().'/images/bg.png); background-repeat: repeat-x;" >
	  <tr>
		<td class="case" style="background: url('.get_template_directory_uri().'/images/bg_header.png) no-repeat scroll center 0 transparent;"><!--[if gte mso 9]>
					<td style="background: none;">
					<![endif]--> 
		  <!--header text-->
		  
		  <table id="top" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td valign="middle" align="center" style="text-align:center;"> 
							<a href="#"> <img src="'.get_template_directory_uri().'/images/logo.png" alt="logo" /></a>
					</td>
				  </tr>
				</table></td>
			</tr>
		  </table>
		  <!--/header text--> 
		  
		  <!--masthead-->
		  
		  <table style="background: none repeat scroll 0 0 #FFFFFF;border-radius: 4px 4px 0px 0px;box-shadow: 0 0 3px #888888;overflow: hidden;" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <td style="background: #ECFAFE;border-radius: 4px 4px 0px 0px;" valign="top" height="77"><!--date-->
				
				
				<!--title-->
				
				<table width="600" border="0" cellspacing="0" cellpadding="00">
				  <tr>
					<td height="25"></td>
				  </tr>
				  <tr>
					<td><h1 style="font-size:28px;text-align:center;display:block;">
						<singleline label="Title">Đón Nhận Yêu Thương</singleline>
					  </h1></td>
				  </tr>
				</table>
				<!--/title--></td>
			</tr>
		  </table>
		  <!--/masthead--> 
		  
		  <!--top intro-->
		  
		  <table style="background: #ECFAFE;border-top:2px solid blue;box-shadow: 0 0 3px #888888;overflow: hidden;" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <td height="35"><!--break-->
				
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td height="10">&nbsp;</td>
				  </tr>
				</table>
				<!--/break-->
				
				<repeater>
				<table class="content" width="540" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td style="text-align:left;"> 
					  <multiline label="Description">
					  <p style="text-align:left;">
						  Xin chào '. $info_sendmail['name'].',
						  <br />
						  '.$info_sendmail['content'].'
						  <br />';
					  if($list_data):
	$message .=         	
							'Dưới đây là những trẻ phù hợp với nhu cầu tìm kiếm của bạn:
							<table class="table-border-tpo" style = "border-collapse:collapse;text-align:left;border-color:#cccccc;margin-bottom:10px;" border="1" align="left" width="100%">
								<tr style="border-color:#cccccc; font-weight:bold">
									<td style="border-color:#cccccc">STT</td>
									<td style="border-color:#cccccc">Ảnh hiện tại</td>
									<td style="border-color:#cccccc">Thông tin</td>
								</tr>';
$i = 0;
foreach ($list_data as $item):
	$i ++;
	$message .=         	
								'<tr style="border-color:#cccccc">
									<td style="border-color:#cccccc">'. $i .'</td>
									<td style="border-color:#cccccc">'. $item['avatar'] .'</td>
									<td style="border-color:#cccccc">'. $item['info'] .'</td>
								</tr>';
endforeach;
	$message .=         				                  	
						  '</table>
						  <br />
						  <br />
						  Bạn tham khảo thông tin trên và liên lạc, gặp gỡ và tìm hiểu để biết thông tin.
						  ';		                  
					  endif;
	$message .=         			
						  'Hoặc mời bạn liên lạc với <a href="'.home_url().'/lien-he" title="trẻ mồ côi">chúng tôi</a> để biết thêm chi tiết.
						  <br />Chúc bạn sớm tìm được người thân của mình!
						  <br />
						  <br />
						  Cảm ơn bạn đã sử dụng website '.home_url().'
					  
					  </p>
					  </multiline>
						<br />
					</td>
				  </tr>
				  <!--line-->    
				  <tr>
					<td valign="top" align="center" height="25">
					<hr />
					<p align="right" style="float:right; clear:both; margin: 0; padding: 0;"><a href="#top"><img src="'.get_template_directory_uri().'/images/up.gif" height="22" width="21" alt="back to top" border="0" /></a></p>
					</td>
				  </tr>
				  <!--/line--> 
				</table>
				</repeater>
				
							<!--break-->
				
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td height="20">&nbsp;</td>
				  </tr>
				</table>
				<!--/break-->
			  </td>
			</tr>
		  </table>
		  <!--/top intro--> 
	 
		  
		  <!--footer-->
		  
		  <table class="footer" style="color:white; font-size:13px;background: #1979EC;border-radius: 0px 0px 4px 4px;border-top:2px solid blue;box-shadow: 0 0 3px #888888;overflow: hidden;" width="600" border="0" align="center" cellpadding="20" cellspacing="0">
			<tr>
			  <td class="footer" valign="top"><multiline label="Description">
			  <p>
					Nếu bạn đã tìm được người thân, phiền bạn hồi âm hoặc <a style="color:orange;" href="'.home_url().'/lien-he">liên hệ</a> với chúng tôi, để thông tin của gia đình cũng như con bạn được bảo mật tuyệt đối.
			  </p>
			  </multiline>
			  <hr/>
			  <p>
					Website <a href="'.home_url().'" style="color:orange;">'.home_url().'</a> giúp kết nối những gia đình đang tìm người thân.          
			  </p>
			  </multiline>
			  <hr/>
				<p>
				
					Nếu cảm thấy những email như thế này làm phiền bạn và bạn không muốn nhận thông tin từ website nữa, vui lòng hủy chức năng gửi email 
				  <a href="'.home_url().'/huy-nhan-email-tim-nguoi-than/?unsubscripbe='.$info_sendmail['mailing_cancel'].'" style="color:orange;">tại đây.</a>
				</p></td>
			</tr>
		  </table>
		  <!--footer--> 
		  
		  <!--break-->
		  
		  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			  <td height="25">&nbsp;</td>
			</tr>
		  </table>
		  <!--/break--></td>
	  </tr>
	</table>
	<!--/100% body table-->
	</body>
	</html>
	';
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$info_sendmail['name'].' <'. $info_sendmail['email'] .'>' . "\r\n";
	$headers .= 'From: TreMoCoi <tremocoi.org.vn@gmail.com>' . "\r\n";
	
	$b64subject = "=?UTF-8?B?" . base64_encode($info_sendmail['subject']) . "?=";
	$headers .= 'Subject: '. $b64subject . "\r\n";
	// Mail it		
	wp_mail( $to, $subject, $message, $headers );
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
				update_usermeta( $user_id, 'status_sendmail_tnt', true);
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
				if($dataForm['txt-birthday']!=''){
					update_usermeta( $user_id, 'birthday', $dataForm['txt-birthday']);
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

function orphan_maping_children_with_parent(){
	global $post_type_parent_tnt, $post_type_children_tnt;
	//get all post type : bo-me-tim-con
	$args = array(
		'post_type' => $post_type_children_tnt,
		'post_status' => array(
			'publish',
			'pending',
			'future',
			'private'
		),
		'order'	=>'DESC',
		'posts_per_page' => -1,
		'caller_get_posts'=> 1
	);
	$the_query_children_looking_for = new WP_Query();
	$the_query_children_looking_for->query($args);
	// The Loop
	if ( $the_query_children_looking_for->have_posts() ) :
		while ( $the_query_children_looking_for->have_posts() ) : $the_query_children_looking_for->the_post();
			//get children with conditions
			$info_parent = array();
			$meta_query = array();
			$user_id = get_the_author_meta( 'ID' );
			if(get_user_meta($user_id, "status_sendmail_tnt", true) == true){
				$get_userdata =  get_userdata($user_id ); 
				$info_children = array();
				$info_children['name'] = $get_userdata->display_name;
				$info_children['phone'] = get_user_meta($user_id, "phone", true);
				$info_children['email'] = $get_userdata->user_email;
				$info_children['subject'] = 'Thông tin tìm người thân';
				$info_children['sender'] = 'Kính gởi Ông/Bà: '.$info_children['children_name'];		
				$code = base64_encode($user_id."|".md5($user_id.$get_userdata->user_email."aJ#FTUkk"));
				$info_children['mailing_cancel']	= $code;		
				if(get_post_meta( get_the_ID(), 'orphan_parent_name', true )){
					$meta_query[] = array(
						'key'     => 'display_name',
						'value'   => get_post_meta( get_the_ID(), 'orphan_parent_name', true ),
						'compare' => 'LIKE'
					);
				}
				
				if(get_post_meta( get_the_ID(), 'orphan_parent_job', true )){
					$info_parent['parent_job'] = get_post_meta( get_the_ID(), 'orphan_parent_job', true );
					$meta_query[] = array(
						'key'     => 'job',
						'value'   => get_post_meta( get_the_ID(), 'orphan_parent_job', true ),
						'compare' => 'LIKE'
					);
				}
				
				if($meta_query){
					$meta_query['relation'] = 'OR';
					if(get_post_meta( get_the_ID(), 'orphan_parent_time_lost', true )){
						$info_parent['parent_time_lost'] = get_post_meta( get_the_ID(), 'orphan_parent_time_lost', true );
					}
					
					if(get_post_meta( get_the_ID(), 'orphan_parent_place_lost', true )){
						$info_parent['parent_place_lost'] = get_post_meta( get_the_ID(), 'orphan_parent_place_lost', true );
					}
					

					$args_meta_user_query = array(
						'meta_query' => $meta_query
					);
					$user_query = new WP_User_Query( $args_meta_user_query );
					$result_users = $user_query->get_results();
					if($result_users ){
						$id_users = array();
						foreach($result_users  as $user_info){
							$id_users[$user_info->ID] = $user_info->ID;
						}
						if($id_users){
							$str_id_user = implode(',',$id_users);
							$args = array();
							$args = array(
								'post_type' => $post_type_children_tnt,
								'author' => $str_id_user,
								'order'	=>'DESC',
								'post_status' => array(
									'publish',
									'pending',
									'future',
									'private'
								),
								'posts_per_page' => -1,
								'caller_get_posts'=> 1
							);
							
							$parent_meta_query = array();
							if(isset($info_parent['parent_time_lost'] )){
								$parent_meta_query[] = array(
									'key'   => 'orphan_children_time_lost',
									'value' => $info_parent['parent_time_lost'],
									'compare' => "LIKE"
								);
							}
							if(isset($info_parent['parent_place_lost'] )){
								$parent_meta_query[] = array(
									'key'   => 'orphan_children_place_lost',
									'value' => $info_parent['parent_place_lost'],
									'compare' => "LIKE"
								);
							}
							if($parent_meta_query){
								$parent_meta_query['relation'] = 'AND';
								$args['meta_query'] = $parent_meta_query;
							}
							$parent_query = new WP_Query( $args );
							if ( $parent_query->have_posts() ) : 
								$args_parent = array();
								$i=0;
								while ( $parent_query->have_posts() ) : $parent_query->the_post();
									$user_id = get_the_author_meta( 'ID' );
									$get_userdata =  get_userdata($user_id ); 
									$args_parent[$i]['link'] = get_permalink();
									if(isset($get_userdata->display_name)){
										$args_parent[$i]['name'] = $get_userdata->display_name;
									}
									if(isset($get_userdata->user_email)){
										$args_parent[$i]['email'] = $get_userdata->user_email;
									}
									if(get_user_meta($user_id, "address", true)){
										$args_parent[$i]['address'] = get_user_meta($user_id, "address", true);
									}
									if(get_user_meta($user_id, "phone", true)){
										$args_parent[$i]['phone'] = get_user_meta($user_id, "phone", true);
									}
									$args_parent[$i]['avatar'] = get_avatar( get_the_author_meta( 'ID' ), 50 );
									$args_parent[$i]['info'] = '
										<h3><a href="'.$args_parent[$i]['link'].'">'.$args_children[$i]['children_name'].'</a></h3>
										<p>Giới tính : '.get_user_meta($user_id, "orphan_children_gender", true).'</p>
										<p>Ngày sinh : '.get_user_meta($user_id, "orphan_children_birthday", true).'</p>
									';
									$i++;
								endwhile ;
								wp_reset_query(); 
								$info_children['content'] = 'Ông bà đã đăng thông tin tìm bố mẹ. Chúng tôi đã tìm thấy được một số thông tin:';
								if($args_parent){
									orphan_sendmail_tnt($info_children,$args_parent);
								}
							endif;
						}
					}
					//Call send mail
				}
			}
		endwhile ;
		wp_reset_query(); 
	endif;
}

/* add menu */
if(is_admin()){
	add_action('admin_menu', 'orphan_menu_settings');
	function orphan_menu_settings() {
		if (function_exists('add_menu_page')) {
			add_menu_page('Cấu hình hệ thống','Cấu hình hệ thống', 'orphan_manage_options', 'orphan_menu_setting-handle', '' ,get_bloginfo('template_directory').'/images/family.png');
		}
	}
	// Hook for adding admin menus
	add_action('admin_menu', 'orphan_add_menu_settings'); 
}
function orphan_add_menu_settings() {
	global $uc_message; 
	/* save setting */
	if(isset($_POST['action_setting']) && $_POST['action_setting'] == 'Save Settings'){
			$status = update_option('setting_active_cron_tnt',$_POST['cronenable']);
			$status1 = update_option('setting_time_tnt',$_POST['cronint']);
			if($status || $status1){
				$uc_message = 'Save successfully!'; 
			} else {
				$uc_message = 'Can not save. Please try again!'; 
			}
	}
	add_submenu_page('orphan_menu_setting-handle', 'Cấu hình lịch gởi mail tìm người thân', 'Cấu hình lịch gởi mail tìm người thân', 'manage_options', 'option-setting_looking_for_relativies', 'get_display_form_setting_looking_for_relativies');
}
function get_display_form_setting_looking_for_relativies(){
	global $uc_message;
	if (!current_user_can( 'manage_options' ) ) {
		wp_die ( __( 'You do not have sufficient permissions to access this page' ) );
	}
	orphan_int_cron_job_looking_for_relativies();
	$setting_active_cron_tnt = get_option('setting_active_cron_tnt');
	$check_setting_active_cron = '';
	if($setting_active_cron_tnt == 'Yes'){
		$check_setting_active_cron = 'checked="checked"';
	}
	$setting_time_tnt = get_option('setting_time_tnt');

	$cronint = array(
		'hourly'=> 'Hourly',
		'twicedaily'=> 'Twice Daily',
		'daily'=> 'Daily'
	);
	// Calculate next cron execution
	$next_cron = wp_next_scheduled('orphan_process_cron_looking_for_relativies');
	$next_execution = 'Not set';
	if ( !empty($next_cron) ) {
		$datetime = get_option('date_format') . ' @ ' . get_option('time_format');
		$next_execution = gmdate($datetime, $next_cron + (get_option('gmt_offset') * 3600));    
	}
?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Cấu hình lịch gởi mail tìm người thân</h2>
		<p class="message_action" style="display:none; border: 1px solid green;  color: blue;  padding: 10px;"></p>
		<form class="get_form_setting_looking_for_relativies" action="#" method="post" name="form_setting_looking_for_relativies" id="form_setting_looking_for_relativies">
		<p><br/></p>
			<fieldset>
			<legend>Cấu hình:</legend>
			<table class="form-table">
				<tr valign="top">
					<td width="100">Tùy chọn</td>
					<td>
						<input type="checkbox" name="cronenable" <?php echo $check_setting_active_cron; ?> value="Yes" /><label class="opt">&nbsp;Yes</label>
						<select size="1" name="cronint" id="cronint">
							<?php
							
							foreach($cronint as $cronint_key=>$cronint_tiem ){
								$cronint_selected ='';
								if($setting_time_tnt == $cronint_key ){
									$cronint_selected = 'selected="selected"';
								}
							?>
							<option value="<?php echo $cronint_key ?>" <?php echo $cronint_selected ?>><?php echo $cronint_key ?></option>
						 <?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="100">Thời gian chạy lịch tiếp theo</td>
					<td><?php echo $next_execution ?></td>
				</tr>
				<tr>
					<td width="100"></td>
					<td>
						<p class="submit">
						<input class="button-primary" type="submit" name="action_setting" value="Save Settings" />
						</p>
					</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				<?php if(isset($uc_message) && $uc_message !=''){ ?>
					jQuery('p.message_action').text('<?php echo $uc_message; ?>').show().fadeOut(6000);
				<?php $uc_message ='';	}  ?>
			});
		</script>
		<style>
			legend,fieldset{border:1px solid #d5d5d5; padding:5px;}
			legend{margin-left:10px;}
		</style>
	</div>
<?php
}

function orphan_int_cron_job_looking_for_relativies(){
	$cronenable = get_option('setting_active_cron_tnt');
	$croninterval = get_option('setting_time_tnt');
	// Check if Cron is activated...
    if ($cronenable == 'Yes') {
		// Check if cron is scheduled
		if (wp_next_scheduled('orphan_process_cron_looking_for_relativies')) {
			// Delete cron first
			wp_clear_scheduled_hook('orphan_process_cron_looking_for_relativies');
		}
		// Set new cron
		wp_schedule_event(time(), $croninterval, 'orphan_process_cron_looking_for_relativies');
    }
    else {
	  wp_clear_scheduled_hook('orphan_process_cron_looking_for_relativies');
    }
}

add_action('orphan_process_cron_looking_for_relativies', 'orphan_process_cron_running_looking_for_relativies');
function orphan_process_cron_running_looking_for_relativies(){
	//running maping looking for relativies
	orphan_maping_children_with_parent();
	orphan_maping_parent_with_children();
	orphan_convert_information_children_into_orphan_children();
}
function orphan_convert_information_children_into_orphan_children(){
	global $post_type_parent_tnt, $post_type_children_tnt,$orphan_prefix;
	
	$args = array(
		'post_type' => $post_type_children_tnt,
		'post_status' => array(
			'publish',
			'pending',
			'future',
			'private'
		),
		'order'	=>'DESC',
		'posts_per_page' => -1,
		'caller_get_posts'=> 1
	);
	$the_query_children_looking_for = new WP_Query();
	$the_query_children_looking_for->query($args);
	// The Loop
	if ( $the_query_children_looking_for->have_posts() ) :
		while ( $the_query_children_looking_for->have_posts() ) : $the_query_children_looking_for->the_post();
			$user_post_id = get_the_ID();
			$now = date('Y-m-d H:i:s');
			$startDate = get_the_date('Y-m-d H:i:s');
			$days = round(((strtotime($now) - strtotime($startDate)) / (60 * 60 * 24)),1, PHP_ROUND_HALF_UP); 
			if($days>90){
				$title = get_the_author_meta( 'user_email');
				$user_id = get_the_author_meta( 'ID' );
				$content = get_post_meta( $user_post_id, 'orphan_parent_description', true );
				$photo =  orphan_get_avatar_url(get_avatar( $user_id, 150 ));
				$birthday =  get_user_meta($user_id, "birthday", true);
				
				$my_post = array(
				  'post_title'    => $title,
				  'post_type'    => 'tre-mo-coi',
				  'post_content'  => $content,
				  'post_status'   => 'pending',
				  'post_author'   => get_the_author_meta( 'ID' )
				);
				
				// Insert the post into the database
				$post_id  = wp_insert_post( $my_post );
				//echo $post_id;
				if($post_id){
					add_post_meta( $post_id, $orphan_prefix.'birthday', $birthday );
					
					$gender = get_user_meta($user_id, "gender", true);
					add_post_meta( $post_id, $orphan_prefix.'gender', $gender );
					
					$address = get_post_meta( $user_post_id, 'orphan_parent_place_lost', true );
					add_post_meta( $post_id, $orphan_prefix.'cv-address', $address ); 
					
					$time_lost = get_post_meta( $user_post_id, 'orphan_parent_time_lost', true );
					add_post_meta( $post_id, $orphan_prefix.'cv-time', $time_lost );
					
					add_post_meta( $post_id, $orphan_prefix.'cv-content', $content );
					
					add_post_meta( $post_id, $orphan_prefix.'photo', $photo);
					
					add_post_meta( $post_id, $orphan_prefix.'cv-auth',$get_userdata->user_email);
				}
				//Set post to draft
				$children_post['ID'] = $user_post_id;
				$children_post['post_status'] = 'draft';
				wp_update_post( $children_post );
			}
		endwhile ;
		wp_reset_query(); 
	endif;
	
}

function orphan_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return isset($matches[1]) ? $matches[1] : get_template_directory_uri().'/images/no_image.png';
}
 ?>