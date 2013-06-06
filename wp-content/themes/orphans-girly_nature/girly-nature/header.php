<?php global $tpinfo;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset');?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php echo (!empty($tpinfo['templatelite_feedurl']))? $tpinfo['templatelite_feedurl'] : bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
	<title><?php 
			global $page, $paged;
			wp_title(' | ',true,'right');
			bloginfo('name'); 
			$site_description = get_bloginfo( 'description', 'display' );
			if($site_description && (is_home() || is_front_page()) && !is_paged())
				echo " | $site_description";
			if($paged >= 2 || $page >= 2)
				echo ' | Page '.max( $paged, $page );
		?></title>
<?php 
		wp_enqueue_script('jquery');
		if(is_singular() && get_option( 'thread_comments')){ 
			wp_enqueue_script('comment-reply');
		}
		wp_head();
?>
</head>
<body <?php body_class();?>>
<div id="bg_top"><div id="bg_btm"><div id="base"><div id="base_top"><div id="base_btm">
	<div id="header">
		<?php 
			$tmp=(is_home() || is_front_page())? "h1":"div";
			$tmp2=($tpinfo[$tpinfo['tb_prefix'].'_blogtitle']=='true')? '':' class="indent"';
		?>
		<<?php echo $tmp;?> id="blog_name"<?php echo $tmp2;?>><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></<?php echo $tmp;?>>
		<div id="blog_desc"<?php echo $tmp2;?>><?php bloginfo('description');?></div>
		<a href="<?php echo home_url('/'); ?>" title="Home" class="home"></a>
		<a href="<?php echo (!empty($tpinfo['templatelite_feedurl']))? $tpinfo['templatelite_feedurl'] : bloginfo('rss2_url'); ?>" title="RSS Feed" class="rss"></a>
	</div>
	<div id="menubar">
		<?php wp_nav_menu( array( 'container'=>'div','container_class' => 'menu', 'theme_location' => 'primary') ); ?>
		<div class="menu_line"></div>
	</div>
	<div id="container"><div id="container_top"><div id="container_btm">