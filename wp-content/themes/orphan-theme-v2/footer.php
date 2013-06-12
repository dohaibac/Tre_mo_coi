</div><!--end .main-content-->
				
				<!--Beggin .Begin Album-->
				<div class="row shadow-box box-large">
					<h2>Hình ản hoạt động<a href="" class="read-more">Xem tiếp...</a></h2>
					<div class="box-content album">
						<ul class="small-block-grid-5">
							<li>
								<a href="#12"><img alt="Title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/a1.png"></a>
								<h3><a href="#12">Vòng tay yêu thương</a></h3>
							</li>
							<li>
								<a href="#12"><img alt="Title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/a2.png"></a>
								<h3><a href="#12">Mùa hè tình nguyện</a></h3>
							</li>
							<li>
								<a href="#12"><img alt="Title"class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/a3.png"></a>
								<h3><a href="#12">Mái ấm yêu thương</a></h3>
							</li>
							<li>
								<a href="#"><img alt="Title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/a4.png"></a>
								<h3><a href="#12">Khi giấc mơ về</a></h3>
							</li>
							<li>
								<a href="#12"><img alt="Title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/a5.png"></a>
								<h3><a href="#12">Kết nối yêu thương</a></h3>
							</li>
						</ul>
						<a class="control left">Prev</a>
						<a class="control right">Next</a>
					</div>
				</div><!--End Album -->
				<div class="row main-bottom">
					<!--Begin Menu bottom-->
					<div class="row">
						<?php custom_main_nav('footer_links'); // Adjust using Menus in Wordpress Admin ?>		
						<div class="right socical">
							<a title="facebook" href="http://www.facebook.com/sharer.php?u=<?php bloginfo('home');?>"><img alt="facebook" src="<?php echo get_template_directory_uri(); ?>/images/facebook.png"/></a>
							<a title="Google" href="https://plus.google.com/share?url=<?php bloginfo('home');?>"><img alt="Google" src="<?php echo get_template_directory_uri(); ?>/images/google.png"/></a>
							<a title="Twitter" href="https://twitter.com/share?original_referer=<?php bloginfo('home');?>"><img alt="Twitter" src="<?php echo get_template_directory_uri(); ?>/images/twitter.png"/></a>
							<a title="Rss" href="<?php bloginfo('rss2_url'); ?>"><img alt="Rss" src="<?php echo get_template_directory_uri(); ?>/images/rss.png"/></a>
						</div>
					</div><!--Begin Menu bottom-->
					<!--Begin .coppy-right-->
					<div class="row coppy-right">
						<p>© Evizi Team. Website Tre Mo Coi, LP. All Rights Reserved.</p>
					</div><!--end .coppy-right-->
				</div>
			</div><!--end .main-main-->
			<script src="<?php echo get_template_directory_uri(); ?>/js/foundation.min.js"></script>
			<script>
			$(document).foundation();

			</script>
			<footer></footer>
		</div><!--end .wrapper-content-->
	</div><!--end .wrapper-->
	  <?php wp_footer() ?>
</body>
</html>
