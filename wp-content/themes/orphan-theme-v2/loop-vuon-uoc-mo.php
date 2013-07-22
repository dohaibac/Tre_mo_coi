<?php
    while (have_posts()) : the_post();
        update_post_caches($posts);
		$user_post_id = isset($posts[0]->post_author) ? $posts[0]->post_author : null;
		$get_userdata =  get_userdata( $user_post_id); 
		$user_avatars = get_user_meta($user_post_id, "user_avatars", true);
		if(!$user_avatars){
			$user_avatars = get_avatar( get_the_author_meta( 'ID' ), 74 );
		} 
        ?>
		<div class="large-4 columns content-dream-item">
			<img class="auth-dream" src="<?php echo $user_avatars; ?>"/>
			<div class="dream-item">
				<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="info-dream">
					<?php the_content_rss('',true,'',40); ?>
				</div>
				<div class="info-meta-dream">
					
					<span class="auth"><?php echo $get_userdata->display_name;?></span>
					<a class="read-more" href="<?php the_permalink(); ?>">Xem chi tiết...</a>
				</div>
			</div>
		</div>
    <?php endwhile; ?>