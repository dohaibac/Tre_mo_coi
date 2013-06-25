<?php 
get_header();
?>

	<div class="row main-content">
		<div class="large-8 columns">
			<h3>
			<?php if(function_exists('bcn_display'))	{bcn_display();	} ?>
			</h3>

			<!-- Grid Example -->
			<div class="row">
				<div class="large-12 columns">
					<?php

						/* Run the loop for the archives page to output the posts.
						 * If you want to overload this in a child theme then include a file
						 * called loop-archive.php and that will be used instead.
						 */
						 get_template_part( 'loop', 'nhan-con-nuoi' );
					?>
				</div>
			</div>
		</div>

		<?php get_sidebar(); ?>
	</div>

 <?php 
 get_footer();
 ?>