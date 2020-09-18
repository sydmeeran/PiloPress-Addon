<?php

if ( function_exists( 'acf_add_local_field_group' ) ) :
    acf_add_local_field_group(
        array(
            'key'                   => 'group_5c7029387315d',
            'title'                 => 'Menu item: Icons',
            'fields'                => array(
                array(
                    'key'               => 'field_5c73ac8d14a8e',
                    'label'             => 'Ajouter un icône au texte ?',
                    'name'              => 'menu_icon_switch',
                    'type'              => 'true_false',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '15',
                        'class' => '',
                        'id'    => '',
                    ),
                    'hide_admin'        => 0,
                    'user_roles'        => array(
                        0 => 'all',
                    ),
                    'message'           => '',
                    'default_value'     => 0,
                    'ui'                => 1,
                    'ui_on_text'        => '',
                    'ui_off_text'       => '',
                ),
                array(
                    'key'               => 'field_5c702956e29c2',
                    'label'             => 'Icône (Font Awesome)',
                    'name'              => 'menu_icon',
                    'type'              => 'font-awesome',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_5c73ac8d14a8e',
                                'operator' => '==',
                                'value'    => '1',
                            ),
                        ),
                    ),
                    'wrapper'           => array(
                        'width' => '20',
                        'class' => '',
                        'id'    => '',
                    ),
                    'hide_admin'        => 0,
                    'user_roles'        => array(
                        0 => 'all',
                    ),
                    'icon_sets'         => array(
                        0 => 'fas',
                        1 => 'far',
                        2 => 'fal',
                        3 => 'fab',
                    ),
                    'custom_icon_set'   => '',
                    'default_label'     => '',
                    'default_value'     => '',
                    'save_format'       => 'element',
                    'allow_null'        => 0,
                    'show_preview'      => 1,
                    'enqueue_fa'        => 0,
                    'fa_live_preview'   => '',
                    'choices'           => array(),
                ),
                array(
                    'key'               => 'field_5c73ad977fc2c',
                    'label'             => 'Icône - Style',
                    'name'              => 'menu_icon_style',
                    'type'              => 'select',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_5c73ac8d14a8e',
                                'operator' => '==',
                                'value'    => '1',
                            ),
                        ),
                    ),
                    'wrapper'           => array(
                        'width' => '20',
                        'class' => '',
                        'id'    => '',
                    ),
                    'hide_admin'        => 0,
                    'user_roles'        => array(
                        0 => 'all',
                    ),
                    'choices'           => array(
                        'fas' => 'Solid',
                        'far' => 'Regular',
                        'fal' => 'Light',
                        'fab' => 'Brands',
                        'fad' => 'Duotone',
                    ),
                    'default_value'     => 'fas',
                    'allow_null'        => 0,
                    'multiple'          => 0,
                    'ui'                => 0,
                    'return_format'     => 'value',
                    'ajax'              => 0,
                    'placeholder'       => '',
                ),
                array(
                    'key'               => 'field_5c73ac8d14a8x',
                    'label'             => 'Icône - Masquer le texte ?',
                    'name'              => 'menu_icon_hide_text',
                    'type'              => 'true_false',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_5c73ac8d14a8e',
                                'operator' => '==',
                                'value'    => '1',
                            ),
                        ),
                    ),
                    'wrapper'           => array(
                        'width' => '20',
                        'class' => '',
                        'id'    => '',
                    ),
                    'hide_admin'        => 0,
                    'user_roles'        => array(
                        0 => 'all',
                    ),
                    'message'           => '',
                    'default_value'     => 0,
                    'ui'                => 1,
                    'ui_on_text'        => '',
                    'ui_off_text'       => '',
                ),
                array(
                    'key'               => 'field_5c73aacc6b3dd',
                    'label'             => 'Icône - Placement',
                    'name'              => 'menu_icon_placement',
                    'type'              => 'select',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field'    => 'field_5c73ac8d14a8e',
                                'operator' => '==',
                                'value'    => '1',
                            ),
                            array(
                                'field'    => 'field_5c73ac8d14a8x',
                                'operator' => '!=',
                                'value'    => '1',
                            ),
                        ),
                    ),
                    'wrapper'           => array(
                        'width' => '20',
                        'class' => '',
                        'id'    => '',
                    ),
                    'hide_admin'        => 0,
                    'user_roles'        => array(
                        0 => 'all',
                    ),
                    'choices'           => array(
                        'gauche' => 'Gauche du texte',
                        'droite' => 'Droite du texte',
                    ),
                    'default_value'     => 'gauche',
                    'allow_null'        => 0,
                    'multiple'          => 0,
                    'ui'                => 0,
                    'return_format'     => 'value',
                    'ajax'              => 0,
                    'placeholder'       => '',
                ),
            ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'nav_menu_item',
                        'operator' => '==',
                        'value'    => 'all',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'acf_after_title',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'modified'              => 1554718949,
        )
    );
endif;
