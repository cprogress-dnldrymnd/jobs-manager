jQuery(document).ready(function () {
    nice_select();
    load_more_button_listener();
});

function nice_select() {
    jQuery('select.nice-select-js').niceSelect();
}

function ajax_form() {
    jQuery("#location").change(function (e) {
        e.preventDefault();
        jobs_ajax(0);
    });
}


function load_more_button_listener($) {
    jQuery(document).on("click", '#load-more-careers', function (event) {
        event.preventDefault();
        var offset = jQuery('.post-item').length;
        jobs_ajax(offset, 'append');
    });
}



function jobs_ajax($offset, $event_type = 'html') {
    var $loadmore = jQuery('#load-more-careers');

    var $archive_section = jQuery('.careers-archive');

    var $result_holder = jQuery('#results .results-holder');

    var $location = jQuery("select[name='location']").val();

    $loading = jQuery('<div class="loading-results"> <i class="fa-solid fa-spinner"></i></div>');

    $archive_section.addClass('loading-post');

    if ($event_type == 'html') {
        jQuery('#results  .results-holder').html($loading);
        $loadmore.addClass('d-none');
    } else {
        $loadmore.addClass('loading');
        $loadmore.find('span').text('Loading');
    }

    jQuery.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: {

            action: 'jobs_ajax',

            location: $location,

            offset: $offset
        },

        success: function (response) {
            if ($event_type == 'append') {
                $result_holder_row = $result_holder.find('.career-wrapper');
                jQuery(response).appendTo($result_holder_row);
            } else {
                $result_holder.html(response);
            }
            $loadmore.removeClass('d-none loading');

            $loadmore.find('span').text('Load more');

            $archive_section.removeClass('loading-post');

        }

    });

}