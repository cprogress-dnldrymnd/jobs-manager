<?php
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
