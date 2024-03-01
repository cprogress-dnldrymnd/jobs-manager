<?php
get_header();
$JobsManager = new JobsManager;
$terms = $JobsManager->get_terms_details('location');
$jobs_alt_title = $JobsManager->jobs_alt_title();
$jobs_description = $JobsManager->jobs_description();
?>
<main id="main">

    <section class="jobs-title-section">
        <div class="container">
            <div class="heading-box">
                <h1>
                    <?= $jobs_alt_title ? $jobs_alt_title : 'Jobs' ?>
                </h1>
            </div>
            <?php if ($jobs_description) { ?>
                <div class="description-box">
                    <?= wpautop($jobs_description) ?>
                </div>
            <?php } ?>

        </div>
    </section>

    <section class="careers-archive background-light">
        <div class="container container wide w-960">
            <div class="filter-wrapper text-end">
                <select id="location" name="location" class="nice-select-js nice-select-style-1 nice-select-transparent">
                    <option value=""> All Locations </option>
                    <?php if ($terms) { ?>
                        <?php foreach ($terms as $key => $term) { ?>
                            <?php
                            if ($main_query->term_id == $key) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            ?>
                            <option <?= $selected ?> value="<?= $key ?>"> <?= $term['name'] ?> </option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div id="results">
                <div class="results-holder">

                </div>
            </div>
            <div class="load-more text-center">
                <a href="#" id="load-more-careers" class="d-none underline-link">
                    <span>Load more</span>
                    <i class="fa-solid fa-spinner"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal right fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Apply for our <span></span> position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body contact-form-v2">
                    <?= do_shortcode(carbon_get_theme_option('careers_contact_form')) ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
?>


<script>
    jQuery(document).ready(function($) {
        jQuery('#location').change();

        jQuery(document).on("click", '.apply-button', function(event) {
            $title = jQuery(this).attr('data-title');
            jQuery('input[name="position"]').val($title);
            jQuery('.modal-title span').text($title);
        });

        jQuery('.select-file').click(function(event) {
            jQuery('input[name="CV"]').click();
        });

        jQuery('input[name="CV"]').change(function(event) {
            jQuery('.fake-input').text(jQuery(this).val().replace(/C:\\fakepath\\/i, ''));
            jQuery('.form-file').addClass('focused');
        });
    });

    jQuery('#applyModal').on('show.bs.modal', function(e) {
        jQuery('html').addClass('overflow-hidden');
    })
    jQuery('#applyModal').on('hide.bs.modal', function(e) {
        jQuery('html').removeClass('overflow-hidden');
    })
</script>