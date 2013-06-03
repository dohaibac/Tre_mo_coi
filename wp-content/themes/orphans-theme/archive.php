<?php get_header() ?>
<div class="container">
    <div class="row">
		
		<div class="span9">
			<div class="page-header">
				<h1>
					<?php if(function_exists('bcn_display'))	{bcn_display();	} ?>
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
		<?php get_sidebar(); ?>
    </div>
</div>
 <?php get_footer(); ?>