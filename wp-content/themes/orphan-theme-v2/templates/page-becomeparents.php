<?php 
/**
 * Template Name: Đăng ký nhận trẻ Template
 * Description: A Page Template that shows form register
 * @author Long Nguyen and Ha Nguyen
 */

// GLOBAL VAR
 //$data = orphan_fields_ncn_array(); 
$THEME_DIR_URL = get_template_directory_uri();
$CAPTCHA_PLUGIN_URL = plugins_url() . '/really-simple-captcha/tmp/';

//require( ABSPATH . WPINC . '/ms-functions.php' );

 
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


// ADD JAVASCRIPT AND STYLE FOR HEADER
add_action('wp_head', 'add_javascript');
function add_javascript() 
{
	global $THEME_DIR_URL;
    $action_ajax_url = admin_url('admin-ajax.php');
    $site_url = get_site_url();
    
    echo <<<EOF
	<script type="text/javascript" src="{$THEME_DIR_URL}/js/tre-mo-coi/page-becomeparents.js"></script>
	<script>
		var action_ajax_url ='$action_ajax_url';
		var site_url ='$site_url';
	</script>
EOF;
}


// OTHER FUNCTIONS


// LOCAL VARIABLES
$captcha = create_captcha(); 
$prefix = $captcha['prefix'];
$file = $captcha['file'];
?>

