<?php 
get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<h2><?php if(function_exists('bcn_display'))	{bcn_display();	} ?></h2>
				<div class="box-content list-2">
					<?php

<<<<<<< HEAD
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
=======
<div class="large-8 columns content">
    <div class="row">
        <div class="row shadow-box">
            <h2><?php
                if (function_exists('bcn_display')) {
                    bcn_display();
                }
                ?></h2>
            <?php

            function my_ads_shortcode($attr) {
                ob_start();
                get_template_part('loop', 'archive');
                return ob_get_clean();
            }

            $tab_titile = '';
            if ($pt == "tre-mo-coi") {
                $tab_titile = 'Trẻ mồ côi';
            } elseif ($pt == "post") {
                $tab_titile = 'Bài viết';
            } else {
                $tab_titile = 'Tất cả';
            }
            ?>
            <?php $pt = get_query_var('post_types'); ?>
            <div class="wp-tabs wpui-light" style="padding: 2px;">
                <h3 class="wp-tab-title"><?php echo $tab_titile ?></h3>
                <div class="wp-tab-content">
                    <div class='box-content list-2'>
                        <?php get_template_part('loop', 'archive'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end .large-8-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
>>>>>>> 3a84d35097d73202386214088c568da60aa6de7a
