<?php 
if (have_posts()) : while (have_posts()) : the_post(); update_post_caches($posts); 		
?>
	
	<div class="span5">
	  <h2><?php the_title(); ?></h2>
	  <p><strong><?php the_content_rss('',true,'', 30); ?></p>
	  <p><a rel="tooltip" data-original-title="<?php the_content_rss('',true,'', 60); ?>" href="<?php the_permalink(); ?>" class="btn btn-large btn-primary">Read more...</a></p>
	</div>
<?php  endwhile;  ?>
		<div style="clear: both;"></div>
		<div id="pagenavi">
			<?php	if(function_exists('wp_paginate')) {
						wp_paginate();
				}else { ?>
					<span class="newer"><?php previous_posts_link(__('Newer Entries', 'orphans-theme')); ?></span>
					<span class="older"><?php next_posts_link(__('Older Entries', 'orphans-theme')); ?></span>
				<?php } ?>
				<div class="fixed"></div>
		</div>
<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'orphans-theme'); ?>
	</div>
<?php endif; ?>