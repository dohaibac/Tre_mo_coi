<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title>
	<?php
	/*
	* Print the <title> tag based on what is being viewed.
	*/
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	//if ( $site_description && ( is_home() || is_front_page() ) )
	echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
	echo ' | ' . sprintf( __( 'Page %s', 'orphans-theme' ), max( $paged, $page ) );

	?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow" />
	<meta name="description" content="<?php echo $site_description;?>">
    <meta name="keywords" content="<?php echo $site_description;?>">
	<meta name="language" content="<?php bloginfo( 'charset' ); ?>" />
	<meta name="title" content="<?php echo $site_description;?>" />
    <meta name="author" content="Evizi team">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- Le styles -->
    <link href="<?php bloginfo('template_directory');?>/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php bloginfo('template_directory');?>/bootstrap/css/default.css" rel="stylesheet">
    <link href="<?php bloginfo('template_directory');?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url');?>" media="screen" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php bloginfo('template_directory');?>/js/html5shiv.js"></script>
    <![endif]-->
	<script type="text/javascript">
	//<![CDATA[
		ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
		url_theme = '<?php echo get_bloginfo('template_directory'); ?>';
		url_home = '<?php echo get_bloginfo('home'); ; ?>';
	//]]>
	</script>

	<?php wp_head();?>
  </head>

  <body  <?php if(!is_home()) { ?>data-spy="scroll" data-target=".bs-docs-sidebar" <?php } ?>>
	<header class="jumbotron subhead" id="overview">
	  <div class="container">
		<h1><a class="link_home" href="<?php bloginfo('home');?>"><?php bloginfo('name');?></a></h1>
		<p class="lead"><?php bloginfo('description');?></p>
	  </div>
	</header>
	<div class="navbar navbar-main">
		  <div class="navbar-inner">
			<div class="container-menu">
				<?php custom_main_nav(); // Adjust using Menus in Wordpress Admin ?>
		  </div>
		</div>
	</div>
	