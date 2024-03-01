jQuery(document).ready(function () {
    nice_select();
    ajax_form();
    load_more_button_listener();
    console.log('xxxx');
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
    jQuery(document).on("click", '#load-more-jobs', function (event) {
        event.preventDefault();
        var offset = jQuery('.post-item').length;
        jobs_ajax(offset, 'append');
    });
}



function jobs_ajax($offset, $event_type = 'html') {
    var $loadmore = jQuery('#load-more-jobs');

    var $archive_section = jQuery('.jobs-archive');

    var $result_holder = jQuery('#results .results-holder');

    var $location = jQuery("select[name='location']").val();

    $loading = jQuery('<div class="loading-results"> <svg class="fa-spinner" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" /> <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" /> </svg></div>');

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
                $result_holder_row = $result_holder.find('.job-wrapper');
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