<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2><?php if(function_exists('bcn_display')) {bcn_display(); } ?></h2>
					<div class="box-content">	
						
						<div data-alert="" class="alert-box alert" style="display:none;margin-bottom:5px;" id="becomeparents_success_container"></div>
						<div data-alert="" class="alert-box alert" style="display:none;margin-bottom:5px;" id="becomeparents_error_container"></div>
						<div id="becomeparents_success" style="display:none;">
							<div style="width: 600px; height: auto;" id="register">
								<div>
									<img width="600" src="<?php echo $THEME_DIR_URL?>/images/alert-lightbox-header.png">
								</div>
								<br>
								<div style="text-align:left;margin-top:20px;margin-bottom:30px;line-height:25px;">
									<div class="row">
										<div class="large-12 columns"><span style="font-weight:200;font-size:25px;">Chúc mừng bạn đã đăng ký nhận thông tin trẻ thành công!</span></div>
									</div>
									<br />
									<div class="row">
										<div class="large-12 columns">
											Chúng tôi đã sẽ gửi thông tin những trẻ phù hợp với nhu cầu của ban đến <br />địa chỉ <span id="email-and-duration"></span>.
										</div>
									</div>
									<br />
									<div class="row">
										<div class="large-12 columns">
											 <i><u>Ghi chú</u>: Bạn có thể hủy chức năng nhận email theo đường dẫn tại email mà bạn nhận được.</i>
										</div>
									</div>
									<br />
									<div class="row" style="text-align:center">
										<div class="large-6 columns">
											 <a id="back_to_home" >Trở lại trang chủ</a>
										</div>
										<div class="large-6 columns">
											 <a id="back_to_previous_page">Trở lại trang trước đó</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<form id="becomeparents_form" class="custom" method="post">
							<input type="hidden" name="become_parent" value="become_parent" />
							
							<fieldset>
								<div class="row">
									  <div class="large-12 columns">
										
										<p><span style="color:red;text-decoration:underline;font-weight:900;">Lưu ý:</span>
											Hệ thống sẽ gửi thông tin những trẻ mồ côi phù hợp nhu cầu của bạn vào địa chỉ email trong vòng <span id="email_duration" />3 tháng</span>. Bạn có thể hủy chức năng này ngay tại email của bạn bất cứ khi nào bạn muốn.
										</p>
										<br />
									  </div>
								</div>
								
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_name" class="inline">Họ tên <span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_name" id="txt_name" placeholder="Họ tên" value="<?php echo $current_user->display_name; ?>" disabled="disabled" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_email" class="inline">Email <span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  
									  <div class="row collapse">
										  <div class="small-9 columns">
											<input type="text" name="txt_email" id="txt_email" placeholder="Email liên lạc" value="<?php echo $current_user->user_email; ?>" disabled="disabled" />
										  </div>
										  <div class="small-3 columns">
											<span class="postfix" id="edit_email"><a>Sửa email</a></span>
											<span class="postfix" id="save_email" style="display:none"><a>Lưu email</a></span>
										  </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_address" class="inline">Địa chỉ <span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_address" id="txt_address" placeholder="Địa chỉ (số nhà, tên đường, thôn, xóm, phường xã)" value="<?php echo get_user_meta($current_user->ID, "address", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  &nbsp;
									</div>
									<div class="small-4 columns">
									  <input type="text" name="txt_district" id="txt_district" placeholder="Quận (Huyện)" value="<?php echo get_user_meta($current_user->ID, "district", true); ?>" />
									</div>
									<div class="small-5 columns">
									  <input name="txt_province" id="txt_province" type="text" placeholder="Tỉnh (Thành phố)" value="<?php echo get_user_meta($current_user->ID, "province", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_phone" class="inline">Điện thoại di động<span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_phone" id="txt_phone" placeholder="Ví dụ: 097 123 1233" value="<?php echo get_user_meta($current_user->ID, "phone", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_phone_static" class="inline">Điện thoại cố định</label>
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_phone_static" id="txt_phone_static" placeholder="Ví dụ: 043 1234123" value="<?php echo get_user_meta($current_user->ID, "phone_static", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_job" class="inline">Nghề nghiệp <span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_job" id="txt_job" placeholder="Nghề nghiệp" value="<?php echo get_user_meta($current_user->ID, "job", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_income" class="inline">Thu nhập</label>
									</div>
									<div class="small-9 columns">
									  
									  <div class="row collapse">
										  <div class="small-9 columns">
											<input type="text" name="txt_income" id="txt_income" placeholder="Thu nhập tối thiểu hàng tháng" value="<?php echo get_user_meta($current_user->ID, "income", true); ?>" />
										  </div>
										  <div class="small-3 columns">
											<span class="postfix">VNĐ</span>
										  </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label class="inline">Thời gian nhận email</label>
									</div>
									<div class="small-3 columns">
										<label onClick="email_duration(this);" for="rbn_email_duration1" class="inline"><input style="display:none" type="radio" name="rbn_email_duration" id="rbn_email_duration1" value="1" /> 1 tháng</label>
									</div>
									<div class="small-3 columns">
										<label onClick="email_duration(this);" for="rbn_email_duration3" class="inline"><input style="display:none" type="radio" name="rbn_email_duration" id="rbn_email_duration3" value="3" checked="checked" /> 3 tháng</label>
									</div>
									<div class="small-3 columns">
										<label onClick="email_duration(this);" for="rbn_email_duration6" class="inline"><input style="display:none" type="radio" name="rbn_email_duration" id="rbn_email_duration6" value="6" /> 6 tháng</label>
									</div>
								</div>
								
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_reason" class="inline">Lý do nhận con</label>
									</div>
									<div class="small-9 columns">
										<textarea name="txt_reason" id="txt_reason" placeholder="Lý do nhận con" rows="12"></textarea>
									</div>
								</div>
		
								<div class="panel">
								  <h6> Nhu cầu: </h4>
								  <hr />
								  <div class="row">
									  <div class="large-3 columns">
										<label class="inline">Năm sinh</label>
									  </div>
									  <div class="large-3 columns" align="left">
										<select name = "sel_birthyear" id="sel_birthyear">
											<?php 
												$tmpyear = date("Y");
												for($i=$tmpyear;$i>($tmpyear-12);$i--):
											?>
											<option value="<?php echo $i ?>"><?php echo $i ?></option>
											<?php endfor; ?>
										</select>
									  </div>
									  <div class="large-6 columns"></div>
									</div>
									
									<div class="row" >
									  <div class="large-3 columns">
										<label class="inline">Giới tính</label>
									  </div>
									  <div class="large-3 columns">
										<label for="gender1" class="inline"><input type="radio" name="rbn_gender" id="gender1" value="Nam" /> Nam</label>
									  </div>
									  <div class="large-3 columns">
										<label for="gender2" class="inline"><input type="radio" name="rbn_gender" id="gender2" value="Nữ" /> Nữ</label>
									  </div>
									  <div class="large-3 columns">
										<label for="gender3" class="inline"><input type="radio" name="rbn_gender" id="gender3" value="Nam / Nữ" checked="checked" /> Nam / Nữ</label>
									  </div>
									</div>
									
									<div class="row">
									  	<div class="large-3 columns">
											<label>Ghi chú</label>
										</div>
										<div class="large-9 columns">
											<textarea name="txt_note" id="txt_note" placeholder="Ghi chú"></textarea>
										</div>
									</div>
									
									<div class="row">
										<div class="large-3 columns">
										  <label for="txt_captcha" class="inline">Mã bảo mật <span class="require">*</span></label>
										</div>								
										<div class="small-9 columns">
										  <div class="left">
										  	<input type="text" style="width:100px;" name="txt_captcha" id="txt_captcha" placeholder="Mã bảo mật">
										  </div>
										  <div class="left"><img id="captcha_file" style="padding:0px; margin:0px 10px;" src="<?php echo $file; ?>" /></div>
										</div>								
									  	<input type="hidden" name="captcha_prefix" id="captcha_prefix" value="<?php echo $prefix; ?>" />
									</div>
									
								  	<div id="txt_captcha_error" style="display: none;">
								  		<div class="small-3 columns"></div>
										<label class="error" id="txt_captcha_error_label">Mã bảo mật không đúng. Vui lòng nhập lại.</label>
									</div>
								  
								</div>
								<div class="row">
									<div class="large-12 columns "><center>
										<button id="becomeparents_submit_button">Đăng ký</button>										
						
										<div style="z-index:10;display:none;" id="waiting">
											<div><img width="32" src="<?php echo $THEME_DIR_URL; ?>/images/wait.gif"></div>
											<div style="margin-top:5px;color:#999999;font-style:italic;">Đang xử lý thông tin...</div>
										</div></center>
									</div>
								</div>
		
							</fieldset>
						</form>
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
	<script type="text/javascript" src="<?php echo $THEME_DIR_URL; ?>/js/accounting.js"></script>
	<script type="text/javascript">

			$('#txt_income').keyup(function(){
				$(this).val( accounting.formatNumber($(this).val(),0," "));
			});
			$(document).ready(function(){
				$('#txt_income').val( accounting.formatNumber($('#txt_income').val(),0," "));
			});

	</script>
	
<?php 
get_footer() ;