<?php
if (!class_exists('JobsManager')) {
    class JobsManager
    {
        function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'assets'));
        }

        function assets()
        {
            wp_enqueue_style('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager.css');
            wp_enqueue_script('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager.js');
        }
    }
}

new JobsManager();