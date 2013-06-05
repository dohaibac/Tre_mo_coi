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
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery.js"></script>
	<?php wp_head(); ?>
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/custom.modernizr.js"></script>	
	
	<!-- Fancy box -->
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/fancybox/source/jquery.fancybox.js?v=2.1.4"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/source/jquery.fancybox.css?v=2.1.4" media="screen" />
	<script language="javascript">
	$(document).ready(function(){		
		$("#login_button").fancybox({
		width: 330,
		height: 306,
		scrolling: 'no',
		helpers: {
			title : {
				type : 'outside'
			},
			overlay : {
				speedOut : 0
			}
		}
		});
	});
	</script>
</head>
<body>
	<div id="login_box" style="display:none;width:300px;height:306px;">
		<div>
			<img src="<?php echo get_template_directory_uri(); ?>/images/login-header.png" width="300" />
		</div>
		<br />
			<div>
			  <div class="large-12 columns" style="padding-left:0px;padding-right:0px;width:300px;">
				<div class="left"style="margin-top:7px;">
				<label><b>Tên đăng nhập</b></label>
				</div>
				<div class="right" style="margin-left:10px;">
				<input type="text" value="" style="width:170px;">
				</div>
			  </div>
			  <div style="clear:both;"></div>
			</div>
			<div>
			  <div class="large-12 columns" style="padding-left:0px;padding-right:0px;width:300px;">
			  <div class="left"style="margin-top:7px;">
				<label><b>Mật khẩu</b></label>
			  </div>
			  <div class="right" style="margin-left:10px;">
				<input type="password" value=""  style="width:170px;">
			  </div>
			  </div>
			  <div style="clear:both;"></div>
			</div>
			<div>
			<div class="left" style="margin-top:8px;font-size:14px;">
			<label for="rememberme"><input style="margin:0 0 0 0;vertical-align:middle;" name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90"> <span>Tự động đăng nhập lần sau</span>
			</label>
			</div>
			<div class="right">
			<a href="#" class="success small button" title="Đăng nhập">Đăng nhập</a>
			</div>
				<div style="clear:both;"></div>
			</div>
		
			<div>
				<div class="left" style="font-size:17px;font-weight:bold;margin-top:7px;">Đăng nhập bằng</div>
				<div class="right">
				<a href="#" id="login_by_facebook" title="Đăng nhập bằng Facebook" style="background:url(<?php echo get_template_directory_uri(); ?>/images/facebook-and-twitter-logo-png-8115.png) -35px 0px no-repeat;display:block;width:35px;height:34px;float:left;"></a>
				<a href="#" id="login_by_twitter" title="Đăng nhập bằng Twitter" style="background:url(<?php echo get_template_directory_uri(); ?>/images/facebook-and-twitter-logo-png-8115.png) 0px 0px no-repeat;display:block;width:35px;height:34px;float:left;margin-left:5px;"></a>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="font-style:italic;font-size:14px;margin-top:7px;">
				Chưa có tài khoản? Click vào <a href="/sign-up">đây</a> để đăng ký
			</div>
		<div style="clear:both;"></div>
	</div>
	<header class="main-header">
		<div class="row">
			<div class="large-12 columns left"style="width:75%;">
				<div>
				<h2 class="title"><a class="link_home" href="<?php bloginfo('home');?>/"><?php bloginfo('name');?></a></h2>
				<p class="lead"><?php bloginfo('description');?></p>
				</div>
			</div>
			<div class="right" style="padding-right:20px;position:relative;z-index:1000;">
			<a href="#login_box" id="login_button" class="small button">Đăng nhập</a> | <a id="register_button" href="#" class="small button">Đăng ký</a>
			</div>
		</div>
	</header>
	<section class="main-menu">
	<div class="row">
		<nav class="top-bar">
		  <section class="top-bar-section">
			<!-- Left Nav Section -->
			<?php custom_main_nav('main_nav'); // Adjust using Menus in Wordpress Admin ?>			

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
					  <a href="#" class="alert button">Tìm kiếm</a>
					</div>
				  </div>
				</form>
			  </li>
			</ul>
		  </section>
		</nav>
	</div>
	</section>