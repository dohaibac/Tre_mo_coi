
<div class="large-4 columns">
	<div class="shadow-box" style="margin-bottom: 18px !important">
		<a class="don-nhan-yeu-thuong" href="<?php echo get_permalink( get_page_by_path( 'don-nhan-yeu-thuong' ) );?>"><img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/don-nhan-yeu-thuong.png"/></a>
	</div>
	<div class="shadow-box">
		<a class="nhap-thong-tin-tre-mo-coi" href="<?php echo get_permalink( get_page_by_path( 'nhap-thong-tin-tre-mo-coi' ) );?>"><img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/dang-thong-tin-tre-em.png"/></a>
	</div>
	
	<div class="row sidebar-box shadow-box">
		<h2>Videos</h2>
		<div class="box-content video">
			<div id="mediaspace_wrapper"></div>
			<ul class="list_video">
			<?php
			$videoPost = new WP_Query();
			$videoPost->query('showposts=3&cat=11&orderby=DESC');
			while ($videoPost->have_posts()) : $videoPost->the_post();		
			?>
				<li class="video"><a data="<?php echo get_post_meta( get_the_ID(), 'url_video', true ) ?>" href="#view_video"><?php the_title(); ?></a></li>
			<?php endwhile; wp_reset_query();?>
			
			</ul>
			<script type="text/javascript">			
			$(document).ready(function() {
				var link_video = $(".list_video li:first").find('a').attr("data"); 
				$(".list_video li:first").addClass("playvideo");
				load_video(link_video,false);
				$(".list_video li a").click(function(){ 
					link_video = $(".list_video li:hover").find('a').attr("data"); 
					if(link_video){
						load_video(link_video, true);
						$(".list_video li").removeClass("playvideo"); 
						$(".list_video li:hover").addClass("playvideo"); 
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
							'height': '225'
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
			<?php
			$slicePost = new WP_Query();
			$slicePost->query('showposts=3&cat=6&orderby=DESC');
			while ($slicePost->have_posts()) : $slicePost->the_post();
			$image = orphan_get_post_thumbnai();// wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
			if($image == '') $image = get_template_directory_uri().'/img/images/toystory.jpg' ;
			?>
			<div class="row">
				<div class="large-4 columns">
					<a href="<?php the_permalink(); ?>"><img alt="title" class="thumb" src="<?php echo $image; ?>"/></a>
				</div>
				<div class="large-8 columns">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				</div>
			</div>
			<?php endwhile; wp_reset_query();?>	
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