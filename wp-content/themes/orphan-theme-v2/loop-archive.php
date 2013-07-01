<?php
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
			<h3><a rel="tooltip" href="<?php the_permalink(); ?>" class="btn"><?php echo short_the_title(get_the_title(),60); ?></a></h3>
			<p><?php the_content_rss('', true, '', 30); ?></p>
		</div>
	</div>
<?php endwhile; ?>