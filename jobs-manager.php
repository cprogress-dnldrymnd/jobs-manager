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
            add_action('wp_enqueue_scripts', array($this, 'assets'));
            add_action('init', array($this, 'jobsmanager_setup_post_type'));
            add_action('init', array($this, 'jobsmanager_setup_taxonomy'));
            add_action('admin_menu', array($this, 'jobsmanager_setup_admin_page'));
        }

        function assets()
        {
            wp_register_style('jobsmanager-style', plugin_dir_url(__FILE__) . 'jobsmanager-styles.css');
        }

        function jobsmanager_setup_post_type()
        {

            $labels = array(
                'name'                  => _x('Jobs', 'Job General Name', 'jobsmanager'),
                'singular_name'         => _x('Job', 'Job Singular Name', 'jobsmanager'),
                'menu_name'             => __('Jobs', 'jobsmanager'),
                'name_admin_bar'        => __('Job', 'jobsmanager'),
                'archives'              => __('Item Archives', 'jobsmanager'),
                'attributes'            => __('Item Attributes', 'jobsmanager'),
                'parent_item_colon'     => __('Parent Item:', 'jobsmanager'),
                'all_items'             => __('All Items', 'jobsmanager'),
                'add_new_item'          => __('Add New Item', 'jobsmanager'),
                'add_new'               => __('Add New', 'jobsmanager'),
                'new_item'              => __('New Item', 'jobsmanager'),
                'edit_item'             => __('Edit Item', 'jobsmanager'),
                'update_item'           => __('Update Item', 'jobsmanager'),
                'view_item'             => __('View Item', 'jobsmanager'),
                'view_items'            => __('View Items', 'jobsmanager'),
                'search_items'          => __('Search Item', 'jobsmanager'),
                'not_found'             => __('Not found', 'jobsmanager'),
                'not_found_in_trash'    => __('Not found in Trash', 'jobsmanager'),
                'featured_image'        => __('Featured Image', 'jobsmanager'),
                'set_featured_image'    => __('Set featured image', 'jobsmanager'),
                'remove_featured_image' => __('Remove featured image', 'jobsmanager'),
                'use_featured_image'    => __('Use as featured image', 'jobsmanager'),
                'insert_into_item'      => __('Insert into item', 'jobsmanager'),
                'uploaded_to_this_item' => __('Uploaded to this item', 'jobsmanager'),
                'items_list'            => __('Items list', 'jobsmanager'),
                'items_list_navigation' => __('Items list navigation', 'jobsmanager'),
                'filter_items_list'     => __('Filter items list', 'jobsmanager'),
            );
            $args = array(
                'label'                 => __('Job', 'jobsmanager'),
                'description'           => __('Job Description', 'jobsmanager'),
                'labels'                => $labels,
                'supports'              => false,
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-businessperson',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
            );
            register_post_type('jobs', $args);
        }

        function jobsmanager_setup_taxonomy()
        {

            $labels = array(
                'name'                       => _x('Locations', 'Location General Name', 'jobsmanager'),
                'singular_name'              => _x('Location', 'Location Singular Name', 'jobsmanager'),
                'menu_name'                  => __('Location', 'jobsmanager'),
                'all_items'                  => __('All Items', 'jobsmanager'),
                'parent_item'                => __('Parent Item', 'jobsmanager'),
                'parent_item_colon'          => __('Parent Item:', 'jobsmanager'),
                'new_item_name'              => __('New Item Name', 'jobsmanager'),
                'add_new_item'               => __('Add New Item', 'jobsmanager'),
                'edit_item'                  => __('Edit Item', 'jobsmanager'),
                'update_item'                => __('Update Item', 'jobsmanager'),
                'view_item'                  => __('View Item', 'jobsmanager'),
                'separate_items_with_commas' => __('Separate items with commas', 'jobsmanager'),
                'add_or_remove_items'        => __('Add or remove items', 'jobsmanager'),
                'choose_from_most_used'      => __('Choose from the most used', 'jobsmanager'),
                'popular_items'              => __('Popular Items', 'jobsmanager'),
                'search_items'               => __('Search Items', 'jobsmanager'),
                'not_found'                  => __('Not Found', 'jobsmanager'),
                'no_terms'                   => __('No items', 'jobsmanager'),
                'items_list'                 => __('Items list', 'jobsmanager'),
                'items_list_navigation'      => __('Items list navigation', 'jobsmanager'),
            );
            $args = array(
                'labels'                     => $labels,
                'hierarchical'               => false,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
            );
            register_taxonomy('location', array('jobs'), $args);
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

new JobsManager();
