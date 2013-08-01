<?php 
/**
 * Template Name: Hủy nhận thông tin tìm người thân
 * Description: A Page Template that shows unsubscipbe email 
 * @author Vinh.le
 */
 global $current_user;
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2><?php if(function_exists('bcn_display'))	{bcn_display();	} ?></h2>
					<div class="box-content list-2">
						<?php the_content();
							if(isset($_REQUEST['unsubscripbe']) && $_REQUEST['unsubscripbe']){
								//phân tích thông tin truyền về bao gồm user_id và md5(user_id.user_email."aJ#FTUkk")
								// tremocoi.org/huy-nhan-email-tim-nguoi-than/?unsubscripbe=base64_encode(user_id."|".md5(user_id.user_email."aJ#FTUkk"))
								$thongtin = base64_decode($_REQUEST['unsubscripbe']);
								$arr_thongtin = explode("|",$thongtin);
								$check_user_id = isset($arr_thongtin[0]) ? $arr_thongtin[0] : null ;
								$check_code = isset($arr_thongtin[1]) ? $arr_thongtin[1] : null ;
								if($check_code && $check_user_id){
									$get_user_data = get_userdata($check_user_id);
									if(isset($get_user_data->ID)){
										$us_check = (md5($get_user_data->ID.$us_user_email."aJ#FTUkk") == $arr_thongtin[1]) ? 1:0;
										if($us_check == 1){
											update_usermeta( $check_user_id, 'status_sendmail_tnt', false);
											echo '<p>Hủy gởi thông tin tìm người thân thành công. Hệ thống sẽ tự động chuyển sang trang chủ sau 5 giây.</p>
												<script type="text/javascript">
													jQuery(function($){
													setTimeout(function() {
														window.location = "'.home_url().'";
												   }, 5000);
												   });
												</script>
											';
										}
									} else {
										echo '<p>Thông tin thành viên không tồn tại. Hệ thống sẽ tự động chuyển sang trang chủ sau 5 giây.</p>
											<script type="text/javascript">
												jQuery(function($){
												setTimeout(function() {
													window.location = "'.home_url().'";
											   }, 5000);
											   });
											</script>
										';
									}
								} else {
									echo '<p>Thông tin không tồn tại. Hãy kiểm tra lại thông tin. Bạn có thể <a href="'.home_url().'/lien-he">liên hệ </a> để được tư vấn thông tin.</p>';
								}
							} else {
								echo '<p>Thông tin không hợp lệ. Hệ thống sẽ tự động chuyển sang trang chủ sau 5 giây.</p>
											<script type="text/javascript">
												jQuery(function($){
												setTimeout(function() {
													window.location = "'.home_url().'";
											   }, 5000);
											   });
											</script>
										';
							}
							
						?>
					</div>
				<?php endif; ?>	
				
			</div>
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
<?php get_footer() ;?>