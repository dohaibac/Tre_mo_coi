<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="<?php language_attributes(); ?>" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php language_attributes(); ?>" > <!--<![endif]-->
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
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
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
				</div>
			</div><!--end .header-->
		
			<div class="row main">
				<div class="row main-menu top-bar">
					<section class="top-bar-section">
						<!-- Left Nav Section -->
						<?php custom_main_nav('main_nav'); // Adjust using Menus in Wordpress Admin ?>		

                            <!-- Right Nav Section -->
                            <ul class="right">
                                <li class="has-form">
                                    <form  method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
                                        <div class="row collapse">
                                            <div class="small-7 columns">
                                                <input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" 
                                                       type="text" placeholder="Nhập từ khóa..." 
                                                       required='required' oninvalid="setCustomValidity('Vui lòng nhập từ khóa')"
                                                       oninput="setCustomValidity('')">
                                            </div>
                                            <div class="small-5 columns">
                                                <button id="search_button" 
                                                        class="alert button"
                                                        href="javascript:void(0);">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </section>
                    </div><!--end .main-->
                    <div class="row main-content">
