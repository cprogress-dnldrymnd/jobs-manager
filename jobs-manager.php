<?php

/**
 * Jobs Manager
 *
 * @author            Donald Raymundo
 *
 * @wordpress-plugin
 * Plugin Name:       Jobs Manager
 * Description:       Jobs Manager by Digitally Disruptive
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Donald Raymundo
 * Text Domain:       jobsmanager
 */

define('JobsManager_Version', '1.0.0');


require plugin_dir_path(__FILE__) . 'includes/post-types.php';

if (!class_exists('JobsManager')) {
    class JobsManager
    {
        var $api_key;

        function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'assets'));
            add_action('admin_menu', array($this, 'jobsmanager_setup_admin_page'));
        }

        function assets()
        {
            wp_enqueue_style('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager.css');
            wp_enqueue_script('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager.js');
        }


        function jobsmanager_setup_admin_page()
        {
            add_menu_page('Job Manager', 'Job Manager', 'manage_options', 'jobsmanager', array($this, 'jobsmanager_setup_admin_page_init'));
        }

        function jobsmanager_setup_admin_page_init()
        {
            echo "<h1>Job Manager</h1>";
        }
    }
}

function jobsmanager_create_post_type()
{
    $Jobs = new PostType();
    $Jobs->name = 'Jobs';
    $Jobs->singular_name = 'Job';
    $Jobs->icon = 'dashicons-businessperson';
    $Jobs->supports = array('title', 'revisions');
    $Jobs->exclude_from_search = true;
    $Jobs->publicly_queryable = false;
    $Jobs->show_in_admin_bar = false;
    $Jobs->has_archive = false;
}

function run()
{
    jobsmanager_create_post_type();
}

run();
