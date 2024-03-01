<?php
class Admin_Page
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'jobsmanager_setup_admin_page'));
    }

    function jobsmanager_setup_admin_page()
    {
        add_menu_page('Job Manager', 'Job Manager', 'manage_options', 'jobsmanager');

        /**
         * Adds a submenu page under a custom post type parent.
         */

        add_submenu_page(
            'jobsmanager',
            __('Settings', 'jobsmanager'),
            __('Settings', 'jobsmanager'),
            'manage_options',
            'job-manager-settings',
            array($this, 'jobsmanager_setup_admin_page_init'),
        );

        add_submenu_page(
            'jobsmanager',
            __('Job Manager', 'jobsmanager'),
            __('Job Manager', 'jobsmanager'),
            'manage_categories',
            'edit-tags.php?taxonomy=location',
        );
    }

    function jobsmanager_setup_admin_page_init()
    {
        echo "<h1>Job Manager</h1>";
    }
}

new Admin_Page();
