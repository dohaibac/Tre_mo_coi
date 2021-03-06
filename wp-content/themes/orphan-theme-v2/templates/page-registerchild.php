<?php 

/**
 * Template Name: Nhập thông tin trẻ mồ côi
 * Description: A Page Template that shows form register
 * @author Phi Ho
 */
global $current_user;
get_header();


// CHECK LOGIN
if($current_user->ID == null)
{
	?>
	<script>
	alert("Bạn cần đăng nhập và kích hoạt tài khoản trước khi sử dụng chức năng này.");
	document.location.href = '<?php echo home_url()?>';
	</script>
	<?php
}
else 
{
	$key = get_user_meta($current_user->ID, 'tmc_activation_key', true);
	if (!empty($key))
	{
		?>
		<script>
		if(confirm("Bạn cần kích hoạt tài khoản tại hòm thư điện tử của bạn, trước khi sử dụng chức năng này. Bạn có muốn nhận lại thư kích hoạt tài khoản không?"))
		{
			<?php
			wp_new_user_notification( $current_user->ID ); 
			?>
			alert("Chúng tôi đã gửi lại thư kích hoạt, vui lòng kiểm tra hòm thư điện tử của bạn!");
		}
		document.location.href = '<?php echo home_url()?>';
		</script>
		<?php
	}
}

