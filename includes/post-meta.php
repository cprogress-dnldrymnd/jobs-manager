<?php
if (!class_exists('PostMeta')) {
    class PostMeta
    {
        function __construct()
        {
            add_action('admin_notices', array($this, 'jobsmanager_notice'));
            add_action('carbon_fields_register_fields', array($this, 'jobsmanager_post_meta'));
        }

        function jobsmanager_notice()
        {
            if (!function_exists('carbon_get_the_post_meta')) {

?>
                <div class="notice notice-warning ">
                    <p>Carbonfield plugin is required.</p>
                </div>
<?php
            }
        }

        function jobsmanager_post_meta()
        {
            if (function_exists('carbon_get_the_post_meta')) {
                require plugin_dir_path(__FILE__) . 'includes/post-types-fields.php';
            }
        }
    }
}

new PostMeta();
