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
    jQuery('.page').live('click', function(e) {
        e.preventDefault();
        var link = jQuery(this).attr('href');
        alert(document.location);
        jQuery('.wp-tab-content').html('Vui lòng đợi...');
        post_types = jQuery(this).attr("post_types");
        page = jQuery(this).attr("title");
        jQuery.get(document.pathname, {
            post_types: post_types, paged: page}, function(data) {
            if (data.length > 0) {
                var $response = $(data);                
                jQuery(".wp-tab-content").html(
                        $response.find('.wp-tab-content').html());
                jQuery(".ui-tabs-anchor").html(
                        $response.find('.wp-tab-title').html());
                jQuery('.wp-tab-content').hide().fadeIn(
                        1500);
            }
        });

    });

    jQuery("#p-search").live("click", function(e) {
        e.preventDefault();
        post_types = jQuery(this).attr("post_types");
        jQuery.get(document.pathname, {
            post_types: post_types, paged: '1'}, function(data) {
            if (data.length > 0) {
                var $response = $(data);
                jQuery(".wp-tab-content").html('Vui lòng đợi...');
                jQuery(".wp-tab-content").html(
                        $response.find('.wp-tab-content').html());
                jQuery(".ui-tabs-anchor").html(
                        $response.find('.wp-tab-title').html());
                jQuery('.wp-tab-content').hide().fadeIn(
                        1500);
                jQuery('.page').attr('post_types', post_types);
            }
        });
    });
});