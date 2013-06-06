<?php
add_action('wp_tag_cloud', 'style_tag_cloud');
add_action('wp_head', 'tp_header');
add_action('wp_head', 'templatelite_wp_head');
add_filter( 'wp_page_menu_args', 'templatelite_page_menu_args' );

//add_editor_style();// This theme styles the visual editor with editor-style.css to match the theme style.
add_theme_support('post-thumbnails',array( 'post', 'page'));
add_theme_support( 'automatic-feed-links' );

load_theme_textdomain( 'templatelite', TEMPLATEPATH . '/languages' );
?>