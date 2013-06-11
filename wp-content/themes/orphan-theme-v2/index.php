<?php get_header()?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row featured">
				<div class="large-7 slide-box columns">
					<div class="shadow-box">
						<img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/slider.png"/>
					</div>
				</div>
				<div class="large-5 video columns">
					<div class="sidebar-box shadow-box">
						<h2>Video <a href="" class="read-more">Xem tiếp...</a></h2>
						<div class="box-content">
							<img alt="title"  src="<?php echo get_template_directory_uri(); ?>/images/video.png" style="height:180px;"/>
						</div>
					</div>
				</div>
			</div><!--end .featured-->
			<!--Begin Tin tức -->
			<div class="row shadow-box">
				<h2>Tin tức - Sự kiện</h2>
				<div class="box-content">
					<div class="row">
						<div class="large-7 columns">
						<?php 
						$i=0;
						$featuredPost = new WP_Query();
						$featuredPost->query('showposts=10&orderby=DESC');
						if (have_posts()) : while ($featuredPost->have_posts()) : $featuredPost->the_post(); update_post_caches($posts); 		
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
						<?php endif; ?>
												
					</div>
					
				</div>
			</div><!--End Tin tức -->
			<!--Begin Chương trình hoạt động -->
			<div class="row shadow-box">
				<h2>Chương trình hoạt động <a href="" class="read-more">Xem tiếp...</a></h2>
				<div class="box-content list-2">
					<div class="row">
						<div class="large-3 columns">
							<a href=""><img alt="title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/3.png"/></a>
						</div>
						<div class="large-9 columns">
							<h3><a href="">Mỗi bàn tay, một tấm lòng</a></h3>
							<p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat. euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p>
						</div>
					</div>
					<div class="row">
						<div class="large-3 columns">
							<a href=""><img alt="title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/4.png"/></a>
						</div>
						<div class="large-9 columns">
							<h3><a href="">Mỗi bàn tay, một tấm lòng</a></h3>
							<p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat. euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p>
						</div>
					</div>
				</div>
			</div><!--End Chương trình hoạt động -->
			<!--Begin Văn bản luật -->
			<div class="row shadow-box">
				<h2>Văn bản luật về trẻ em <a href="" class="read-more">Xem tiếp...</a></h2>
				<div class="box-content">
					<div class="row">
						<h3><a href="">Văn bản luật về bảo vệ quyền lợi trẻ em</a></h3>
						<p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat. euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p>
					</div>
					<div class="row">
						<h3><a href="">Văn bản luật về nhận con nuôi</a></h3>
						<p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat. euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p>
					</div>
					<div class="row">
						<h3><a href="">Luật Việt Nam về nghĩa vụ và quyền lợi của trẻ em</a></h3>
						<p>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat. euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p>
					</div>
				</div>
			</div><!--End Văn bản luật -->
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
<?php get_footer() ;?>