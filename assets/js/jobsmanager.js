jQuery(document).ready(function () {
    nice_select();
    ajax_form_jobs();
    load_more_button_listener();
    job_archive();
});

jQuery('#applyModal').on('show.bs.modal', function (e) {
    jQuery('html').addClass('overflow-hidden');
})
jQuery('#applyModal').on('hide.bs.modal', function (e) {
    jQuery('html').removeClass('overflow-hidden');
})

function job_archive() {
    jQuery('#location').change();

    jQuery(document).on("click", '.apply-button', function (event) {
        $title = jQuery(this).attr('data-title');
        jQuery('input[name="position"]').val($title);
        jQuery('.modal-title span').text($title);
    });

    jQuery('.select-file').click(function (event) {
        jQuery('input[name="CV"]').click();
    });

    jQuery('input[name="CV"]').change(function (event) {
        jQuery('.fake-input').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''));
        jQuery('.form-file').addClass('focused');
    });
}

function nice_select() {
    jQuery('select.nice-select-js').niceSelect();
}

function ajax_form_jobs() {
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

    $loading = jQuery('<div class="loading-results"> <svg class="fa-spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--> <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z" /> </svg></div>');

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