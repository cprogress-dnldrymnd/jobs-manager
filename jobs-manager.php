<?php

/**
 * Jobs Manager
 *
 * @author            Donald Raymundo
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Jobs Manager
 * Description:       Jobs Manager by Digitally Disruptive
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Donald Raymundo
 * Text Domain:       jobsmanager
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */



if (!class_exists('JobsManager')) {
    class JobsManager
    {
        var $api_key;

        function __construct()
        {
            require_once('includes/post-types.php');
        }


        public function initialize()
        {

            register_activation_hook(__FILE__, array($this, 'jobsmanager_plugin_activated'));
            register_deactivation_hook(__FILE__, 'jobsmanager_plugin_deactivate');

            function assets()
            {
                wp_register_style('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager-styles.css');
            }

            function jobsmanager_setup_post_type()
            {
                $Testimonials = new newPostType();
                $Testimonials->name = 'Testimonials';
                $Testimonials->singular_name = 'Testimonial';
                $Testimonials->icon = 'dashicons-testimonial';
                $Testimonials->supports = array('title', 'revisions');
                $Testimonials->exclude_from_search = true;
                $Testimonials->publicly_queryable = false;
                $Testimonials->show_in_admin_bar = false;
                $Testimonials->has_archive = false;
            }

            function jobsmanager_plugin_activated()
            {
                $this->jobsmanager_setup_post_type();
                // Clear the permalinks after the post type has been registered.
                flush_rewrite_rules();
            }

            function jobsmanager_plugin_deactivate()
            {
                // Unregister the post type, so the rules are no longer in memory.
                unregister_post_type('jobs');
                // Clear the permalinks to remove our post type's rules from the database.
                flush_rewrite_rules();
            }

            add_action('wp_enqueue_scripts', array($this, 'assets'));
        }
    }
}


new JobsManager();
