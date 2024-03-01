<?php
if (!class_exists('PostMeta')) {
    class PostMeta
    {
        function __construct()
        {
            add_action('admin_notices', array($this, 'jobsmanager_notice'));
        }

        function jobsmanager_notice()
        {
            if (function_exists('carbon_get_the_post_meta')) {

                global $pagenow;
                $admin_pages = ['index.php', 'edit.php?post_type=jobs', 'plugins.php'];
                if (in_array($pagenow, $admin_pages)) {
?>
                    <div class="notice notice-warning is-dismissible">
                        <p>Carbonfield plugin is required.</p>
                    </div>
<?php
                }
            }
        }
    }
}

new PostMeta();
