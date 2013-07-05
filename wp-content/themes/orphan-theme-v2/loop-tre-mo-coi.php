<?php
if (have_posts()) :
    while (have_posts()) : the_post();
        update_post_caches($posts);
        $image = get_post_meta( get_the_ID(), 'orphan_photo', true );//orphan_get_post_thumbnai(); // wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
		if($image == '') $image = get_template_directory_uri().'/images/no_image.png' ;
		$birdthday = get_post_meta( get_the_ID(), 'orphan_birthday', true );
		$gender = get_post_meta( get_the_ID(), 'orphan_gender', true );
		//$address = get_post_meta( get_the_ID(), 'orphan_cv-address', true );
		//$time_meet = get_post_meta( get_the_ID(), 'orphan_cv-time', true );
		//$content = get_post_meta( get_the_ID(), 'orphan_cv-content', true );
        ?>
        <div class="row">
            <div class="large-2 columns">
                <a rel="tooltip" href="<?php the_permalink(); ?>" class="btn">
                    <img class="thumb" src="<?php echo $image; ?>" alt="<?php the_title(); ?>" width="226" height="93">
                </a>
            </div>
            <div class="large-10 columns">
                <h3><a rel="tooltip" href="<?php the_permalink(); ?>" class="btn"><?php the_title(); ?></a></h3>
                <p>Ngày sinh: <?php echo $birdthday ?></p>
				<p>Giới : <?php echo $gender ?></p>
				
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
        <?php _e('Sorry, no posts matched your criteria.', 'orphans-theme'); ?>
    </div>
<?php endif; ?>
