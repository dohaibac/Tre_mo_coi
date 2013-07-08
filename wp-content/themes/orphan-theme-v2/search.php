<?php
get_header();
?>

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
                get_template_part('loop', 'search');
                return ob_get_clean();
            }
            ?>

            <?php
            $pt = get_query_var('post_types');
            $tab_titile = '';
            if ($pt == "tre-mo-coi") {
                $tab_titile = 'Trẻ mồ côi';
            } elseif ($pt == "post") {
                $tab_titile = 'Bài viết';
            } else {
                $tab_titile = 'Tất cả';
            }
            ?>

                    <div class='box-content list-2'>
<?php get_template_part('loop', 'search'); ?>
                    </div>
               
        </div>
    </div>
</div><!--end .large-8-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>