<?php 
/**
 * Template Name: Tìm người thân
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
wp_enqueue_script('jquery-ui',get_bloginfo('template_directory').'/includes/js/jquery-ui.js');
wp_enqueue_script('ui.datepicker-vi',get_bloginfo('template_directory').'/includes/js/ui.datepicker-vi.js');
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo get_bloginfo('template_directory')?>/includes/css/custom-meta-post.css" />
<div class="large-8 columns content">
	<div class="row">
		<div class="row shadow-box">
			<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
			<h2><?php if(function_exists('bcn_display')) {bcn_display(); } ?></h2>
			<div class="box-content">
				<p>
					Tìm thông tin người thân. Nhập thông tin theo form bên dưới. Chúng tôi sẽ cập nhật thông tin và liên hệ với bạn qua điện thoại hoặc email.
				</p>
				<!--Begin Tabs -->
				<?php
					wp_enqueue_script('jquery-ui',get_bloginfo('template_directory').'/includes/js/jquery-ui.js');
					wp_enqueue_script('ui.datepicker-vi',get_bloginfo('template_directory').'/includes/js/ui.datepicker-vi.js');
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_style('thickbox');
				?>
				
				<div class="section-container auto" data-section>
				  <?php echo orphan_parent_looking_for_relatives()?>
				  <?php echo orphan_children_looking_for_relatives()?>
				</div>
				<script>
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
				</script>
				<!--End Tabs -->
				
				<style>
					.section-container{ margin-bottom:0px;}
				</style>
			</div>
			<?php endif; ?>	
		</div>

	</div>
	
</div>
<?php get_sidebar();
 get_footer();
 ?>