<?php 
if (have_posts()) :
echo '<div class="list_item">';
 while (have_posts()) : the_post(); update_post_caches($posts); 		
$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
?>
	<div class="row">
		<div class="large-4 columns">
			<a rel="tooltip" href="<?php the_permalink(); ?>" class="btn">
			<?php if($image[0] != ''){?>
			<img src="<?php echo $image[0]; ?>" alt="" width="300" height="200">
			<?php }
			else{?>
			<img src="<?php echo get_template_directory_uri() ?>/images/thumb300x200.png" alt="">
			<?php }?>
			</a>
		</div>
	</div>
<?php  endwhile;  ?>
	</div>
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