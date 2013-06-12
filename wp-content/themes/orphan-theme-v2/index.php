<?php get_header()?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css" type="text/css" media="screen" />
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<div class="large-12" style="padding-right:0px;">
					
					<div class="slider-wrapper theme-default" style="width:100%;">
						<div id="slider" class="nivoSlider">
							<?php
							$slicePost = new WP_Query();
							$slicePost->query('showposts=10&cat=10&orderby=DESC');
							while ($slicePost->have_posts()) : $slicePost->the_post();
							$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
							if($image[0] == '') $image[0] = get_template_directory_uri().'/img/images/toystory.jpg' ;
							?>
								<a href="<?php the_permalink(); ?>">
								<img height="243" src="<?php echo $image[0]; ?>" data-thumb="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /></a>
							<?php endwhile; wp_reset_query();?>
						</div>						
					</div>					
				</div>
				
				<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/nivo-slider/jquery.nivo.slider.js"></script>
				<script type="text/javascript">
				$(window).load(function() {
					$('#slider').nivoSlider({
						controlNav : false
					});
				});
				</script>
				
			</div><!--end .featured-->
			<!--Begin Tin tức -->
			<div class="row shadow-box">
				<h2>Tin tức - Sự kiện</h2>
				<div class="box-content">
					<div class="row">
						<div class="large-7 columns">
						<?php 
						$i=0;
						$newsPost = new WP_Query();
						$newsPost->query('showposts=10&cat=1,5&orderby=DESC');
						while ($newsPost->have_posts()) : $newsPost->the_post(); update_post_caches($posts); 		
						$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
						if($i < 3){?>
							<div class="row">
								<div class="large-4 columns">
									<a href="<?php the_permalink(); ?>"><?php if($image[0] != ''){?>
										<img class="thumb" src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="226" height="93">
										<?php }
										else{?>
										<img class="thumb" src="<?php echo get_template_directory_uri() ?>/images/no_image.png" width="226" height="93" alt="">
										<?php }?>
									</a>
								</div>
								<div class="large-8 columns">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<p> <?php the_content_rss('',true,'', 10); ?></p>
								</div>
							</div>
						<?php }
						else {
						if($i == 3){ ?>
						</div>
						<div class="large-5 columns meta-list">
							<ul class="meta">
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<?php $my_date = the_date('d-m-Y', '<span class="date">', '</span>', FALSE); if($my_date != '') echo '('.$my_date.')' ?></li>
						<?php }
						else{ ?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<?php $my_date = the_date('d-m-Y', '<span class="date">', '</span>', FALSE); if($my_date != '') echo '('.$my_date.')' ?></li>
						<?php }
						}
						?>
							
						<?php $i++; endwhile;  wp_reset_query(); ?>
							</ul>
						</div>
												
					</div>
					
				</div>
			</div><!--End Tin tức -->
			<!--Begin Chương trình hoạt động -->
			<div class="row shadow-box">
				<h2>Chương trình hoạt động <a href="" class="read-more">Xem tiếp...</a></h2>
				<div class="box-content list-2">
				<?php
				$acNewsPost = new WP_Query();
				$acNewsPost->query('showposts=2&cat=8&orderby=DESC');
				while ($acNewsPost->have_posts()) : $acNewsPost->the_post();		
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
				?>
					<div class="row">
						<div class="large-3 columns">
							<a href="<?php the_permalink(); ?>"><img alt="title" class="thumb" src="<?php echo $image[0] ?>"/></a>
						</div>
						<div class="large-9 columns">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php the_content_rss('',true,'', 30); ?></p>
						</div>
					</div>
				<?php endwhile; wp_reset_query();?>
				</div>
			</div><!--End Chương trình hoạt động -->
			<!--Begin Văn bản luật -->
			<div class="row shadow-box">
				<h2>Văn bản luật về trẻ em <a href="" class="read-more">Xem tiếp...</a></h2>
				<div class="box-content">
				<?php
				$lawPost = new WP_Query();
				$lawPost->query('showposts=3&cat=9&orderby=DESC');
				while ($lawPost->have_posts()) : $lawPost->the_post();		
				$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
				?>
					<div class="row">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php the_content_rss('',true,'', 30); ?></p>
					</div>
				<?php endwhile; wp_reset_query();?>
				</div>
			</div><!--End Văn bản luật -->
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
<?php get_footer() ;?>