<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="<?php language_attributes();?>" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php language_attributes();?>" > <!--<![endif]-->
<head>
	<!-- Title -->
	<title>
	<?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */

		global $page, $paged,$classbody;
		
		wp_title( '|', true, 'right' );

		// Add the blog name.
		bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'theme-orphan' ), max( $paged, $page ) );

		?>
	</title>
	<!-- Meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- Add css -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/foundation.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url');?>" media="screen" />
	<link href='http://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<<<<<<< HEAD
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery.js"></script>
=======
	<script type="text/javascript">
	//<![CDATA[
	ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	url_theme = '<?php echo get_bloginfo('template_directory'); ?>';
	url_home = '<?php echo get_bloginfo('home'); ; ?>';
	//]]>
	</script>
>>>>>>> 9abad1de5bda0c946b66f262a4b238add48472a9
	<?php wp_head(); ?>
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/custom.modernizr.js"></script>	
</head>
<body>
<header class="main-header">
		<div class="row">
			<div class="large-12 columns left"style="width:60%;">
				<div>
				<h2 class="title"><a class="link_home" href="<?php bloginfo('home');?>/"><?php bloginfo('name');?></a></h2>
				<p class="lead"><?php bloginfo('description');?></p>
				</div>
			</div>
			<div class="right" style="padding-right:20px;position:relative;z-index:1000;" id="tmc_user_panel">
			</div>
		</div>
	</header>
	<section class="main-menu">
	<div class="row">
		<nav class="top-bar">
		  <section class="top-bar-section">
			<!-- Left Nav Section -->
			<?php orphan_custom_main_nav('main_nav'); // Adjust using Menus in Wordpress Admin ?>			

			<!-- Right Nav Section -->
			<ul class="right">
			  <li class="divider"></li>
			  <li class="has-form">
				<form>
				  <div class="row collapse">
					<div class="small-8 columns">
					  <input type="text" value="" type="text" placeholder="Nhập từ khóa..." requied>
					</div>
					<div class="small-4 columns">
					  <a href="#" class="alert button button-tiem-kiem">Tìm kiếm</a>
					</div>
				  </div>
				</form>
			  </li>
			</ul>
		  </section>
		</nav>
	</div>
	</section>