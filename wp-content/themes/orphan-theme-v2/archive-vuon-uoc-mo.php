<?php 
get_header();
?>
<div class="garden_dreams">
	<?php	if (have_posts()) :	?>
		<a href="<?php echo get_permalink( get_page_by_path( 'viet-bai-vuon-uoc-mo' ) );?>" class="add-new-garden-dreams">Đăng bài viết</a>
		<div class="row">
			<?php 
				/* Run the loop for the archives page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-archive.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'vuon-uoc-mo' );
			?>
		</div>
		<div style="clear: both;"></div>
		<div id="pagenavi">
			<?php
			if (function_exists('wp_paginate')) {
				wp_paginate();
			} else {
				?>
				<span class="newer"><?php previous_posts_link(__('Newer Entries', 'orphans-theme')); ?></span>
				<span class="older"><?php next_posts_link(__('Older Entries', 'orphans-theme')); ?></span>
			<?php } ?>
			<div class="fixed"></div>
		</div>
	<?php else : ?>
		<div class="errorbox">
			<?php _e('Hiện thời không có bài viết nào', 'orphans-theme'); ?>
		</div>
	<?php endif; ?>
</div>
<?php get_footer() ;?>