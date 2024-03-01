<?php
if (!class_exists('PostMeta')) {
    class PostMeta
    {
        use Carbon_Fields\Container;
        use Carbon_Fields\Complex_Container;
        use Carbon_Fields\Field;

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



            Container::make('theme_options', __('Theme Option'))
                ->add_fields(
                    array(
                        Field::make('complex', 'our_schools', 'Our Schools')
                            ->add_fields(
                                array(
                                    Field::make('text', 'school', __('School')),

                                )
                            )
                            ->set_layout('tabbed-vertical')
                            ->set_header_template('<%- school  %>'),


                    )
                );
        }
    }
}

new PostMeta();
