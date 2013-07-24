<!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<!--[if IE 8]><html class="lt-ie9 " xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html xmlns="http://www.w3.org/1999/xhtml"><!--<![endif]-->
    <head>
        <!-- Title -->
        <title>
            <?php
            /*
             * Print the <title> tag based on what is being viewed.
             */

            global $page, $paged, $classbody;

            wp_title('|', true, 'right');

            // Add the blog name.
            bloginfo('name');

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && ( is_home() || is_front_page() ))
                echo " | $site_description";
		?>
	</title>
	<!-- Meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />	
	<link rel="alternate" type="text/xml" title="<?php wp_title( '|', true, 'right' ); ?>" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php wp_title( '|', true, 'right' ); ?>" href="<?php bloginfo('atom_url'); ?>" />	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
	<link rel="pingback" href="<?php bloginfo('home')?>/xmlrpc.php" />
	<!-- Add css -->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/foundation.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/default.css" media="all"  />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" media="all"  />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url');?>" media="screen" />
	<link href='http://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<script type="text/javascript">
	//<![CDATA[
	ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	url_theme = '<?php echo get_bloginfo('template_directory'); ?>';
	url_home = '<?php echo get_bloginfo('home'); ; ?>';
	tmc_backurl = '';
	//]]>
	</script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery.js"></script>	
	<?php wp_head(); ?>
	<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/custom.modernizr.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/js/player-video/jwplayer.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/js/player-video/swfobject.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.jcarousellite.js"></script>		
</head>
<body>
<script language="javascript">(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<div class="wrapper">
		<div class="wrapper-content">
			<div class="row header">
				<div class="large-12 columns">
					<h2><a href="<?php bloginfo('home');?>/" class="logo"></a></h2>
					<div class="user-box" id="tmc_user_panel">
						<a class="small" id="tmc_login_button" href="#login">Đăng nhập</a> | 
						<a class="small" href="#register" id="tmc_register_button">Đăng ký</a>
					</div>
					<div class="box-search">
						<form  method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
							<div class="row collapse">
								<div class="small-7 columns" style="position: relative;">
									<input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" type="text" placeholder="Nhập từ khóa..."/>
									<span class="tooltip" style="display: none;left: 0;min-width: 140px;width: 140px;position: absolute;top: 41px;visibility: visible; font-size:12px;">Vui lòng nhập từ khóa<span class="nub"></span></span>
								</div>
								<div class="small-5 columns">
									<button id="search_button" 
											class="alert button"
											href="javascript:void(0);">Tìm kiếm</button>
								</div>
							</div>
						</form>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery("form#searchform #s").hover( function(e) {
									if(jQuery.trim(jQuery(this).val()) ==''){
										jQuery('form#searchform span.tooltip').fadeIn();
									} else {
										jQuery('form#searchform span.tooltip').fadeOut();
									}
								}, function(){
									jQuery('form#searchform span.tooltip').fadeOut();
								});
								jQuery("form#searchform #s").bind('input', function() { 
									if(jQuery.trim(jQuery(this).val()) ==''){
										jQuery('form#searchform span.tooltip').fadeIn();
									} else {
										jQuery('form#searchform span.tooltip').fadeOut();
									}
								});
								jQuery("form#searchform #s").focusout( function(e) {
									jQuery('form#searchform span.tooltip').fadeOut();
								});
								jQuery('form#searchform').submit(function(){
									var keyword = jQuery.trim(jQuery('form#searchform #s').val());
									if(keyword == ''){
										jQuery('form#searchform span.tooltip').fadeIn();
										jQuery('form#searchform #s').focus();
										return false;
									} else {
										jQuery('form#searchform span.tooltip').fadeOut();
									}
								});
							});
						</script>
					</div>
				</div>
			</div><!--end .header-->
		
			<div class="row main">
				<div class="row main-menu top-bar">
					<section class="top-bar-section">
						<!-- Left Nav Section -->
						<?php custom_main_nav('main_nav'); // Adjust using Menus in Wordpress Admin ?>	
                        </section>
                    </div><!--end .main-->
                    <div class="row main-content">
						<div class="shadow-box hide-for-medium-up" style="margin-bottom: 18px !important;text-align:center">
							<a class="don-nhan-yeu-thuong" href="<?php echo get_permalink( get_page_by_path( 'don-nhan-yeu-thuong' ) );?>"><img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/don-nhan-yeu-thuong.png"/></a>
						</div>
						<div class="shadow-box hide-for-medium-up" style="text-align:center">
							<a class="nhap-thong-tin-tre-mo-coi" href="<?php echo get_permalink( get_page_by_path( 'nhap-thong-tin-tre-mo-coi' ) );?>"><img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/dang-thong-tin-tre-em.png"/></a>
						</div>