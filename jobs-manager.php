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
                'name'                  => _x('Jobs', 'Job General Name', 'text_domain'),
                'singular_name'         => _x('Job', 'Job Singular Name', 'text_domain'),
                'menu_name'             => __('Jobs', 'text_domain'),
                'name_admin_bar'        => __('Job', 'text_domain'),
                'archives'              => __('Item Archives', 'text_domain'),
                'attributes'            => __('Item Attributes', 'text_domain'),
                'parent_item_colon'     => __('Parent Item:', 'text_domain'),
                'all_items'             => __('All Items', 'text_domain'),
                'add_new_item'          => __('Add New Item', 'text_domain'),
                'add_new'               => __('Add New', 'text_domain'),
                'new_item'              => __('New Item', 'text_domain'),
                'edit_item'             => __('Edit Item', 'text_domain'),
                'update_item'           => __('Update Item', 'text_domain'),
                'view_item'             => __('View Item', 'text_domain'),
                'view_items'            => __('View Items', 'text_domain'),
                'search_items'          => __('Search Item', 'text_domain'),
                'not_found'             => __('Not found', 'text_domain'),
                'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
                'featured_image'        => __('Featured Image', 'text_domain'),
                'set_featured_image'    => __('Set featured image', 'text_domain'),
                'remove_featured_image' => __('Remove featured image', 'text_domain'),
                'use_featured_image'    => __('Use as featured image', 'text_domain'),
                'insert_into_item'      => __('Insert into item', 'text_domain'),
                'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
                'items_list'            => __('Items list', 'text_domain'),
                'items_list_navigation' => __('Items list navigation', 'text_domain'),
                'filter_items_list'     => __('Filter items list', 'text_domain'),
            );
            $args = array(
                'label'                 => __('Job', 'text_domain'),
                'description'           => __('Job Description', 'text_domain'),
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
                'name'                       => _x('Locations', 'Location General Name', 'text_domain'),
                'singular_name'              => _x('Location', 'Location Singular Name', 'text_domain'),
                'menu_name'                  => __('Location', 'text_domain'),
                'all_items'                  => __('All Items', 'text_domain'),
                'parent_item'                => __('Parent Item', 'text_domain'),
                'parent_item_colon'          => __('Parent Item:', 'text_domain'),
                'new_item_name'              => __('New Item Name', 'text_domain'),
                'add_new_item'               => __('Add New Item', 'text_domain'),
                'edit_item'                  => __('Edit Item', 'text_domain'),
                'update_item'                => __('Update Item', 'text_domain'),
                'view_item'                  => __('View Item', 'text_domain'),
                'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
                'add_or_remove_items'        => __('Add or remove items', 'text_domain'),
                'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
                'popular_items'              => __('Popular Items', 'text_domain'),
                'search_items'               => __('Search Items', 'text_domain'),
                'not_found'                  => __('Not Found', 'text_domain'),
                'no_terms'                   => __('No items', 'text_domain'),
                'items_list'                 => __('Items list', 'text_domain'),
                'items_list_navigation'      => __('Items list navigation', 'text_domain'),
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
            add_menu_page('Test Plugin Page', 'Test Plugin', 'manage_options', 'test-plugin', $this->jobsmanager_setup_admin_page_init());
        }

        function jobsmanager_setup_admin_page_init()
        {
            echo "<h1>Hello World!</h1>";
        }
    }
}

new JobsManager();
