<?php 

/**
 * Template Name: Nhập thông tin trẻ mồ côi
 * Description: A Page Template that shows form register
 * @author Phi Ho
 */
 global $current_user;
get_header();
?>

	<div class="row main-content">
		<div class="large-8 columns">

			<div class="panel" style ="margin-top: 10px;">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
				<h3><span style="font-size:0.8em;">Nhập thông tin trẻ mồ côi</span></h3>
				<hr />
				<?php 
				if($_POST['action'] == 1){
				insert_tre_mo_coi($_POST); }?>
				<form class="custom" action="<?php the_permalink() ?>" method="POST">
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
									<option value="0">Chọn ngày</option>
									<?php 
										for($i=1;$i <=31 ;$i++):
									?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php endfor; ?>
								</select>
							</div>
							<div class="small-3 columns">
								<select name = "cbx-month">
									<option value="0">Chọn tháng</option>
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
								<label class="inline">Hình ảnh</label>
							</div>							
							<div class="small-9 columns">
								<label for="gender1" class="inline">
								<input type="file" name="file-hinhanh" id="file-hinhanh" value="1" class="inline" size="50"/></label>
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
									<input type="text" name="txt-content" id="txt-content" placeholder="Tình trạng" />
								</div>
							</div>
						</div>
						<div class="row">
							  <div class="large-12 columns">
								
							  </div>
						</div>
						<div class="row">
							<div class="large-12 columns text-center">
								<button>Đăng ký</button>
							</div>
						</div>

					</fieldset>
				</form>
				<?php endif; ?>
			</div>


		</div>

		<?php get_sidebar(); ?>
	</div>

 <?php 
 get_footer();
 ?>