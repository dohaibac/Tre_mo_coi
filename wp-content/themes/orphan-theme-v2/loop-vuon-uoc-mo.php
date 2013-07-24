<?php
	$i=1;
    while (have_posts()) : the_post();
        update_post_caches($posts);
		$user_avatars = get_avatar( get_the_author_meta( 'ID' ), 74 );
        ?>
		<div class="large-4 columns content-dream-item">
			<?php echo $user_avatars; ?>
			<div class="dream-item dream-item-<?php echo $i; ?>">
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="info-dream">
					<?php the_content_rss('',true,'',40); ?>
				</div>
				<div class="info-meta-dream">
					
					<span class="auth"><?php the_author_posts_link() ?></span>
					<a class="read-more" href="<?php the_permalink(); ?>">Xem chi tiết...</a>
				</div>
			</div>
		</div>
    <?php 
	if($i==3){
		$i=0;
	}
	$i++;
	endwhile; ?>