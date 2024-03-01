<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;

Container::make('theme_options', __('Settings'))
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
/*-----------------------------------------------------------------------------------*/
/* Career Settings
/*-----------------------------------------------------------------------------------*/
Container::make('theme_options', __('Settings'))
    ->set_page_parent('jobsmanager')
    ->add_tab('General Settings', array(
        Field::make('text', 'jobs_alt_title', __('Alt Title')),
        Field::make('textarea', 'jobs_description', __('Description')),
    ))
    ->add_tab('Contact Form', array(
        Field::make('text', 'jobs_contact_form', __('Jobs Contact Form Shortcode')),
    ));
