<?php 

/**
 * Template Name: Đăng ký nhận trẻ Template
 * Description: A Page Template that shows form register
 * @author Long Nguyen and Ha Nguyen
 */

 global $current_user, $orphan_prefix;
 //$data = orphan_fields_ncn_array();
 
 if(isset($_POST["become_parent"]) && $_POST["become_parent"] == "become_parent")
 {
 	/*** AUTHOR INFO ***/
    $address_home = $_POST['txt_address']; //dia chi
    $address_district = $_POST['txt_district'];  // quan(huyen)
    $address_province = $_POST['txt_province']; //tinh
    $phone = $_POST['txt_phone']; // dien thoai
    $phone_static = $_POST['txt_phone_static']; // dt co dinh
    $job = $_POST['txt_job']; // nghe nghiep
    $income = $_POST['txt_income'];  // thu nhap
  	
	update_user_meta($current_user->ID, "address", $address_home);
	update_user_meta($current_user->ID, "district", $address_district);
	update_user_meta($current_user->ID, "province", $address_province);
	update_user_meta($current_user->ID, "phone", $phone);
	update_user_meta($current_user->ID, "phone_static", $phone_static);
	update_user_meta($current_user->ID, "job", $job);
	update_user_meta($current_user->ID, "income", $income);    
 	/*~~ AUTHOR INFO ~~*/
	
	
 	/*** POST INFO ***/
	$reason = $_POST['txt_reason'];
	$email_duration = $_POST['txt_email_duration'];    
	$birth_year = $_POST['txt_birthyear']; // nam sinh
	$gender = $_POST['txt_gender'];
	$note = $_POST['txt_note'];
	
	$my_post = array(
	  	'post_author'   => $current_user->ID,
	  	'post_type'     => 'nhan-con-nuoi',
	  	'post_title'    => 'Đón nhận yêu thương',
		'post_content' 	=> $reason,
		'post_status' 	=> 'cronjob'
	);

	// Insert the post into the database
	$post_id = wp_insert_post( $my_post );
	
	update_post_meta($post_id, $orphan_prefix .'ncn_ly_do', $reason);
	update_post_meta($post_id, $orphan_prefix .'ncn_email_duration', $email_duration);
	update_post_meta($post_id, $orphan_prefix .'ncn_nam_sinh', $birth_year);
	update_post_meta($post_id, $orphan_prefix .'ncn_gioi_tinh', $gender);
	update_post_meta($post_id, $orphan_prefix .'ncn_ghi_chu', $note);
 	/*~~ POST INFO ~~*/  
	
	
	wp_redirect(home_url("dang-ky-nhan-mail-thanh-cong"));
}
?>

<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Đón nhận yêu thương</h2>
					<div class="box-content list-2">
						<form class="custom" method="post">
							<input type="hidden" name="become_parent" value="become_parent" />
							
							<fieldset>
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
									  <label for="txt_mail" class="inline">Email <span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  
									  <div class="row collapse">
										  <div class="small-9 columns">
											<input type="text" name="txt_email" id="txt_mail" placeholder="Email liên lạc" value="<?php echo $current_user->user_email; ?>" disabled="disabled" />
										  </div>
										  <div class="small-3 columns">
											<span class="postfix"><a href="<?php echo get_site_url();?>/wp-admin/profile.php?updated=1" >Sửa email</a></span>
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
									  <input type="text" name="txt_district" placeholder="Quận (Huyện)" value="<?php echo get_user_meta($current_user->ID, "district", true); ?>" />
									</div>
									<div class="small-5 columns">
									  <input name="txt_province" type="text" placeholder="Tỉnh (Thành phố)" value="<?php echo get_user_meta($current_user->ID, "province", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_phone" class="inline">Điện thoại <span class="require">*</span></label>
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_phone" id="txt_phone" placeholder="Số điện thoại liên lạc" value="<?php echo get_user_meta($current_user->ID, "phone", true); ?>" />
									</div>
								</div>
								<div class="row">
									<div class="small-3 columns">
									  &nbsp;
									</div>
									<div class="small-9 columns">
									  <input type="text" name="txt_phone_static" placeholder="Số điện thoại cố định (tùy chọn)" value="<?php echo get_user_meta($current_user->ID, "phone_static", true); ?>" />
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
										<label onClick="javascript:email_duration(this);" for="txt_email_duration1" class="inline"><input style="display:none" type="radio" name="txt_email_duration" id="txt_email_duration1" value="1" /> 1 tháng</label>
									</div>
									<div class="small-3 columns">
										<label onClick="javascript:email_duration(this);" for="txt_email-duration3" class="inline"><input style="display:none" type="radio" name="txt_email_duration" id="txt_email_duration3" value="3" checked="checked" /> 3 tháng</label>
									</div>
									<div class="small-3 columns">
										<label onClick="javascript:email_duration(this);" for="txt_email_duration6" class="inline"><input style="display:none" type="radio" name="txt_email_duration" id="txt_email_duration6" value="6" /> 6 tháng</label>
									</div>
								</div>
								
								<div class="row">
									<div class="small-3 columns">
									  <label for="txt_reason" class="inline">Lý do nhận nuôi</label>
									</div>
									<div class="small-9 columns">
										<textarea name="txt_reason" id="txt_reason" placeholder="Lý do nhận con nuôi" rows="12"></textarea>
									</div>
								</div>
		
								<div class="panel">
								  <h6> Nhu cầu: </h4>
								  <hr />
								  <div class="row">
									  <div class="large-3 columns">
										<label class="inline">Năm sinh</label>
									  </div>
									  <div class="large-3 columns" align="right">
										<select name = "txt_birthyear">
											<?php 
												$tmpyear = date("Y");
												for($i=$tmpyear;$i>($tmpyear-12);$i--):
											?>
											<option value="<?php echo $i ?>"><?php echo $i ?></option>
											<?php endfor; ?>
										</select>
									  </div>
									</div>
									
									<div class="row" >
									  <div class="large-3 columns">
										<label class="inline">Giới tính</label>
									  </div>
									  <div class="large-3 columns">
										<label for="gender1" class="inline"><input type="radio" name="txt_gender" id="gender1" value="Nam" /> Nam</label>
									  </div>
									  <div class="large-3 columns">
										<label for="gender2" class="inline"><input type="radio" name="txt_gender" id="gender2" value="Nữ" /> Nữ</label>
									  </div>
									  <div class="large-3 columns">
										<label for="gender3" class="inline"><input type="radio" name="txt_gender" id="gender3" value="Nam / Nữ" checked="checked" /> Nam / Nữ</label>
									  </div>
									</div>
									
									<div class="row">
									  <div class="large-12 columns">
										<label>Ghi chú</label>
										<textarea name="txt_note" placeholder="Ghi chú"></textarea>
									  </div>
									</div>
								  
								</div>
								<div class="row">
									  <div class="large-12 columns">
										
										<p><span style="color:red;text-decoration:underline;font-weight:900;">Lưu ý:</span>
											Hệ thống sẽ gửi thông tin những trẻ mồ côi phù hợp nhu cầu của bạn vào địa chỉ email trong vòng <span id="email_duration" />3 tháng</span>. Bạn có thể hủy chức năng này ngay tại email của bạn bất cứ khi nào bạn muốn.
										</p>
									  </div>
								</div>
								<div class="row">
									<div class="large-12 columns text-center">
										<button>Đăng ký</button>
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
	
<?php 
get_footer() ;
?>

<script>
function email_duration(obj)
{ 
	$("#email_duration").html($(obj).text());
}
</script>