<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;

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
