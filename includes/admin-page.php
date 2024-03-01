<?php
class Admin_Page
{
    function __construct()
    {
       add_action('admin_menu', array($this, 'jobsmanager_setup_admin_page'));
    }

    function jobsmanager_setup_admin_page()
    {
        add_menu_page('Job Manager', 'Job Manager', 'manage_options', 'jobsmanager.php', array($this, 'jobsmanager_setup_admin_page_init'));
    }

    function jobsmanager_setup_admin_page_init()
    {
        echo "<h1>Job Manager</h1>";
    }
}

new Admin_Page();