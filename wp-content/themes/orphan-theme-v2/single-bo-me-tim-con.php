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
									<h3>Thông ton bố/mẹ</h3>
									<div class="large-3 columns">
										<a href="<?php the_permalink(); ?>" class="btn"><img class="thumb" src="<?php echo $user_avatars; ?>" alt="<?php the_title(); ?>" width="226" height="93"></a>
									</div>
									<div class="large-9 columns">
										<h3>Tên bố/mẹ : <?php echo $get_userdata->display_name; ?></h3>
										
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
								<h3>Tìm con với thông tin</h3>
								<div class="row">
									<div class="large-3 columns">
										<a href="<?php the_permalink(); ?>" class="btn"><img class="thumb" src="<?php echo $children_photo; ?>" alt="<?php the_title(); ?>" width="226" height="93"></a>
									</div>
									<div class="large-9 columns <?php the_ID(); ?>">
										<h3>Tên con: 
											<?php 
												$children_name = get_post_meta( get_the_ID(), 'orphan_children_name', true );
												//var_dump($children_name);
												if($children_name!=''){
													echo $children_name;
												}
											?>
										</h3>
										
									</div>
								</div>
								<div class="row">
									<div class="large-12 columns">
										<ul>
											<?php 
												$children_birthday = get_post_meta( get_the_ID(), 'orphan_children_birthday', true );
												if($children_birthday!=''){
													echo '<li>Tuổi: '.$children_birthday.'</li>';
												}
											?>
											<?php 
												$children_gender = get_post_meta( get_the_ID(), 'orphan_children_gender', true );
												if($children_gender!=''){
													echo '<li>Giới tính: '.$children_gender.'</li>';
												}
											?>
											<?php 
												$children_time_lost = get_post_meta( get_the_ID(), 'orphan_children_time_lost', true );
												if($children_time_lost!=''){
													echo '<li>Thời gian lạc: '.$children_time_lost.'</li>';
												}
											?>
											<?php 
												$children_place_lost = get_post_meta( get_the_ID(), 'orphan_children_place_lost', true );
												if($children_place_lost!=''){
													echo '<li>Địa điểm lạc: '.$children_place_lost.'</li>';
												}
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<h3>Đặc điểm chung:</h3>
								<?php echo get_post_meta( get_the_ID(), 'orphan_children_description', true ); ?>
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