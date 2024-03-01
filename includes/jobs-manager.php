<?php
if (!class_exists('JobsManager')) {
    class JobsManager
    {
        function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'assets'));
            add_action('template_include', array($this, 'wpse_force_template'));
            add_action('jobs_manager_modal_form', array($this, 'jobs_manager_modal_form'));
        }

        function assets()
        {

            if (is_post_type_archive('jobs') || get_post_type() == 'jobs') {

                $JobsManager = new JobsManager;

                wp_enqueue_style('jobsmanager-niceselect', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css');
                wp_enqueue_script('jobsmanager-niceselect', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js');

                wp_enqueue_style('jobsmanager-style', WP_PLUGIN_URL  . '/jobs-manager/assets/scss/jobsmanager.css');
                wp_enqueue_script('jobsmanager-style', WP_PLUGIN_URL . '/jobs-manager/assets/js/jobsmanager.js');


                if (!$JobsManager->disable_bootstrap()) {
                    wp_enqueue_style('jobsmanager-bootstrap', 'https: //cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
                    wp_enqueue_script('jobsmanager-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js');
                }
            }
        }


        // Add a filter to 'template_include' hook
        function wpse_force_template($template)
        {
            // If the current url is an archive of any kind
            if (is_archive('jobs')) {
                // Set this to the template file inside your plugin folder
                $template = WP_PLUGIN_DIR . '/jobs-manager/archive-jobs.php';
            } else if (is_single() && get_post_type() == 'jobs') {
                $template = WP_PLUGIN_DIR . '/jobs-manager/single-jobs.php';
            }
            // Always return, even if we didn't change anything
            return $template;
        }

        function jobs_manager_modal_form()
        {
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
                            if ($this->jobs_contact_form()) {
                                echo do_shortcode($this->jobs_contact_form());
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

        function get__post_meta($value)
        {
            if (function_exists('carbon_get_the_post_meta')) {
                return carbon_get_the_post_meta($value);
            } else {
                return 'Error: Carbonfield not activated';
            }
        }

        function get__term_meta($term_id, $value)
        {
            if (function_exists('carbon_get_term_meta')) {
                return carbon_get_term_meta($term_id, $value);
            } else {
                return 'Error: Carbonfield not activated';
            }
        }

        function get__post_meta_by_id($id, $value)
        {
            if (function_exists('carbon_get_post_meta')) {
                return carbon_get_post_meta($id, $value);
            } else {
                return 'Error: Carbonfield not activated';
            }
        }
        function get__theme_option($value)
        {
            if (function_exists('carbon_get_theme_option')) {
                return carbon_get_theme_option($value);
            } else {
                return 'Error: Carbonfield not activated';
            }
        }

        function disable_bootstrap()
        {
            return $this->get__theme_option('jobs_disable_bootstrap');
        }

        function jobs_single()
        {
            return $this->get__theme_option('jobs_single');
        }

        function jobs_slug()
        {
            return $this->get__theme_option('jobs_slug');
        }

        function jobs_alt_title()
        {
            return $this->get__theme_option('jobs_alt_title');
        }

        function jobs_description()
        {
            return $this->get__theme_option('jobs_description');
        }

        function jobs_contact_form()
        {
            return $this->get__theme_option('jobs_contact_form');
        }

        function get_terms_details($taxonomy, $hide_empty = false, $order = false)
        {
            $args = array(
                'taxonomy' => $taxonomy,
                'hide_empty' => $hide_empty,
            );
            if ($order) {
                $args['meta_key'] = '_order';
                $args['orderby'] = '_order';
            }
            $terms = get_terms($args);

            if (!$terms) return;
            $term_array = array();
            foreach ($terms as $term) {
                $term_array[$term->term_id] = array(
                    'name' => $term->name,
                    'short_description' => carbon_get_term_meta($term->term_id, 'short_description'),
                    'icon' => carbon_get_term_meta($term->term_id, 'icon'),
                );
            }
            return $term_array;
        }
    }
}

new JobsManager();
