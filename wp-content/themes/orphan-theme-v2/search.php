<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<h2><?php if(function_exists('bcn_display'))	{bcn_display();	} ?></h2>
				<div class="box-content list-2">
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
	</div><!--end .large-8-->
	<?php get_sidebar(); ?>
<?php get_footer() ;?>