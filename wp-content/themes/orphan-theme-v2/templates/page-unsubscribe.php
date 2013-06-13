<?php 

/**
 * Template Name: Hủy nhận thông tin Template
 * Description: A Page Template that shows unsubscipbe email 
 * @author Long Nguyen and Ha Nguyen
 */

 global $current_user, $orphan_prefix;
 if(isset($_REQUEST['unsubscripbe']) && $_REQUEST['unsubscripbe']){
 	//phân tích thông tin truyền về bao gồm id post và md5(user_id.user_email."aJ#FTUkk")
 	// tremocoi.org/huy-email/?unsubscripbe=base64_encode(post_id."|".md5(user_id.user_email."aJ#FTUkk"))
 	$thongtin = base64_decode($_REQUEST['unsubscripbe']);
 	$arr_thongtin = explode("|",$thongtin);
 	$us_post_id = $arr_thongtin[0];
 	$us_post = get_post($us_post_id);
 	$us_user_email = get_the_author_meta( "user_email", $us_post->post_author);
 	$us_check = ((md5($us_post->post_author.$us_user_email."aJ#FTUkk") == $arr_thongtin[1]) && ($us_post->post_status != "draft"))? 1:0;
 	if($us_check == 1){
 		$my_post = array();
  		$my_post['ID'] = $us_post_id;
  		$my_post['post_status'] = 'draft';
  		$is_success = wp_update_post( $my_post );
  		if($is_success != 0):
  			get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Hủy email thành công </h2>
					<div class="box-content list-2">
						Cảm ơn bạn đã nhận thông tin từ website trong thời gian qua. Chúc bạn luôn vui vẻ, hạnh phúc.
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div><!--end .large-8-->

<?php
  			get_sidebar();
  			get_footer() ; 
  			exit(); 			
  		endif;
 	}
 }
 
?>

<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Thông báo</h2>
					<div class="box-content list-2">
						Đã có lỗi xảy ra. Bạn vui lòng kiểm tra lại thao tác.
						<!--
							<a href="<?php echo home_url("/huy-email/?unsubscripbe=".base64_encode("163|".md5("1bac.do@evizi.comaJ#FTUkk")));?>">test</a>
						-->					
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
	
<?php 
get_footer() ;
?>