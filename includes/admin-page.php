<?php
class Admin_Page
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'jobsmanager_setup_admin_page'));
        add_action('parent_file', array($this, 'jobsmanager_highlight_taxonomy_parent_menu'));
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

    function jobsmanager_highlight_taxonomy_parent_menu($parent_file)
    {
        if (get_current_screen()->taxonomy == 'question_section') {
            $parent_file = 'edit.php?post_type=quiz';
        }

        return $parent_file;
    }
}

new Admin_Page();
