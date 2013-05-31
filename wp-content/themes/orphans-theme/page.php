<?php get_header() ?>
<div class="container">
    <div class="row">
		
		<div class="span9">
			<section>
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<div class="page-header">
						<h1><?php the_title(); ?></h1>
					</div>
					<div class="row-fluid">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>
			</section>
		</div>
		<?php get_sidebar(); ?>
    </div>
</div>
 <?php get_footer(); ?>