</div><!--end .main-content-->
				<?php //get_sidebar('footer'); ?>
				<!--Hinh ?nh ho?t d?ng -->
				<?php 
				$albums_gallery = new WP_Query();
				$args = array(
					'post_type' => 'hinh-anh',
					'post_status' => 'publish',
					'showposts' => 20,
					'order'	=>'DESC',
					'posts_per_page' => -1,
					'caller_get_posts'=> 1

				);
				$albums_gallery->query($args);
				if($albums_gallery->have_posts()){
				?>
				<div class="row shadow-box box-large hide-for-small">
					<h2>Hình ảnh hoạt động</h2>
					<div class="box-content album">
						<ul class="small-block-grid-5" style="margin-top:8px !important!" id="album_slider">
							<?php 
								while ($albums_gallery->have_posts()) : $albums_gallery->the_post(); update_post_caches($posts); 	
								$image = orphan_get_post_thumbnai('full');
							?>
							<li style="height:154px;margin-right:10px;margin-left:10px;overflow:hidden;">
								<a class="fancybox-gallery" data-fancybox-group="thumb" href="<?php echo $image; ?>" title="<?php the_title(); ?>" >
									<img alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="thumb" src="<?php echo $image ?>" width="158" height="107"/>
								</a>
								<h3>
									<a class="gallery-image-description fancybox-gallery" data-fancybox-group="thumb" href="<?php echo $image; ?>" title="<?php the_title(); ?>" >
										<?php the_title(); ?>
									</a>
								</h3>
							</li>
							<?php endwhile;  wp_reset_query(); ?>
						</ul>
						<a class="control left prev">Prev</a><a class="control right next">Next</a>
					</div>
				</div>
				<!-- Add Thumbnail helper (this is optional) -->
				
				<script language="javascript">
				jQuery(document).ready(function(){
					jQuery(".album").jCarouselLite({
						btnNext: ".album .prev",
						btnPrev: ".album .next",
						speed: 1000,
						scroll: 5,
						visible: 5,
						beforeStart: function(){jQuery('#album ul').css('left', '0px');}
					});
						jQuery(".fancybox-gallery").fancybox({
							prevEffect : 'none',
							nextEffect : 'none',

							closeBtn  : true,
							arrows    : true,
							nextClick : true,
						}
						);
				});
				</script>
				<?php } ?>
				<!--End Hinh ?nh ho?t d?ng -->
				<div class="row main-bottom">
					<!--Begin Menu bottom-->
					<div class="row">
						<?php custom_main_nav('footer_links'); // Adjust using Menus in Wordpress Admin ?>		
						<div class="right socical">
							<a title="facebook" href="http://www.facebook.com/tremocoi.org.vn"><img alt="facebook" src="<?php echo get_template_directory_uri(); ?>/images/facebook.png"/></a>
							<a title="Google" href="https://plus.google.com/share?url=<?php bloginfo('home');?>"><img alt="Google" src="<?php echo get_template_directory_uri(); ?>/images/google.png"/></a>
							<a title="Twitter" href="https://twitter.com/share?original_referer=<?php bloginfo('home');?>"><img alt="Twitter" src="<?php echo get_template_directory_uri(); ?>/images/twitter.png"/></a>
							<a title="Rss" href="<?php bloginfo('rss2_url'); ?>"><img alt="Rss" src="<?php echo get_template_directory_uri(); ?>/images/rss.png"/></a>
						</div>
					</div><!--Begin Menu bottom-->
					<!--Begin .coppy-right-->
					<div class="row coppy-right">
						<p>© <a class="coppy-right-link" href="http://evizi.com">Evizi Team</a>. Website Tre Mo Coi, LP. All Rights Reserved. Hosting được tài trợ bởi <a class="coppy-right-link" href="http://iwebvn.net/">iwebvn.net</a>.</p>
					</div><!--end .coppy-right-->
				</div>
			</div><!--end .main-main-->
			<script src="<?php echo get_template_directory_uri(); ?>/js/foundation.min.js"></script>
			<script>
			jQuery(document).foundation();

			</script>
			<footer></footer>
		</div><!--end .wrapper-content-->
	</div><!--end .wrapper-->
	<?php wp_footer() ?>
	<?php if(!is_user_logged_in()):?>
	<script type="text/javascript">
	
		jQuery(document).ready(function(){
			jQuery('#menu-item-304 a, #menu-item-303 a, .don-nhan-yeu-thuong, .nhap-thong-tin-tre-mo-coi').attr('data-link',function(){return this.href});
			jQuery('#menu-item-304 a, #menu-item-303 a, .don-nhan-yeu-thuong, .nhap-thong-tin-tre-mo-coi').click(function(){
				tmc_backurl = $(this).data('link');
			});
			jQuery('#menu-item-304 a, #menu-item-303 a, .don-nhan-yeu-thuong, .nhap-thong-tin-tre-mo-coi').attr('href', '#login');
			jQuery(".don-nhan-yeu-thuong, .nhap-thong-tin-tre-mo-coi, #menu-item-304 a, #menu-item-303 a").fancybox({scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}, afterShow: function(){$('#tmc_username').focus();jQuery('#login #tmc_login_error_container').html('B?n ph?i dang nh?p tru?c khi th?c hi?n ch?c nang này').show();}});
		});
	</script>
	
	<?php endif;?>
	<script src="<?php bloginfo('template_directory');?>/js/lazy.js"></script>	 
	<script charset="utf-8" type="text/javascript">    jQuery(function(){		jQuery("div.main-content div.box-content img.thumb").lazyload({			placeholder: "<?php bloginfo('template_directory');?>/images/loading_timer.gif",			effect: "fadeToggle",			threshold : 0,		});    });    </script>
  <?php include_once("analyticstracking.php") ?>
  <div style="" class="message_overflow">
		<div class="content_message_overflow">
			<img src="<?php bloginfo('template_directory'); ?>/images/register-header.png" class="logo">
			<p>
				<img src="<?php bloginfo('template_directory'); ?>/images/loading_timer.gif" class="loading">
				<strong class="info">Ðang xử lý thông tin.</strong>
			</p>
		</div>
	</div>
	<script language="javascript">(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) {return;}
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>