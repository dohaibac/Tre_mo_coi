jQuery(document).ready(function() {
    //Ajaxify search button
//    jQuery("#search_button").on("click", function(e) {
//        e.preventDefault();
//        jQuery.post(document.pathname, {s: jQuery('#s').val(), paged: '1'},
//        function(data) {
//            if (data.length > 0) {
//                var $response = $(data);
//                jQuery(".content").html(
//                        $response.find('.content').html());
//                jQuery('.content').hide().fadeIn(
//                        1500).highlightFade({color: '#56A7F0'});
//            }
//        });
//    });
    //Ajaxify tre-mo-coi
    jQuery("#o-search").live("click", function(e) {
        e.preventDefault();
        jQuery.post(document.pathname, {
            post_types: 'tre-mo-coi', paged: '1'}, function(data) {
            if (data.length > 0) {
                var $response = $(data);
                jQuery(".wp-tab-content").html(
                        $response.find('.wp-tab-content').html());
                jQuery(".ui-tabs-anchor").html(
                        $response.find('.wp-tab-title').html());
                jQuery('.wp-tab-content').hide().fadeIn(
                        1500).highlightFade({color: '#56A7F0'});
            }
        });
    });
////Ajaxify all
    jQuery("#a-search").live("click", function(e) {
        e.preventDefault();
        jQuery.post('', {paged: '1'}, function(data) {
            if (data.length > 0) {
                var $response = $(data);
                jQuery(".wp-tab-content").html(
                        $response.find('.wp-tab-content').html());
                jQuery(".ui-tabs-anchor").html(
                        $response.find('.wp-tab-title').html());
                jQuery('.wp-tab-content').hide().fadeIn(
                        1500).highlightFade({color: '#56A7F0'});
            }
        });
    });
//Ajaxify post
    jQuery("#p-search").live("click", function(e) {
        e.preventDefault();
        jQuery.post('', {post_types: 'post', paged: '1'}, function(data) {
            if (data.length > 0) {
                var $response = $(data);
                jQuery(".wp-tab-content").html(
                        $response.find('.wp-tab-content').html());
                jQuery(".ui-tabs-anchor").html(
                        $response.find('.wp-tab-title').html());
                jQuery('.wp-tab-content').hide().fadeIn(
                        1500).highlightFade({color: '#56A7F0'});
            }
        });
    });
});