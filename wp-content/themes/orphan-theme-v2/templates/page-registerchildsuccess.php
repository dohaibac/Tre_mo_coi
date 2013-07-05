<?php 

/**
 * Template Name: Nhập thông tin trẻ mồ côi thành công
 * Description: A Page Template that shows form register
 * @author Phi Ho
 */
 global $current_user;
get_header();
?>

	<div class="row main-content">
		<div class="large-8 columns">

			<div class="row sidebar-box shadow-box" style ="height:100%; padding:20px">
				<p>Cảm ơn bạn đã nhập Thông tin trẻ mồ côi thành công!
				<br />
				Click <a href="<?php bloginfo('home');?>/">vào đây</a> để quay lại trang chủ
				</p>
			</div>
		</div>

		<?php get_sidebar(); ?>
	</div>

 <?php 
 get_footer();
 ?>