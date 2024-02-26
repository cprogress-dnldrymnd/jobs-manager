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
            add_action('init', array($this, 'jobsmanager_setup_post_type'));
            add_action('wp_enqueue_scripts', array($this, 'assets'));
        }

        function assets()
        {
            wp_register_style('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager-styles.css');
        }

        function jobsmanager_setup_post_type()
        {

            require_once('includes/post-types.php');


            $Solutions = new newPostType();
            $Solutions->name = 'Solutions';
            $Solutions->singular_name = 'Solution';
            $Solutions->icon = 'dashicons-portfolio';
            $Solutions->supports = array('title', 'revisions', 'editor', 'thumbnail', 'page-attributes');
            $Solutions->has_archive = true;
            $Solutions->hierarchical = true;
            $Solutions->show_in_rest = true;
            
            
        }
    }
}


new JobsManager();
