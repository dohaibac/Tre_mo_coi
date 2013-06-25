<?php 
get_header();
?>
	<div class="row main-content">
		<div class="large-8 columns">
			<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
			<h3><?php the_title(); ?></h3>

			<!-- Grid Example -->
			<div class="row">
				<div class="large-12 columns">
					<div class="panel">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
 <?php 
 get_footer();
 ?>