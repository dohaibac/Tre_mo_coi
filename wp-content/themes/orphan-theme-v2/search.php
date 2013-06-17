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
            global $wp_query;
            $total_results = $wp_query->found_posts;

            function my_ads_shortcode($attr) {
                ob_start();
                get_template_part('loop', 'archive');
                return ob_get_clean();
            }
            ?>
            <?php $pt = get_query_var('post_types'); ?>
            <div class="wp-tabs wpui-light" style="padding: 2px;">
                <?php
                $tab_titile = '';
                if ($pt == "tre-mo-coi") {
                    $tab_titile = 'Trẻ mồ côi';
                } elseif ($pt == "post") {
                    $tab_titile = 'Bài viết';
                } else {
                    $tab_titile = 'Tất cả';
                }
                ?>
                <h3 class="wp-tab-title"><?php echo $tab_titile ?></h3>
                <div class="wp-tab-content">
                    <h2 style='background-image: none; border: none; padding: 0;; padding-left: 10px;font-size: 13px;'>
                        <?php echo" Tìm thấy $total_results kết quả" ?>
                    </h2>
                    <h2 style='background-image: none; border: none; font-size: 10px; padding: 0; padding-left: 10px;'>
                        Bạn có muốn tìm theo: 
                        <?php if ($pt == "tre-mo-coi") { ?>
                            <a id="a-search" href="javascript:void(0);">Tất cả? </a>
                            <a id="p-search" href="javascript:void(0);">Bài viết?</a>  
                        <?php } elseif ($pt == "post") { ?>
                            <a id="a-search" href="javascript:void(0);">Tất cả? </a>
                            <a id="o-search" href="javascript:void(0);">Trẻ mồ côi? </a>
                        <?php } else { ?>
                            <a id="o-search" href="javascript:void(0);">Trẻ mồ côi? </a>
                            <a id="p-search" href="javascript:void(0);">Bài viết?</a>  
                        <?php } ?>
                    </h2>
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