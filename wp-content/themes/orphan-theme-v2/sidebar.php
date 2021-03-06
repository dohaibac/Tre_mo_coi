
<div class="large-4 columns">
	<?php include('include-quick-link.php');?>
	<div class="row sidebar-box shadow-box">
		<h2>Videos</h2>
		<div class="box-content video">
			<div id="mediaspace_wrapper"></div>
			<ul class="list_video">
			<?php
			$videoPost = new WP_Query();
			$videoPost->query('showposts=5&cat=11&orderby=DESC');
			while ($videoPost->have_posts()) : $videoPost->the_post();		
			?>
				<li class="video"><a data="<?php echo get_post_meta( get_the_ID(), 'url_video', true ) ?>" href="#view_video"><?php the_title(); ?></a></li>
			<?php endwhile; wp_reset_query();?>
			
			</ul>
			<script type="text/javascript">			
			jQuery(document).ready(function() {
				var link_video = jQuery(".list_video li:first").find('a').attr("data"); 
				jQuery(".list_video li:first").addClass("playvideo");
				load_video(link_video,false);
				jQuery(".list_video li a").click(function(){ 
					link_video = jQuery(".list_video li:hover").find('a').attr("data"); 
					if(link_video){
						load_video(link_video, true);
						jQuery(".list_video li").removeClass("playvideo"); 
						jQuery(".list_video li:hover").addClass("playvideo"); 
					}
					return false;
				});
				function load_video(url_video, auto_play){
					jwplayer('mediaspace_wrapper').setup({
							'flashplayer':  '<?php echo get_template_directory_uri(); ?>/js/player-video/player.swf',
							'file': url_video,
							'autostart': auto_play,
							'controlbar': 'bottom',
							'icons': 'false',
							'width': '100%',
							'height': '218'
						});
				}
			});
			</script>
		</div>
		
	</div>
	
	<!--Begin widget Tấm lòng vàng -->
	<div class="row sidebar-box shadow-box">
		<h2>Tấm lòng vàng</h2>
		<div class="box-content list-2">
			<div id="sidebar_slider_1" class="croll_news">
				<ul class="sb_slider">
				<?php
				$slicePost = new WP_Query();
				$slicePost->query('showposts=20&cat=6&orderby=DESC');
				while ($slicePost->have_posts()) : $slicePost->the_post();
				$image = orphan_get_post_thumbnai();// wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
				if($image == '') $image = get_template_directory_uri().'/img/images/toystory.jpg' ;
				?>
				<li>
					<div class="row">
						<div class="large-4 columns hide-for-small">
							<a href="<?php the_permalink(); ?>"><img alt="title" class="thumb" src="<?php echo $image; ?>"/></a>
						</div>
						<div class="large-8 columns hide-for-small">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</div>
						<div class="large-12 columns hide-for-medium-up" style="text-align:justify">
							<a href="<?php the_permalink(); ?>"><img align="left" alt="title" class="thumb" src="<?php echo $image; ?>"/></a>
							<h3 style="display: inline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</div>
					</div>
				</li>
				<?php endwhile; wp_reset_query();?>
				</ul>
			</div>
			<script language="javascript">
			jQuery(".croll_news").jCarouselLite({
				btnNext: ".croll_news .prev",
				btnPrev: ".croll_news .next",
				speed: 7000,
				hoverPause: false,
				scroll: 4,
				auto: true,
				visible: 4,
				vertical: true
			});
			</script>
		</div>
	</div><!--End widget Tấm lòng vàng -->
	<!--Begin widget  Bình luận mới nhất -->
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_main') ) :endif;?>
	<!--End widget Bình luận mới nhất -->
	<!--Begin widget  widget Fan Page -->
	<div class="row sidebar-box shadow-box">
		<h2>Fan Page</h2>
		<div class="box-content list-2" style="padding:0;">
			<div class="facebook-box">
			<div class="fb-like-box" data-href="https://www.facebook.com/tremocoi.org.vn" data-width="290" data-height="300" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false" style="text-align:center;font-style:italic;font-size:13px;color:#999;">Đang tải...</div>
			</div>
		</div>
	</div><!--End widget Fan Page -->
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_bottom') ) :endif;?>
</div><!--end .large-4-->