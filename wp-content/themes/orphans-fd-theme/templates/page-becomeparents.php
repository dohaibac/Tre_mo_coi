<?php 

/**
 * Template Name: Đăng ký nhận trẻ Template
 * Description: A Page Template that shows form register
 * @author Long Nguyen
 */
get_header();
?>

	<div class="row main-content">
		<div class="large-8 columns">

			<div class="panel" style ="margin-top: 10px;">
				<h3> Kết nối yêu thương: <span style="font-size:0.6em;">mở lòng để đón thêm một tình yêu</span></h3>
				<hr />
				<form class="custom">
					<fieldset>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-name" class="inline">Họ tên</label>
							</div>
							<div class="small-9 columns">
							  <input type="text" id="txt-name" placeholder="Họ tên" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-address" class="inline">Địa chỉ</label>
							</div>
							<div class="small-4 columns">
							  <input type="text" id="txt-address" placeholder="Thành phố" />
							</div>
							<div class="small-5 columns">
							  <input type="text" placeholder="Quận (Huyện)" />
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-phone" class="inline">Điện thoại</label>
							</div>
							<div class="small-9 columns">
							  <input type="text" id="txt-phone" placeholder="Số điện thoại liên lạc" />
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
								<select>
									<option value="2013">2013</option>
									<option value="2013">2013</option>
									<option value="2013">2013</option>
								</select>
							  </div>
							  <div class="large-2 columns">
								<label class="inline">Giới tính</label>
							  </div>
							  <div class="large-5 columns">
								  <div class="large-6 columns">
									<label class="inline"><input type="radio" style="display:none;" name="txt-gender" /> Nam</label>
								  </div>
								  <div class="large-6 columns">
									<label class="inline"><input type="radio" style="display:none;" name="txt-gender" /> Nữ</label>
								  </div>
							  </div>
							</div>
							
							<div class="row">
							  <div class="large-12 columns">
								<label>Ghi chú</label>
								<textarea placeholder="Ghi chú"></textarea>
							  </div>
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