<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<h2><?php if(function_exists('bcn_display'))	{bcn_display();	} ?></h2>
				<div class="box-content list-2">
					<?php
						if (have_posts()) :
						/* Run the loop for the archives page to output the posts.
						 * If you want to overload this in a child theme then include a file
						 * called loop-archive.php and that will be used instead.
						 */
						 get_template_part( 'loop', 'com-tim-bo-me' );
					?>
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
			</div>
		</div>
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
<?php get_footer() ;?>