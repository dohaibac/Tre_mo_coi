<?php
/* preset FGC setting*/
if(file_exists(TEMPLATEPATH."/includes/options-init.php")) require_once TEMPLATEPATH."/includes/options-init.php";

/* Designed by Templatelite.com */
$tpinfo['themename']='Girly Nature';
$tpinfo['prefix']='templatelite'; 		//for options. e.g. all templatelite themes should use "templatelite" for general options (feed url, twitter id, analytics)
$tpinfo['tb_prefix']='templatelite_girly';//for options. theme base prefix, e.g. for styles.

function templatelite_widgets_init(){
	register_nav_menus( array(
		'primary' =>'Primary Menu'
		));

	register_sidebar(array(
		'name' =>'Sidebar 1',
		'id' =>'sidebar-1',
		'description'=> 'The left sidebar',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'));

	register_sidebar(array(
		'name' =>'Sidebar 2',
		'id' =>'sidebar-2',
		'description'=> 'The right sidebar',
		'before_widget' => '<li id="%1$s" class="%2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'));
			
		//unregister_sidebar_widget('Search');
		//unregister_sidebar_widget('tag_cloud');
}
add_action( 'widgets_init', 'templatelite_widgets_init');

include(TEMPLATEPATH.'/includes/theme-functions.php');
include(TEMPLATEPATH.'/includes/theme-options.php');
include(TEMPLATEPATH.'/includes/theme-setup.php');
include(TEMPLATEPATH.'/includes/admin-interface.php');
include(TEMPLATEPATH.'/includes/admin-widgets.php');
include(TEMPLATEPATH.'/template.php');
?>