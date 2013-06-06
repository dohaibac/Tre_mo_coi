<?php global $tpinfo;?>
<div id="sidebar">
<form class="mainsearch" action="<?php bloginfo('url'); ?>/" method="get">
	<input class="keyword" type="text" value="" name="s" id="s" />
	<input class="submit" value="" type="submit"/>
</form>

<div id="sidebar1">
<ul>


<?php
	if(!dynamic_sidebar('sidebar-1')) :
?>
	<?php wp_list_pages('title_li=<h4>Pages</h4>'); ?>
		
	<?php wp_list_categories('show_count=1&title_li=<h4>Categories</h4>'); ?>

	<li>
		<h4>Archives</h4>
		<ul><?php wp_get_archives('type=monthly'); ?></ul>
	</li>

	<li><h4>Calendar</h4><?php get_calendar(); ?></li>
<?php	endif;?>
</ul>
</div>

<div id="sidebar2">
<ul>
<?php
	if(!dynamic_sidebar('sidebar-2')) :
?>
	<li><h4>Recent Posts</h4><ul><?php wp_get_archives('type=postbypost&limit=5')?></ul></li>
			
	<li><h4>Tag Cloud</h4><?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?></li>

	<?php if ( is_home() || is_page() ) { 	/* If this is the frontpage */ 
				wp_list_bookmarks('orderby=rand&title_before=<h4>&title_after=</h4>&between=<br/>&show_description=1&limit=20');
			}
	?>
	<li><h4>Meta</h4>
		<ul>
		<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
		</ul>
	</li>		
<?php	endif;?>
<?php theme_sb_credit();?>	
</ul>
</div>
</div>