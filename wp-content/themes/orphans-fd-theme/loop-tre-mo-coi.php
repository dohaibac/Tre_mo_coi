<?php 
if (have_posts()) :
echo '<div class="row">';
 while (have_posts()) : the_post(); update_post_caches($posts); 		
?>
	
		<div class="large-4 columns">
			<img src="<?php bloginfo('template_directory')?>/images/thumb300x200.png" alt="">
			<div class="meta-info-orphan">
				<h3><a rel="tooltip" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><?php the_content_rss('',true,'', 20); ?></p>
			</div>
		</div>
<?php  endwhile;  ?>
	</div>
	<div class="row">
		<div id="pagenavi">
			<?php	if(function_exists('wp_paginate')) {
						wp_paginate();
				}else { ?>
					<span class="newer"><?php previous_posts_link(__('Newer Entries', 'orphans-theme')); ?></span>
					<span class="older"><?php next_posts_link(__('Older Entries', 'orphans-theme')); ?></span>
				<?php } ?>
				<div class="fixed"></div>
		</div>
	</div>
<?php else : ?>
	<div class="row">
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'orphans-theme'); ?>
	</div>
	<div class="row">
<?php endif; ?>