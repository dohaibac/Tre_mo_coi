<?php
global $orphan_prefix;
$orphan_prefix = 'orphan_';
global $post_type_vum, $post_type_vum_label;
$post_type_vum = 'vuon-uoc-mo';
$post_type_vum_label = 'Vườn ước mơ';
function orphan_register_vuon_uoc_mo_post_type() { 
	global $post_type_vum, $post_type_vum_label;
	$label = $post_type_vum_label;
	$post_type_vum = $post_type_vum;
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
		'rewrite' => array('slug' => $post_type_vum),
		'supports' => $supports,
		'menu_position' => 5,
		'menu_icon' => get_bloginfo('template_directory').'/images/family.png'
	);
	register_post_type( $post_type_vum,$post_type_args);
 } 
add_action('init', 'orphan_register_vuon_uoc_mo_post_type');

/**add box admin*/
global $orphan_fields_vum_array;
global $orphan_save_meta_post;
$orphan_fields_vum_array = array(
	orphan_result_meta_vum(
		array(
			'name' 			=> 'ncn_ly_do',
			'label'			=> 'Lý do nhận con nuôi',
			'description' 	=> '',
			'type'			=> 'textarea',
			'required'		=> true,
			'rich_editor'	=> false,
			'options'		=> null
		)
	)
);

$orphan_save_meta_post[] = $orphan_fields_vum_array;
function orphan_fields_vum_array(){
 global $orphan_fields_vum_array;
 return $orphan_fields_vum_array;
}
//add_action('admin_menu', 'orphan_add_meta_box_vum');
function orphan_add_meta_box_vum(){
	global $orphan_prefix, $orphan_fields_vum_array, $post_type_vum;
	
	$meta_box_fields = array(
		'context' => 'normal',
		'priority' => 'high',
		'fields' => $orphan_fields_vum_array
	);
	add_meta_box($orphan_prefix.'metabox_vuon_uoc_mo', 'Vườn ước mơ', 'orphan_show_meta_box', $post_type_vum, 'advanced', 'default', $meta_box_fields);
}
function orphan_result_meta_vum($meta_info = null){
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

add_action( 'wp_ajax_nopriv_ajax_insert_vuon_uoc_mo', 'ajax_insert_vuon_uoc_mo' );  
add_action( 'wp_ajax_ajax_insert_vuon_uoc_mo', 'ajax_insert_vuon_uoc_mo' );
function ajax_insert_vuon_uoc_mo(){
	global $orphan_prefix, $current_user ,$post_type_vum;
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
		   if(isset($dataForm['txt-title']) && isset($dataForm["post-content"])){
				$title = $title = $dataForm["txt-title"];
				// Create post object
				$my_post = array(
				  'post_title'    => $title,
				  'post_type'    => $post_type_vum,
				  'post_content'    => $dataForm["post-content"],
				  'post_status'   => 'publish',
				  'post_author'   => $current_user->ID
				);
				// Insert the post into the database
				$post_id  = wp_insert_post( $my_post );
				if($post_id){		
					$results['status'] = 'true';
					$results['message'] = 'Nhập dữ liệu thành công. Hệ thống sẽ tự chuyển về trang vườn ước mơ sau 3 giây.';
				} else {
					$results['message'] = 'Đăng thông tin không thành công hãy thử lại.';
				}
			}else{
				$results['message'] = 'Nhập tiêu đề bài viết/ Nội dung bài viết.';
			}
		}
	} else
	{
		$results['status_login'] = 'false';
		$results['message'] = 'Hãy đăng nhập để tiếp tục nhập dữ liệu';
	}
	die(orphan_get_json($results));
}

function form_add_new_garden_dream(){
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		$captcha = create_captcha(); 
		$prefix = $captcha['prefix'];
		$file = $captcha['file'];
	?>
	<form class="custom" action="#" method="POST" id="fn_submit_form" onsubmit="fn_submit_form()">
		<div class="show_message_error alert-box alert" style="display:none;margin:15px 0 10px 0; padding:5px;" id="message_error_container"></div>
		<div class="row">
			<div class="small-3 columns">
			  <label for="txt-title" class="inline">Tiêu đề <span class="require">*</span></label>
			</div>
			<div class="small-9 columns">
			  <input value="" style="margin:0px 0 4px 0;" type="text" name="txt-title" id="txt-title" placeholder="Nhập tiêu đề bài viết" />
			</div>
		</div>
		<div class="row">
			<div class="small-3 columns">
			  <label for="post-content" class="inline">Nội dung<span class="require">*</span></label>
			</div>
			<div class="small-12 columns">
				<div class="editor-full">
				  <?php 
					$field = 'post-content';
					 $settings = array(
						'textarea_name' => $field,
						'textarea_rows' => 10,
						'media_buttons' => true,
						'tinymce' => array(
							'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
								'bullist,blockquote,|,justifyleft,justifycenter' .
								',justifyright,justifyfull,|,link,unlink,|' .
								',spellchecker,wp_fullscreen,wp_adv'
						)
					);
					wp_editor( '', $field, $settings );
				?>
				</div>
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
		<div class="row">
			<div class="large-12 columns text-center">
				<button id="submit_content">Đăng thông tin</button>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		jQuery(function($){
			$("#submit_content").click(function(){fn_submit_form();return false;});
			var check_post_content = $('#fn_submit_form').bind("invalid-form.validate", function() {
				 $("#message_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.").show();
			 }).validate({
				rules:{
					'txt-title': "required",
					'post-content': {
						required: true
					},
					'txt-captcha': {
						required:true,
						minlength:4,
						maxlength:4
					}
				},
				messages: {
					'txt-title': "Nhập tiêu đề bài viết.",
					'post-content': {
						required: 'Nhập nội dung bài viết.'
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
			
			function fn_submit_form(){
				var content;
				inputid = 'post-content';
				var editor = tinyMCE.get(inputid);
				if (editor) {
					// Ok, the active tab is Visual
					content = editor.getContent();
				} else {
					// The active tab is HTML, so just query the textarea
					content = $('#'+inputid).val();
				}
				jQuery('form#fn_submit_form textarea#post-content').html(content);
				if(check_post_content.form()){
					jQuery.ajax({  
						type: 'POST',  
						url: ajaxurl,  
						data: {  
							action: 'ajax_insert_vuon_uoc_mo',  
							data_from : $("form#fn_submit_form").serialize()
						},   
						dataType: 'json',
						beforeSend: function(){
							jQuery('div.message_overflow').fadeIn();
						},
						success: function(response){ 
							
							if(response.status_login == 'true'){
								if(response.status == 'true'){
									$("#message_error_container").text(response.message);
									$("#message_error_container").show();
									jQuery('div.message_overflow strong.info').html(response.message).fadeIn();
									$("#submit_fn_submit_form").attr('disabled', 'disabled');
									setTimeout(function() {
										window.location = url_home+'/vuon-uoc-mo';
								   }, 3000);
								} else{ 
									jQuery('div.message_overflow').fadeOut();
									$("#message_error_container").text(response.message);
									$("#message_error_container").show();
									if(response.captcha_error == 'true'){
										$('form#fn_submit_form input#txt-captcha').val('');
										$('form#fn_submit_form img#captcha_file').attr('src', response.captcha_file).fadeIn();
										$('form#fn_submit_form input#captcha_prefix2').val(response.captcha_prefix);
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
		#post-content_ifr{background:#fff;}
	</style>
<?php } ?>
