<?php
if (!class_exists('JobsShortcodes')) {
    class JobsShortcodes
    {
        function __construct()
        {
            add_shortcode('jobs_manager_modal_form', array($this, 'jobs_manager_modal_form'));
            add_shortcode('jobm_form_link', array($this, 'jobs_manager_modal_form'));
            add_shortcode('jobm_application_pack_link', array($this, 'jobm_application_pack_link'));
        }

        function jobs_manager_modal_form()
        {
            $JobsManager = new JobsManager;
            ob_start();
?>
            <div class="modal right fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
                <div class="modal-dialog align-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="applyModalLabel">Apply for our <span></span> position</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body contact-form-v2">
                            <?php
                            if ($JobsManager->jobs_contact_form()) {
                                echo do_shortcode($JobsManager->jobs_contact_form());
                            } else {
                                echo '<h2> Contact Form Shortcode Error </h2>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
            return ob_get_clean();
        }

        function jobm_form_link($atts)
        {
            extract(
                shortcode_atts(
                    array(
                        'text' => 'Apply Now',
                    ),
                    $atts
                )
            );

            return '<a class="apply-button" href="#" data-title="' . get_the_title() . '" data-bs-toggle="modal" data-bs-target="#applyModal"> ' . $text . ' </a>';
        }

        function jobm_application_pack_link($atts)
        {
            $JobsManager = new JobsManager;
            $application_pack = $JobsManager->get__post_meta('application_pack');

            if ($application_pack) {
                extract(
                    shortcode_atts(
                        array(
                            'text' => 'Apply Now',
                        ),
                        $atts
                    )
                );

                return '<a href="' . wp_get_attachment_url($application_pack) . '"> ' . $text . ' </a>';
            } else {
                return 'No application pack';
            }
        }
    }
}

new JobsShortcodes();
