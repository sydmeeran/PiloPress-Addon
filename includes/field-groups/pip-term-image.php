<?php
if ( function_exists( 'acf_add_local_field_group' ) ) :
    acf_add_local_field_group(
        array(
            'key'                   => 'group_5f7ecc1c103d3',
            'title'                 => 'Terme',
            'fields'                => array(
                array(
                    'key'               => 'field_5f7eccb76647b',
                    'label'             => 'Image',
                    'name'              => 'term_image',
                    'type'              => 'image',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => '',
                        'id'    => '',
                    ),
                    'acfe_permissions'  => '',
                    'acfe_uploader'     => 'wp',
                    'acfe_thumbnail'    => 0,
                    'return_format'     => 'array',
                    'preview_size'      => 'medium',
                    'library'           => 'all',
                    'min_width'         => '',
                    'min_height'        => '',
                    'min_size'          => '',
                    'max_width'         => '',
                    'max_height'        => '',
                    'max_size'          => '',
                    'mime_types'        => '',
                    'translations'      => 'copy_once',
                ),
            ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'taxonomy',
                        'operator' => '==',
                        'value'    => 'all',
                    ),
                    array(
                        'param'    => 'taxonomy',
                        'operator' => '!=',
                        'value'    => 'product_cat',
                    ),
                    array(
                        'param'    => 'taxonomy',
                        'operator' => '!=',
                        'value'    => 'product_shipping_class',
                    ),
                    array(
                        'param'    => 'taxonomy',
                        'operator' => '!=',
                        'value'    => 'product_visibility',
                    ),
                    array(
                        'param'    => 'taxonomy',
                        'operator' => '!=',
                        'value'    => 'product_type',
                    ),
                    array(
                        'param'    => 'taxonomy',
                        'operator' => '!=',
                        'value'    => 'post_format',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'acf_after_title',
            'style'                 => 'seamless',
            'label_placement'       => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'acfe_display_title'    => '',
            'acfe_autosync'         => array(
                0 => 'php',
                1 => 'json',
            ),
            'acfe_permissions'      => '',
            'acfe_form'             => 0,
            'acfe_meta'             => array(
                'acfcloneindex' => array(
                    'acfe_meta_key'   => '',
                    'acfe_meta_value' => '',
                ),
            ),
            'acfe_note'             => '',
        )
    );

endif;
