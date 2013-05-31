<?php 
if (have_posts()) :
echo '<ul class="thumbnails">';
 while (have_posts()) : the_post(); update_post_caches($posts); 		
?>
	  <li class="span3">
		<div class="thumbnail">
		  <img src="<?php bloginfo('template_directory')?>/images/thumb300x200.png" alt="">
		  <div class="caption">
			<h3><?php the_title(); ?></h3>
			<p><?php the_content_rss('',true,'', 30); ?></p>
			<p><a rel="tooltip" data-original-title="<?php the_content_rss('',true,'', 60); ?>" href="<?php the_permalink(); ?>" class="btn">Read more...</a></p>
		  </div>
		</div>
	  </li>
<?php  endwhile;  ?>
	</ul>
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