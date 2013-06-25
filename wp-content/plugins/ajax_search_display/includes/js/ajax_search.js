jQuery(document).ready(function() {
    jQuery("#p-search").live("click", function(e) {
        e.preventDefault();
        jQuery('.wp-tab-content').html('Vui lòng đợi...');
        post_types = jQuery(this).attr("post_types");
        jQuery.get(document.pathname, {
            post_types: post_types, paged: '1'}, function(data) {
            if (data.length > 0) {
                var $response = $(data);
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