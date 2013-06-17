<?php

/*
  Plugin Name: Ajax Search
  Plugin URI: 
  Description: a plugin to load search results by AJAX
  Version: 0.1
  Author: hieu.tran
  Author URI: 
  License: GPL2
 */
add_action("wp_ajax_ajax_display_results", "ajax_display_results");
add_action("wp_ajax_nopriv_ajax_display_results", "ajax_display_results");

function ajax_display_results() {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result = json_encode($result);
        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}

//Add JS
add_action('init', 'my_script_enqueuer');

function my_script_enqueuer() {
    wp_register_script("ajax_search", WP_PLUGIN_URL . '/ajax_search_display/includes/js/
ajax_search.js', array('jquery'));
    wp_localize_script('ajax_search', 'myAjax', array('ajaxurl'
        => admin_url('admin-ajax.php')));
    wp_enqueue_script('jquery');
    wp_enqueue_script('ajax_search');
}


?>