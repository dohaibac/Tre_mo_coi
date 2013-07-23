<?php 
/**
 * Template Name: Garden Dreams
 * Description: A Page Template that shows form 'Tìm người thân'
 * @author VinhLe
 */
global $current_user;
get_header();

// CHECK LOGIN
if($current_user->ID == null){
	?>
	<script>
	alert("Bạn cần đăng nhập và kích hoạt tài khoản trước khi sử dụng chức năng này.");
	document.location.href = '<?php echo home_url()?>';
	</script>
	<?php
}
else {
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
?>
<div class="garden_dreams">
	<a href="<?php echo get_permalink( get_page_by_path( 'viet-bai-vuon-uoc-mo' ) );?>" class="add-new-garden-dreams fancybox-vuon-yeu-thuong">Đăng bài viết</a>

	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Đăng bài viết</h2>
					<div class="box-content list-2">
						<br/>
						<?php echo form_add_new_garden_dream(); ?>
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar('vuon-uoc-mo'); ?>
</div>
<?php get_footer() ;?>