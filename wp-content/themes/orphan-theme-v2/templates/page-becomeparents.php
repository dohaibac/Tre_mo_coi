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
    $address_home = $_POST['txt-address']; //dia chi
    $address_district = $_POST['txt-district'];  // quan(huyen)
    $address_province = $_POST['txt-province']; //tinh
    $phone = $_POST['txt-phone']; // dien thoai
    $phone_static = $_POST['txt-phone-static']; // dt co dinh
    $job = $_POST['txt-job']; // nghe nghiep
    $income = $_POST['txt-income'];  // thu nhap
  	
	update_user_meta($current_user->ID, "address", $address_home);
	update_user_meta($current_user->ID, "district", $address_district);
	update_user_meta($current_user->ID, "province", $address_province);
	update_user_meta($current_user->ID, "phone", $phone);
	update_user_meta($current_user->ID, "phone_static", $phone_static);
	update_user_meta($current_user->ID, "job", $job);
	update_user_meta($current_user->ID, "income", $income);    
 	/*~~ AUTHOR INFO ~~*/
	
	
 	/*** POST INFO ***/
	$reason = $_POST['txt-reason'];
	$email_duration = $_POST['txt-email-duration'];    
	$birth_year = $_POST['txt-birthyear']; // nam sinh
	$gender = $_POST['txt-gender'];
	$note = $_POST['txt-note'];
	
	$my_post = array(
	  	'post_author'   => $current_user->ID,
	  	'post_type'     => 'nhan-con-nuoi',
	  	'post_title'    => 'Nhận con nuôi',
		'post_content' 	=> $reason,
		'post_status' 	=> 'cronjob'
	);

	// Insert the post into the database
	$post_id = wp_insert_post( $my_post );
	
	update_post_meta($post_id, $orphan_prefix .'ncn-ly-do', $reason);
	update_post_meta($post_id, $orphan_prefix .'ncn_email_duration', $email_duration);
	update_post_meta($post_id, $orphan_prefix .'ncn-nam-sinh', $birth_year);
	update_post_meta($post_id, $orphan_prefix .'ncn-gioi-tinh', $gender);
	update_post_meta($post_id, $orphan_prefix .'ncn_ghi-chu', $note);
 	/*~~ POST INFO ~~*/  
	
	
	wp_redirect(home_url("dang-ky-nhan-mail-thanh-cong"));
}
get_header();
?>

	<div class="row main-content">
		<div class="large-8 columns">

			<div class="panel" style ="margin-top: 10px;">
				<h3><span style="font-size:0.8em;">Đón nhận yêu thương</span></h3>
				<hr />
				<form class="custom" method="post">
					<input type="hidden" name="become_parent" value="become_parent" />
					
					<fieldset>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-name" id="txt-name" placeholder="Họ tên" value="<?php echo $current_user->display_name; ?>" disabled="disabled" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-mail" class="inline">Email <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  
							  <div class="row collapse">
								  <div class="small-9 columns">
									<input type="text" name="txt-email" id="txt-mail" placeholder="Email liên lạc" value="<?php echo $current_user->user_email; ?>" disabled="disabled" />
								  </div>
								  <div class="small-3 columns">
									<span class="postfix"><a href="<?php echo get_site_url();?>/wp-admin/profile.php?updated=1" >Sửa email</a></span>
								  </div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-address" class="inline">Địa chỉ <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-address" id="txt-address" placeholder="Địa chỉ (số nhà, tên đường, thôn, xóm, phường xã)" value="<?php echo get_user_meta($current_user->ID, "address", true); ?>" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  &nbsp;
							</div>
							<div class="small-4 columns">
							  <input type="text" name="txt-district" placeholder="Quận (Huyện)" value="<?php echo get_user_meta($current_user->ID, "district", true); ?>" />
							</div>
							<div class="small-5 columns">
							  <input name="txt-province" type="text" placeholder="Tỉnh (Thành phố)" value="<?php echo get_user_meta($current_user->ID, "province", true); ?>" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-phone" class="inline">Điện thoại <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-phone" id="txt-phone" placeholder="Số điện thoại liên lạc" value="<?php echo get_user_meta($current_user->ID, "phone", true); ?>" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  &nbsp;
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-phone-static" placeholder="Số điện thoại cố định (tùy chọn)" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-job" class="inline">Nghề nghiệp <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-job" id="txt-job" placeholder="Nghề nghiệp" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-income" class="inline">Thu nhập</label>
							</div>
							<div class="small-9 columns">
							  
							  <div class="row collapse">
								  <div class="small-9 columns">
									<input type="text" name="txt-income" id="txt-income" placeholder="Thu nhập tối thiểu hàng tháng" />
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
								<label for="txt-email-duration1" class="inline"><input type="radio" name="txt-email-duration" id="txt-email-duration1" value="1" onclick="javascript:email_duration('txt-email-duration1');" style="display:none;" /> 1 Tháng</label>
							</div>
							<div class="small-3 columns">
								<label for="txt-email-duration3" class="inline"><input type="radio" name="txt-email-duration" id="txt-email-duration3" value="3" onclick="javascript:email_duration('txt-email-duration3');" checked="checked" style="display:none;" /> 3 Tháng</label>
							</div>
							<div class="small-3 columns">
								<label for="txt-email-duration6" class="inline"><input type="radio" name="txt-email-duration" id="txt-email-duration6" value="6" onclick="javascript:email_duration('txt-email-duration6');" style="display:none;" /> 6 Tháng</label>
							</div>
						</div>
						
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-reason" class="inline">Lý do nhận nuôi </label>
							</div>
							<div class="small-9 columns">
								<textarea name="txt-reason" id="txt-reason" placeholder="Lý do nhận con nuôi" rows="12"></textarea>
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
								<select name = "txt-birthyear">
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
								<label for="gender1" class="inline"><input type="radio" name="txt-gender" id="gender1" value="Nam" style="display:none;" /> Nam</label>
							  </div>
							  <div class="large-3 columns">
								<label for="gender2" class="inline"><input type="radio" name="txt-gender" id="gender2" value="Nữ" style="display:none;" /> Nữ</label>
							  </div>
							  <div class="large-3 columns">
								<label for="gender3" class="inline"><input type="radio" name="txt-gender" id="gender3" value="Nam / Nữ" checked="checked" style="display:none;" /> Nam / Nữ</label>
							  </div>
							</div>
							
							<div class="row">
							  <div class="large-12 columns">
								<label>Ghi chú</label>
								<textarea name="txt-note" placeholder="Ghi chú"></textarea>
							  </div>
							</div>
						  
						</div>
						<div class="row">
							  <div class="large-12 columns">
								
								<p><span style="color:red;text-decoration:underline;font-weight:900;">Lưu ý:</span>
									Hệ thống sẽ gửi thông tin những trẻ mồ côi phù hợp nhu cầu của bạn vào địa chỉ email trong vòng <span id="email_duration" /></span> tháng. Bạn có thể hủy chức năng này ngay tại email của bạn bất cứ khi nào bạn muốn.
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


		</div>

		<?php get_sidebar(); ?>
	</div>

 <?php 
 get_footer();
 ?>
 
<script>
function email_duration(obj_id)
{
	$("#email_duration").html($("#"+obj_id).val());
}

email_duration("txt-email-duration3");
</script>