$captcha = create_captcha(); 
$prefix = $captcha['prefix'];
$file = $captcha['file'];
wp_enqueue_script('jquery-ui-1.8.16.custom.min',get_bloginfo('template_directory').'/includes/js/jquery-ui-1.8.16.custom.min.js');
wp_enqueue_script('ui.datepicker-vi',get_bloginfo('template_directory').'/includes/js/ui.datepicker-vi.js');
//wp_enqueue_script('orphan-script-admin',get_bloginfo('template_directory').'/includes/js/orphan-script-admin.js');
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory')?>/includes/css/custom-meta-post.css" />
<div class="large-8 columns content">
	<div class="row">
		<div class="row shadow-box">
			<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
			<h2><?php if(function_exists('bcn_display')) {bcn_display(); } ?></h2>
			<div class="box-content">
				
				<hr />
				<span style="font-size:0.8em; color:blue;">Thông tin trẻ mồ côi sẽ được chúng tôi bảo mật và chỉ cho những người thật sự có nhu cầu nhận con nuôi tham khảo thông tin sau khi được chúng tôi đồng ý.<br /></span>
				
				<?php 
				$errors = new WP_Error();
				if($_POST['action'] == 1){
					$captcha_instance = new ReallySimpleCaptcha();	
					if(!$captcha_instance->check( $_POST['captcha_prefix'], $_POST['txt_captcha'] ))
					{
						$captcha_error = true;	
					}
					$captcha_instance->remove( $_POST['captcha_prefix'] );	
					if($captcha_error)
					{
						$errors->add( 'captcha_error', __( "Mã bảo mật không đúng, vui lòng nhập lại." ) );
						
					}
					else 
					{	
				
						insert_tre_mo_coi($_POST); 
					}
				}?>
				<div data-alert="" class="alert-box alert" style="display:none;margin:15px 0 5px 0;" id="registerchild_error_container"></div>
				<form class="custom" action="<?php the_permalink() ?>" method="POST" id="registerchild_form" onsubmit="registerchild()">
					<input type="hidden" name="action" value="1" />
					<fieldset>
						
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
							</div>
							<div class="small-6 columns"  style="margin-bottom: 15px;">
							  <input style="margin:0px 0 4px 0;" type="text" name="txt-name" id="txt-name" placeholder="Họ tên" />
							</div>
							<div class="small-1 columns" style="float:left; padding:0px; text-align:right; margin:0px 0 4px 0; width:60px;">
								<label for="chk-newname" class="inline" style="margin:8px 8px 0 0; padding:0px;">Tên mới</label>
							</div>
							<div class="small-2 columns" style="width:70px; padding:4px 0 0 0">
							  <input type="checkbox" value="on" name="chk-newname" id="chk-newname" style="display:none;" /> 
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="birthday_datepicker" class="inline">Ngày sinh <span class="require">*</span></label>
							</div>
							<div class="small-6 columns" style="margin-bottom: 15px;">								
								<input readonly="readonly" style="margin:0px 0 4px 0;" type="text" class="my_datepicker" name="birthday_datepicker" id="birthday_datepicker" value=""/>
								<!--select name = "cbx-day">
									<option value="0">Ngày</option>
									<?php 
										for($i=1;$i <=31 ;$i++):
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php endfor; ?>
								</select-->
							</div>
							<div class="small-3 columns"></div>
							<!--div class="small-3 columns">
								<select name = "cbx-month">
									<option value="0">Tháng</option>
									<?php 
										for($i=1;$i <= 12 ;$i++):
									?>
									<option value="<?php echo $i ?>">Tháng <?php echo $i ?></option>
									<?php endfor; ?>
								</select>
							</div>
							<div class="small-3 columns">
								<select name = "cbx-year" style="float:left">
									<option value="">Năm sinh</option>
									<?php 
										$tmpyear = date("Y");
										for($i=$tmpyear;$i>($tmpyear-12);$i--):
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php endfor; ?>
								</select>
							</div-->
						</div>
						<div class="row">
							<div class="small-3 columns">
								<label class="inline">Giới tính</label>
							</div>
							
							<div class="small-2 columns">
								<label for="gender1" class="inline">
								<input type="radio" style="display:none;" name="txt-gender" id="gender1" value="Nam" checked="checked" /> Nam</label>
							</div>
							<div class="small-7 columns">
								<label for="gender2" class="inline"><input type="radio" style="display:none;" name="txt-gender" id="gender2" value="Nữ" /> Nữ</label>
							</div>							
						</div>
						<div class="row">
							<div class="small-3 columns">
								<label for="url-hinhanh" class="inline">Hình ảnh</label>
							</div>							
							<div class="small-6 columns">
								<input type="text" name="url-hinhanh" placeholder="Nhập url hình ảnh"  id="url-hinhanh" value="" class="inline" size="50"/>
								<a href="#_upload" data="url-hinhanh" class="button upload_image_button prefix" style="z-index:1">Đăng hình ảnh</a>
							</div>
							<div class="small-3 columns">
								<img style="border:1px solid #d5d5d5;" id="image_url-hinhanh" width="80" src="<?php echo get_template_directory_uri();  ?>/images/no-avatar.png"/>
							</div>						
						</div>

						<div class="panel">
							<center><h6> Hoàn cảnh khi gặp trẻ: </h4></center>
							<hr />
							<div class="row">
								<div class="large-3 columns">
									<label for="txt-place" class="inline">Địa điểm</label>								
								</div>
								<div class="large-9 columns" style="margin-bottom: 15px;">
									<input style="margin:0px 0 4px 0;" type="text" name="txt-place" id="txt-place" placeholder="Địa điểm" />
								</div>
							</div>
							<div class="row">
								<div class="large-3 columns">
									<label for="txt-time" class="inline">Thời gian</label>								
								</div>
								<div class="large-9 columns" style="margin-bottom: 15px;">
									<input style="margin:0px 0 4px 0;" type="text" name="txt-time" id="txt-time" placeholder="Thời gian" />
								</div>
							</div>
							<div class="row">
								<div class="large-3 columns">
									<label for="txt-content" class="inline">Tình trạng</label>								
								</div>
								<div class="large-9 columns" style="margin-bottom: 15px;">
									<textarea style="margin:0px 0 4px 0;" name="txt-content" id="txt-content" ></textarea>
								</div>
							</div>
							<div class="row">
								<div class="small-3 columns">
								  <label for="txt_captcha" class="inline">Mã bảo mật <span class="require">*</span></label>
								</div>
								<div class="small-9 columns" style="margin-bottom: 15px;">
								  <div class="left"><input style="margin:0px 0 4px 0;" type="text" style="width:100px;" name="txt_captcha" id="txt_captcha" placeholder="Mã bảo mật"></div>
								  <div class="left" style="margin-top:1px;"> &nbsp; <img style="padding:0px; margin:0px 0 4px 0;" id="captcha_file" src="<?php echo $file; ?>" /></div>
								  <input type="hidden" name="captcha_prefix" id="captcha_prefix" value="<?php echo $prefix; ?>" />
								</div>
							</div>
						</div>						
						<div class="row">
							<div class="large-12 columns text-center">
								<button id="submit_form_register_child">Đăng ký</button>
							</div>
						</div>
					
					</fieldset>
				</form>
				<?php
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_style('thickbox');
				?>
				<script type="text/javascript">
	
					jQuery(function($){
					var txtBox_id = '';
					var image_id = '';
					$('.upload_image_button').click(function() {

						txtBox_id = '#'+$(this).attr('data');
						image_id = '#image_'+$(this).attr('data');

						formfield = $(txtBox_id);
						
						tb_show('Đăng hình ảnh', '<?php echo home_url()?>/wp-admin/media-upload.php?type=image&amp;TB_iframe=true');

						return false;

					});

					// send the selected image to the iamge url field

					window.send_to_editor = function(html) {

						imgurl = $('img',html).prop('src');

						$(txtBox_id).val(imgurl);

						$(image_id).attr('src', imgurl).fadeIn();

						tb_remove();

					}
				});
				
				//Check form 
				$(document).ready(function(){	
				
				//init datepicker control
				$('.my_datepicker').datepicker({
					dateFormat:'dd/mm/yy',
					maxDate: new Date,
					yearRange: "-20:+0",
					changeMonth: true, 
					changeYear: true
				});
			
				$("#submit_form_register_child").click(function(){registerchild();return false;});
				
				var registerchild_validator = $('#registerchild_form').bind("invalid-form.validate", function() {
					
					 $("#registerchild_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.");
					 $("#registerchild_error_container").show();
				 }).validate({
					 
					rules:{
					  'txt-name': "required",
					  'txt-place': "required",
					  'birthday_datepicker' : "required",
					  'txt-time': "required",
					  'txt-content': "required",
					  'txt_captcha': "required",
					  'txt-hinhanh':{
						url: true
					  }
					},
					messages: {
						
					  'txt-name': "Nhập họ và tên.",
					  'txt-place': "Nhập địa chỉ",
					  'birthday_datepicker' : "Nhập ngày sinh",
					  'txt-time': "Nhập địa điểm gặp trẻ em",
					  'txt-content': "Nhập tình trạng lúc gặp trẻ",
					  'txt_captcha': "Nhập mã bảo mật.",
					  'txt-hinhanh':{
							url: 'Nhập đường dẫn ảnh đại diện.'
					  }
					},
					wrapper : 'div',
					debug: false
				  });
				
				function registerchild(){
					if(registerchild_validator.form()){
						jQuery.ajax({  
							type: 'POST',  
							url: ajaxurl,  
							data: {  
								action: 'insert_tre_mo_coi',  
								data_from : $("form#registerchild_form").serialize()
							},  
							dataType: 'json',
							beforeSend: function() {
								
							},
							success: function(response){ 
								
								if(response.status_login == 'true'){
									if(response.status == 'true'){
										$("#registerchild_error_container").text(response.message);
										$("#registerchild_error_container").show();
										$("#submit_form_register_child").attr('disabled', 'disabled');
										alert(response.message);
										setTimeout(function() {
											window.location = url_home;
									   }, 3000);
									}
									else{
										alert(response.message);
										$("#registerchild_error_container").text(response.message);
										$("#registerchild_error_container").show();
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
			
			</div>
			<?php endif; ?>	
		</div>

	</div>
	
</div>
<?php get_sidebar(); ?>
 <?php 
 get_footer();
 

// ERRORS PROCESSING
if ( $errors->get_error_code() )
{
	$error_messages = $errors->get_error_messages();
	$error_strs = "<ul>";
	foreach ($error_messages as $error_message): 
		$error_strs .= "<li>".$error_message."</li>";
	endforeach;
	$error_strs .= "</ul>";
	?>
	<script>
		$("#registerchild_error_container").html("<?php echo $error_strs;?>");
	 	$("#registerchild_error_container").show();
	</script>
	<?php 
}
 ?>