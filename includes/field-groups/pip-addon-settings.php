<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group( array(
        'key'                   => 'group_5eda4f800391d',
        'title'                 => 'API',
        'fields'                => array(
            array(
                'key'               => 'field_5eda4f85d6121',
                'label'             => '',
                'name'              => 'gtm',
                'type'              => 'text',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'acfe_permissions'  => '',
                'default_value'     => '',
                'placeholder'       => 'Google Tag Manager ID',
                'prepend'           => '',
                'append'            => '',
                'maxlength'         => '',
                'acfe_form'         => true,
            ),
            array(
                'key'               => 'field_5eda4fadd6122',
                'label'             => '',
                'name'              => 'gmap',
                'type'              => 'text',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'acfe_permissions'  => '',
                'default_value'     => '',
                'placeholder'       => 'Google Map API Key',
                'prepend'           => '',
                'append'            => '',
                'maxlength'         => '',
                'acfe_form'         => true,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'options_page',
                    'operator' => '==',
                    'value'    => 'pip_addon_settings',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'acfe_display_title'    => '',
        'acfe_autosync'         => array(
            0 => 'json',
        ),
        'acfe_permissions'      => '',
        'acfe_form'             => 1,
        'acfe_meta'             => '',
        'acfe_note'             => '',
        'acfe_categories'       => array(
            'pilopress' => 'Pilo\'Press',
        ),
    ) );

}
