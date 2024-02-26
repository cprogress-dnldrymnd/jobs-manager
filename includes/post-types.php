<?php
if (!class_exists('newPostType')) {
    class newPostType
    {
        public $name;
        public $singular_name;
        public $icon;
        public $supports;
        public $rewrite;
        public $show_in_rest = false;
        public $exclude_from_search = false;
        public $publicly_queryable = true;
        public $show_in_admin_bar = true;
        public $has_archive = true;
        public $hierarchical = false;

        function __construct()
        {

            add_action('init', array($this, 'create_post_type'));
        }

        function create_post_type()
        {
            register_post_type(
                strtolower($this->name),
                array(
                    'labels'              => array(
                        'name'               => _x($this->name, 'post type general name'),
                        'singular_name'      => _x($this->singular_name, 'post type singular name'),
                        'menu_name'          => _x($this->name, 'admin menu'),
                        'name_admin_bar'     => _x($this->singular_name, 'add new on admin bar'),
                        'add_new'            => _x('Add New', strtolower($this->name)),
                        'add_new_item'       => __('Add New ' . $this->singular_name),
                        'new_item'           => __('New ' . $this->singular_name),
                        'edit_item'          => __('Edit ' . $this->singular_name),
                        'view_item'          => __('View ' . $this->singular_name),
                        'all_items'          => __('All ' . $this->name),
                        'search_items'       => __('Search ' . $this->name),
                        'parent_item_colon'  => __('Parent :' . $this->name),
                        'not_found'          => __('No ' . strtolower($this->name) . ' found.'),
                        'not_found_in_trash' => __('No ' . strtolower($this->name) . ' found in Trash.')
                    ),
                    'show_in_rest'        => $this->show_in_rest,
                    'supports'            => $this->supports,
                    'public'              => true,
                    'has_archive'         => $this->has_archive,
                    'hierarchical'        => $this->hierarchical,
                    'rewrite'             => $this->rewrite,
                    'menu_icon'           => $this->icon,
                    'capability_type'     => 'page',
                    'exclude_from_search' => $this->exclude_from_search,
                    'publicly_queryable'  => $this->publicly_queryable,
                    'show_in_admin_bar'   => $this->show_in_admin_bar,
                )
            );
        }
    }
}