<?php
while (have_posts()) : the_post();
	update_post_caches($posts);
	$parent_photo = get_post_meta( get_the_ID(), 'orphan_parent_photo', true );
	if($parent_photo == '') $parent_photo = get_template_directory_uri().'/images/no_image.png' ;
	$user_post_id = get_the_author_meta( 'ID' );
	$get_userdata =  get_userdata( $user_post_id); 
	$user_avatars = get_avatar( get_the_author_meta( 'ID' ), 50 );
	?>
	<div class="row style_border_bottom">
		<div class="large-6 columns">
			<h3>Tìm Bố/Mẹ với thông tin</h3>
			<div class="row">
				<?php $parent_name = get_post_meta( get_the_ID(), 'orphan_parent_name', true ); ?>
				<div class="large-3 columns">
					<img class="thumb" src="<?php echo $parent_photo; ?>" alt="<?php echo $parent_name; ?>" width="50" height="50">
				</div>
				<div class="large-9 columns">
					<h3>Tên Bố/Mẹ: 
						<?php 
							if($parent_name!=''){
								echo $parent_name;
							}
						?>
					</h3>
					<ul style="margin-bottom:0px;">
						<?php 
							$parent_job = get_post_meta( get_the_ID(), 'orphan_parent_job', true );
							if($parent_job!=''){
								echo '<li>Điện thoại: '.$parent_job.'</li>';
							}
						?>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<ul>
						<?php 
							$parent_job = get_post_meta( get_the_ID(), 'orphan_parent_job', true );
							if($parent_job!=''){
								echo '<li>Nghề nghiệp: '.$parent_job.'</li>';
							}
						?>
						<?php 
							$parent_time_lost = get_post_meta( get_the_ID(), 'orphan_parent_time_lost', true );
							if($parent_time_lost!=''){
								echo '<li>Thời gian lạc: '.$parent_time_lost.'</li>';
							}
						?>
						<?php 
							$parent_place_lost = get_post_meta( get_the_ID(), 'orphan_parent_place_lost', true );
							if($parent_place_lost!=''){
								echo '<li>Địa điểm lạc: '.$parent_place_lost.'</li>';
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="large-6 columns">
			<div class="row">
				<h3>Thông tin con</h3>
				<div class="large-3 columns">
					<?php echo $user_avatars; ?>
				</div>
				<div class="large-9 columns">
					<h3>Tên con : <?php echo $get_userdata->display_name; ?></h3>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<?php 
						$html = '';
						$phone = get_user_meta($user_post_id, "phone", true);
						if($phone){
							$html .= '<li>Điện thoại : '.$phone.'</li>';
						}
						$gender = get_user_meta($user_post_id, "gender", true);
						if($gender){
							$html .= '<li>Giới tính : '.$gender.'</li>';
						}
						if(isset($get_userdata->user_email)){
							$html .= '<li>Email : '.$get_userdata->user_email.'</li>';
						}
						$address = get_user_meta($user_post_id, "address", true);
						if($address){
							$html .= '<li>Địa chỉ : '.$address.'</li>';
						}
						if($html!=''){
							echo '<ul>'.$html.'</ul>';
						}
					?>
					<a href="<?php the_permalink(); ?>" class="btn read-more-01">Xem chi tiết...</a>
				</div>
			</div>
		</div>
	</div>
<?php endwhile; ?>