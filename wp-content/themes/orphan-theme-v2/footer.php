</div><!--end .main-content-->
				<?php  get_sidebar('footer'); ?>
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
			jQuery(".don-nhan-yeu-thuong, .nhap-thong-tin-tre-mo-coi, #menu-item-304 a, #menu-item-303 a").fancybox({scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}, afterShow: function(){$('#tmc_username').focus();jQuery('#login #tmc_login_error_container').html('Bạn phải đăng nhập trước khi thực hiện chức năng này').show();}});
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
				<strong class="info">Đang xử lý thông tin.</strong>
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