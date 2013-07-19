<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	
					$parent_photo = get_post_meta( get_the_ID(), 'orphan_parent_photo', true );
					if($parent_photo == '') $parent_photo = get_template_directory_uri().'/images/no_image.png' ;
					$user_post_id = isset($posts[0]->post_author) ? $posts[0]->post_author : null;
					$get_userdata =  get_userdata( $user_post_id); 
					$user_avatars = get_user_meta($user_post_id, "user_avatars", true);
				?>
					<h2><?php if(function_exists('bcn_display'))	{bcn_display();	} ?></h2>
					<div class="box-content list-2">
						<div class="row style_border_bottom">
						<div class="large-6 columns">
							<div class="row">
								<h3><a href="<?php the_permalink(); ?>" class="btn"><?php the_title(); ?></a></h3>
								<div class="large-3 columns">
									<img class="thumb" src="<?php echo $user_avatars; ?>" alt="<?php the_title(); ?>" width="226" height="93">
								</div>
								<div class="large-9 columns">
									<h3>Tên con : Lê Văn Con</h3>
									
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
											$html .= '<li>Địa chỉ : '.$gender.'</li>';
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
								</div>
							</div>
						</div>
						<div class="large-6 columns">
							<h3>Tìm Bố/Mẹ với thông tin</h3>
							<div class="row">
								<div class="large-3 columns">
									<img class="thumb" src="<?php echo $parent_photo; ?>" alt="<?php the_title(); ?>" width="226" height="93">
								</div>
								<div class="large-9 columns">
									<h3>Tên Bố/Mẹ: 
										<?php 
											$parent_name = get_post_meta( get_the_ID(), 'orphan_parent_name', true );
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
					</div>
						<div class="row">
							<div class="large-12 columns">
								<?php echo get_post_meta( get_the_ID(), 'orphan_description', true ); ?>
							</div>
						</div>
						
						<br />
						<div class="facebook-like">
						<div class="fb-like fb_edge_widget_with_comment fb_iframe_widget" data-href="<?php the_permalink(); ?>" data-send="true" data-layout="standard" data-width="500" data-show-faces="true" data-font="trebuchet ms"></div>
						</div>
						<?php if(comments_open()){
							echo '<hr />';
							comments_template();
						}
						?>
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
<?php get_footer() ;?>