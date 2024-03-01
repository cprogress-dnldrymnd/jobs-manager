<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;

/*-----------------------------------------------------------------------------------*/
/* Career Settings
/*-----------------------------------------------------------------------------------*/

Container::make('theme_options', __('Settings'))
    ->set_page_parent('jobsmanager')
    ->add_tab('General Settings', array(
        Field::make('checkbox', 'jobs_single', __('Enable Single Page')),
        Field::make('text', 'jobs_alt_title', __('Alt Title')),
        Field::make('textarea', 'jobs_description', __('Description')),
    ))
    ->add_tab('Contact Form', array(
        Field::make('text', 'jobs_contact_form', __('Jobs Contact Form Shortcode')),
    ));
