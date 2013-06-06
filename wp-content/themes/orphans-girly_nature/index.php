<?php get_header(); ?>
<div id="content">
<?php
	if((is_home()||is_front_page()) && $paged<2 && function_exists('get_a_post')){//detect if FCG is active
		include (ABSPATH . '/wp-content/plugins/featured-content-gallery/gallery.php'); 
	}

	if (have_posts()) :
		$post = $posts[0]; // Hack. Set $post so that the_date() works.
		if(is_category()){
			echo '<h3 class="archivetitle">'.sprintf(__('Archive for the Category &raquo; %s &laquo;','templatelite'),single_cat_title('',FALSE)).'</h3>';
		}elseif(is_day()){
			echo '<h3 class="archivetitle">'.sprintf(__('Archive for &raquo; %s &laquo;','templatelite'),get_the_time('F jS, Y')).'</h3>';
		}elseif(is_month()){
			echo '<h3 class="archivetitle">'.sprintf(__('Archive for &raquo; %s &laquo;','templatelite'),get_the_time('F, Y')).'</h3>';
		}elseif(is_year()){
			echo '<h3 class="archivetitle">'.sprintf(__('Archive for &raquo; %s &laquo;','templatelite'),get_the_time('Y')).'</h3>';
		} elseif(is_search()){
			echo '<h3 class="archivetitle">'.__('Search Results','templatelite').'</h3>';
		}elseif(is_author()){
			echo '<h3 class="archivetitle">'.__('Author Archive','templatelite').'</h3>';
		}elseif(is_tag()){
			echo '<h3 class="archivetitle">'.sprintf(__('Tag-Archive for &raquo; %s &laquo;','templatelite'),single_tag_title('',FALSE)).'</h3>';
		}elseif((is_home()||is_front_page()) && $paged>1){ // If this is a paged archive
			echo '<h3 class="archivetitle">'.__('Blog Archives','templatelite').'</h3>';
		}else{
			echo '<div class="spacer">&nbsp;</div>';
		}
		while (have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class("postbox"); ?>><div class="postbox2"><div class="postbox3">
				<div class="post_title">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<div class="post_author">By <?php the_author_posts_link(); ?> <?php edit_post_link(' Edit ','(',') '); ?></div>
				</div>
				<div class="post_date"><div class="post_date_day"><?php the_time('d');?></div><div class="post_date_month"><?php the_time('M');?> <?php the_time('Y');?></div></div>				
				<div class="clear"></div>
				<div class="entry"><?php echo templatelite_get_postthumb($post->ID,$tpinfo[$tpinfo['tb_prefix'].'_postthumb_width'],$tpinfo[$tpinfo['tb_prefix'].'_postthumb_height'],'img','post_thumb');?>
				<?php
					if($tpinfo[$tpinfo['tb_prefix'].'_postthumb_show']=='true' || is_search()){
						templatelite_excerpt('',"..."," [ "," ] ");
					}else{
						the_content(__('more &raquo;','templatelite'));
					}
				?>
					<div class="clear"></div>
				</div></div></div><!-- #postbox3, #postbox2,#postbox -->
				<div class="info">
					<span class="info_category"><?php _e('Category:','templatelite');?> <?php the_category(', ') ?></span>
					<?php the_tags('&nbsp;<span class="info_tag">'.__('Tags:','templatelite').' ', ', ', '</span>'); ?>
					&nbsp;<span class="info_comment"><?php comments_popup_link(__('Leave a Comment','templatelite'),__('One Comment','templatelite'), __('% Comments','templatelite'), '',__('Comments off','templatelite')); ?></span>
				</div>
			</div>
<?php 
		endwhile; 

		if($wp_query->max_num_pages > 1):
?>
			<div class="navigation">
				<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','templatelite')) ?></div>
				<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','templatelite')) ?></div>
			</div>
<?php 
		endif;
	else : ?>
		<h3 class="archivetitle"><?php _e('Not found','templatelite');?></h3>
		<p class="sorry"><?php _e("Sorry, but you are looking for something that isn't here. Try something else.",'templatelite');?></p>
<?php

	endif;
?>	
</div>
<?php get_sidebar(); ?>
<?php get_footer();?>
