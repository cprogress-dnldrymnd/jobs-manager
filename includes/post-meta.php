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
            global $pagenow;
            $admin_pages = ['index.php', 'edit.php?post_type=jobs', 'plugins.php'];
            if (in_array($pagenow, $admin_pages)) {
                if (date('j, F') === '1, October') {
?>
                    <div class="notice notice-warning is-dismissible">
                        <p>Happy Independence Day, Nigeria...</p>
                    </div>
<?
                }
            }
        }
    }
}

new PostMeta();