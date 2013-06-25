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
						<?php the_content(); ?>
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