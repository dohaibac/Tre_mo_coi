<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2><?php if(function_exists('bcn_display'))	{bcn_display();	} ?></h2>
					<div class="box-content list-2">
						<div style="font-style:italic;"><small><?php the_time('d F, Y') ?> bởi <?php the_author_posts_link() ?> </small></div>
						<br />
						<?php 
						$image = get_post_meta( get_the_ID(), 'orphan_photo', true );
						if($image == '') $image = get_template_directory_uri().'/images/no_image.png' ;
						$birdthday = get_post_meta( get_the_ID(), 'orphan_birthday', true );
						$gender = get_post_meta( get_the_ID(), 'orphan_gender', true );
						$address = get_post_meta( get_the_ID(), 'orphan_cv-address', true );
						$time_meet = get_post_meta( get_the_ID(), 'orphan_cv-time', true );
						$content = get_post_meta( get_the_ID(), 'orphan_cv-content', true );
						?>
						<div class="row">
							<div class="large-4 columns">
								<a rel="tooltip" href="<?php the_permalink(); ?>" class="btn">
									<img class="thumb" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" width="226" height="93">
								</a>
							</div>
							<div class="large-8 columns">
								<h3><a rel="tooltip" href="<?php the_permalink(); ?>" class="btn"><?php the_title(); ?></a></h3>
								<p>Ngày sinh: <?php echo $birdthday ?></p>
								<p>Giới : <?php echo $gender ?></p>
								<p>Địa điểm gặp trẻ: <?php echo $address ?></p>
								<p>Thời gian gặp trẻ: <?php echo $time_meet ?></p>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?php echo $content ?>
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