<?php
class JobsShortcodes
{
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
}
$Shortcodes = new JobsShortcodes;

add_shortcode('jobs_manager_modal_form', array($this, 'jobs_manager_modal_form'));