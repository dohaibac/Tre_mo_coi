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
?>

<div class="large-8 columns content">
	<div class="row">
		<div class="row shadow-box">
			<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
			<h2><?php if(function_exists('bcn_display')) {bcn_display(); } ?></h2>
			<div class="box-content">
				
				<hr />
				<span style="font-size:0.8em; color:blue;">Thông tin trẻ mồ côi sẽ được chúng tôi bảo mật và chỉ cho những người thật sự có nhu cầu nhận con nuôi tham khảo thông tin sau khi được chúng tôi đồng ý.</span>
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
				<div data-alert="" class="alert-box alert" style="display:none;margin-bottom:5px;" id="registerchild_error_container"></div>
				<form class="custom" action="<?php the_permalink() ?>" method="POST" id="registerchild_form" onsubmit="registerchild()">
					<input type="hidden" name="action" value="1" />
					<fieldset>
						
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
							</div>
							<div class="small-6 columns">
							  <input type="text" name="txt-name" id="txt-name" placeholder="Họ tên" />
							</div>
							<div class="small-2 columns">
								<label for="chk-newname" class="inline">Tên mới</label>
							</div>
							<div class="small-1 columns">
							  <input type="checkbox" name="chk-newname" id="chk-newname" style="display:none;" /> 
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="cbx-day" class="inline">Ngày sinh <span class="require">*</span></label>
							</div>
							<div class="small-3 columns">							  
								<select name = "cbx-day">
									<option value="0">Ngày</option>
									<?php 
										for($i=1;$i <=31 ;$i++):
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php endfor; ?>
								</select>
							</div>
							<div class="small-3 columns">
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
								<select name = "cbx-year">
									<?php 
										$tmpyear = date("Y");
										for($i=$tmpyear;$i>($tmpyear-12);$i--):
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php endfor; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
								<label class="inline">Giới tính</label>
							</div>
							
							<div class="small-4 columns">
								<label for="gender1" class="inline">
								<input type="radio" style="display:none;" name="txt-gender" id="gender1" value="Nam" checked="checked" /> Nam</label>
							</div>
							<div class="small-5 columns">
								<label for="gender2" class="inline"><input type="radio" style="display:none;" name="txt-gender" id="gender2" value="Nữ" /> Nữ</label>
							</div>							
						</div>
						<div class="row">
							<div class="small-3 columns">
								<label for="url-hinhanh" class="inline">Hình ảnh</label>
							</div>							
							<div class="small-6 columns">
								<input type="url" name="url-hinhanh" placeholder="Nhập url hình ảnh"  id="url-hinhanh" value="" class="inline" size="50"/>
								<a href="#_upload" data="url-hinhanh" class="button upload_image_button prefix">Đăng hình ảnh</a>
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
								<div class="large-9 columns">
									<input type="text" name="txt-place" id="txt-place" placeholder="Địa điểm" />
								</div>
							</div>
							<div class="row">
								<div class="large-3 columns">
									<label for="txt-time" class="inline">Thời gian</label>								
								</div>
								<div class="large-9 columns">
									<input type="text" name="txt-time" id="txt-time" placeholder="Thời gian" />
								</div>
							</div>
							<div class="row">
								<div class="large-3 columns">
									<label for="txt-content" class="inline">Tình trạng</label>								
								</div>
								<div class="large-9 columns">
									<textarea name="txt-content" id="txt-content" ></textarea>
								</div>
							</div>
							<div class="row">
								<div class="small-3 columns">
								  <label for="txt_captcha" class="inline">Mã bảo mật <span class="require">*</span></label>
								</div>
								<div class="small-9 columns">
								  <div class="left"><input type="text" style="width:100px;" name="txt_captcha" id="txt_captcha" placeholder="Mã bảo mật"></div>
								  <div class="left" style="margin-top:1px;"><img id="captcha_file" src="<?php echo $file; ?>" /></div>
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

						tb_show('Đăng hình ảnh', url_home+'/wp-admin/media-upload.php?type=image&amp;TB_iframe=true');

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
			
				$("#submit_form_register_child").click(function(){registerchild();return false;});
				
				var registerchild_validator = $('#registerchild_form').bind("invalid-form.validate", function() {
					
					 $("#registerchild_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.");
					 $("#registerchild_error_container").show();
				 }).validate({
					 
					rules:{
					  'txt-name': "required",
					  'txt-place': "required",
					  'txt-time': "required",
					  'txt-content': "required",
					  'txt_captcha': "required"
					},
					messages: {
						
					  'txt-name': "Nhập họ và tên.",
					  'txt-place': "Nhập địa chỉ",
					  'txt-time': "Nhập địa điểm gặp trẻ em",
					  'txt-content': "Nhập tình trạng lúc gặp trẻ",
					  'txt_captcha': "Nhập mã bảo mật."
					},
					wrapper : 'div',
					debug: false
				  });
				
				function registerchild(){
					
				  if(registerchild_validator.form()){
					  $('#registerchild_form').submit();
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