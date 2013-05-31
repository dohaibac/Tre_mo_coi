<?php get_header() ?>
<div class="container">
    <div class="row">
		<?php get_sidebar(); ?>
		<div class="span9">
			<div class="page-header">
				<h1>
					<?php if (is_search()) : ?>
				Search Results: <?php printf( __('Keyword: &#8216;%1$s&#8217;', 'orphans-theme'), wp_specialchars($s, 1) ); ?>
				<?php else : ?>
					<?php
						// If this is a category archive
						if (is_category()) {
							printf( __('%1$s', 'orphans-theme'), single_cat_title('', false) );
						// If this is a tag archive
						} elseif (is_tag()) {
							printf( __('Posts Tagged <span> &#8216;%1$s&#8217;</span>', 'orphans-theme'), single_tag_title('', false) );
						// If this is a daily archive
						} elseif (is_day()) {
							printf( __('Archive for <span> &#8216;%1$s&#8216;</span>', 'orphans-theme'), get_the_time(__('M d, Y', 'leepro_datienrestaurant')) );
						// If this is a monthly archive
						} elseif (is_month()) {
							printf( __('Archive for <span>&#8216;%1$s&#8216;</span>', 'orphans-theme'), get_the_time(__('M, Y', 'leepro_datienrestaurant')) );
						// If this is a yearly archive
						} elseif (is_year()) {
							printf( __('Archive for <span>&#8216;%1$s&#8216;</span>', 'orphans-theme'), get_the_time(__('Y', 'leepro_datienrestaurant')) );
						// If this is an author archive
						} elseif (is_author()) {
							_e('Author Archive ', 'orphans-theme');
						// If this is a paged archive
						} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
							_e('Blog Archives', 'orphans-theme');
						}
						?>
					<?php endif; ?>
				</h1>
			</div>
			<?php

				/* Run the loop for the archives page to output the posts.
				* If you want to overload this in a child theme then include a file
				* called loop-archive.php and that will be used instead.
				*/
			get_template_part( 'loop', 'archive' );
			?>
		</div>
    </div>
</div>
 <?php get_footer(); ?>