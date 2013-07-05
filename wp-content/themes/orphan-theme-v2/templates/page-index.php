<?php 

/**
 * Template Name: Trang chủ
 * Description: A Page Template that shows form register
 * @author Phi Ho
 */
 global $current_user;
get_header();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/js/nivo-slider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/js/nivo-slider/nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css" type="text/css" media="screen" />


	<div class="row main-content">
		<div class="large-8 columns">
			<div class="panel" style ="margin-top: 10px;">
			
			<div class="row">
				<div class="large-6 columns">
					<div class="panel" style="padding:0px;">
						<div class="slider-wrapper theme-default">
							<div id="slider" class="nivoSlider">
								<img src="<?php echo get_template_directory_uri() ?>/images/images/toystory.jpg" data-thumb="<?php echo get_template_directory_uri() ?>/images/images/toystory.jpg" alt="" />
								<a href="http://dev7studios.com"><img src="<?php echo get_template_directory_uri() ?>/images/images/up.jpg" data-thumb="<?php echo get_template_directory_uri() ?>/js/nivo-slider/images/up.jpg" alt="" title="This is an example of a caption" /></a>
								<img src="<?php echo get_template_directory_uri() ?>/images/images/walle.jpg" data-thumb="<?php echo get_template_directory_uri() ?>/images/images/walle.jpg" alt="" data-transition="slideInLeft" />
								<img src="<?php echo get_template_directory_uri() ?>/images/images/nemo.jpg" data-thumb="<?php echo get_template_directory_uri() ?>/images/images/nemo.jpg" alt="" title="#htmlcaption" />
							</div>
							<div id="htmlcaption" class="nivo-html-caption">
								<strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
							</div>
						</div>
					</div>
				</div>
				<div class="large-6 columns">
					<div class="panel">
						<p>Six columns</p>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
				
				</div>
			</div>
			</div>


		</div>

		<?php get_sidebar(); ?>
	</div>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/nivo-slider/scripts/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/nivo-slider/jquery.nivo.slider.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider();
});
</script>
 <?php 
 get_footer();
 ?>