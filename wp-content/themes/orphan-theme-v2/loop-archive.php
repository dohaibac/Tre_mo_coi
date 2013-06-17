<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        update_post_caches($posts);
        $image = orphan_get_post_thumbnai(); // wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
        ?>
        <div class="row">
            <div class="large-3 columns">
                <a rel="tooltip" href="<?php the_permalink(); ?>" class="btn">
                    <img class="thumb" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" width="226" height="93">
                </a>
            </div>
            <div class="large-9 columns">
                <h3><a rel="tooltip" href="<?php the_permalink(); ?>" class="btn"><?php the_title(); ?></a></h3>
                <p><?php the_content_rss('', true, '', 30); ?></p>
            </div>
        </div>
    <?php endwhile; ?>
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
        <?php _e('Xin lỗi, mong bạn vui lòng thử tìm kiếm với từ khóa khác', 'orphans-theme'); ?>
    </div>
<?php endif; ?>
<?php
        // wp_reset_postdata();?>