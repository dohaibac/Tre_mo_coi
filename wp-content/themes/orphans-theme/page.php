<?php get_header() ?>
<div class="container">
    <div class="row">
		<?php get_sidebar(); ?>
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
    </div>
</div>
 <?php get_footer(); ?>