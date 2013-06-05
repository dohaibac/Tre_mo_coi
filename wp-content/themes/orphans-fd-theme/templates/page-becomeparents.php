<?php 

/**
 * Template Name: Đăng ký nhận trẻ Template
 * Description: A Page Template that shows form register
 * @author Long Nguyen
 */
 global $current_user;
get_header();
?>

	<div class="row main-content">
		<div class="large-8 columns">

			<div class="panel" style ="margin-top: 10px;">
				<h3><span style="font-size:0.8em;">Đón nhận yêu thương</span></h3>
				<hr />
				<form class="custom">
					<fieldset>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-name" id="txt-name" placeholder="Họ tên" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-address" class="inline">Địa chỉ <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-address" id="txt-address" placeholder="Địa chỉ (số nhà, tên đường, thôn, xóm, phường xã)" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  &nbsp;
							</div>
							<div class="small-4 columns">
							  <input type="text" name="txt-district" placeholder="Quận (Huyện)" />
							</div>
							<div class="small-5 columns">
							  <input name="txt-province" type="text" placeholder="Tỉnh (Thành phố)" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-phone" class="inline">Điện thoại <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-phone" id="txt-phone" placeholder="Số điện thoại liên lạc" />
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
							  <label for="txt-mail" class="inline">Email <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-email" id="txt-mail" placeholder="Email liên lạc" value="<?php echo $current_user->user_email; ?>" disabled="disabled" />
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
							  <label for="txt-issue" class="inline">Lý do nhận nuôi <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
								<textarea name="txt-issue" id="txt-issue" placeholder="Lý do nhận con nuôi" rows="12"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label class="inline">Nhận email</label>
							</div>
							<div class="small-3 columns">
								<label for="gender1" class="inline"><input type="radio" style="display:none;" name="txt-month-email" value="1" checked="checked" /> 1 Tháng</label>
							</div>
							<div class="small-3 columns">
								<label for="gender1" class="inline"><input type="radio" style="display:none;" name="txt-month-email" value="2" /> 3 Tháng</label>
							</div>
							<div class="small-3 columns">
								<label for="gender1" class="inline"><input type="radio" style="display:none;" name="txt-month-email" value="3" /> 6 Tháng</label>
							</div>
						</div>

						<div class="panel">
						  <h6> Nhu cầu: </h4>
						  <hr />
						  <div class="row">
							  <div class="large-2 columns">
								<label class="inline">Năm sinh</label>
							  </div>
							  <div class="large-3 columns">
								<select name = "txt-birthday">
									<?php 
										$tmpyear = date("Y");
										for($i=$tmpyear;$i>($tmpyear-12);$i--):
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php endfor; ?>
								</select>
							  </div>
							  <div class="large-2 columns">
								<label class="inline">Giới tính</label>
							  </div>
							  <div class="large-5 columns">
								  <div class="large-6 columns">
									<label for="gender1" class="inline"><input type="radio" style="display:none;" name="txt-gender" id="gender1" value="1" checked="checked" /> Nam</label>
								  </div>
								  <div class="large-6 columns">
									<label for="gender2" class="inline"><input type="radio" style="display:none;" name="txt-gender" id="gender2" value="2" /> Nữ</label>
								  </div>
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
									Bạn vui lòng nhập chính xác email, hệ thống sẽ gửi những thông tin bạn cần vào email này trong khoảng thời gian bạn đăng ký
									nhận tin. Bạn có thế ngừng nhận email bất kỳ lúc nào bạn muốn.
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