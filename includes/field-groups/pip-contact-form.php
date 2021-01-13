<?php
if ( function_exists( 'acf_add_local_field_group' ) ) :

    acf_add_local_field_group(
        array(
            'key'                   => 'group_5f685beee7074',
            'title'                 => 'Formulaire : Contact',
            'fields'                => array(
                array(
                    'key'               => 'field_5f685cbd38f19',
                    'label'             => 'Nom',
                    'name'              => 'nom',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => 'mt-0',
                        'id'    => '',
                    ),
                    'acfe_save_meta'    => 0,
                    'acfe_permissions'  => '',
                    'default_value'     => '',
                    'placeholder'       => 'Nom',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                    'translations'      => 'translate',
                    'acfe_settings'     => array(
                        '5f6863a99055a' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863ad9055b' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_5f685cc138f1a',
                    'label'             => 'Prénom',
                    'name'              => 'prenom',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => 'mt-0',
                        'id'    => '',
                    ),
                    'acfe_save_meta'    => 0,
                    'acfe_permissions'  => '',
                    'default_value'     => '',
                    'placeholder'       => 'Prénom',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                    'translations'      => 'translate',
                    'acfe_settings'     => array(
                        '5f6863b49055c' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863b79055d' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_5f685cc838f1b',
                    'label'             => 'Email',
                    'name'              => 'email',
                    'type'              => 'email',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => 'mt-0',
                        'id'    => '',
                    ),
                    'acfe_save_meta'    => 0,
                    'acfe_permissions'  => '',
                    'default_value'     => '',
                    'placeholder'       => 'Email',
                    'prepend'           => '',
                    'append'            => '',
                    'translations'      => 'copy_once',
                    'acfe_settings'     => array(
                        '5f6863bd9055e' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863bd9055f' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_5f685ce038f1c',
                    'label'             => 'Téléphone',
                    'name'              => 'telephone',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => 'mt-0',
                        'id'    => '',
                    ),
                    'acfe_save_meta'    => 0,
                    'acfe_permissions'  => '',
                    'default_value'     => '',
                    'placeholder'       => 'Téléphone',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                    'translations'      => 'translate',
                    'acfe_settings'     => array(
                        '5f6863c890560' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863c990561' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'                => 'field_5f685d0438f1d',
                    'label'              => 'Message',
                    'name'               => 'message',
                    'type'               => 'textarea',
                    'instructions'       => '',
                    'required'           => 1,
                    'conditional_logic'  => 0,
                    'wrapper'            => array(
                        'width' => '',
                        'class' => 'mt-0',
                        'id'    => '',
                    ),
                    'acfe_save_meta'     => 0,
                    'acfe_permissions'   => '',
                    'default_value'      => '',
                    'placeholder'        => 'Votre message',
                    'maxlength'          => '',
                    'rows'               => 3,
                    'new_lines'          => '',
                    'acfe_textarea_code' => 0,
                    'translations'       => 'translate',
                    'acfe_settings'      => array(
                        '5f6863d390562' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863d590563' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'      => '',
                    'acfe_form'          => true,
                ),
                array(
                    'key'               => 'field_5f685d4238f1e',
                    'label'             => 'Opt-in',
                    'name'              => 'opt-in',
                    'type'              => 'checkbox',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => 'mt-0',
                        'id'    => '',
                    ),
                    'acfe_save_meta'    => 0,
                    'acfe_permissions'  => '',
                    'choices'           => array(
                        'Les informations recueillies dans ce formulaire sont utilisées pour répondre à votre demande. Pour plus d’informations et pour faire valoir votre droit de rétractation, rendez-vous sur notre page politique de confidentialité' => 'Les informations recueillies dans ce formulaire sont utilisées par MONSITE pour répondre à votre demande. Pour plus d’informations et pour faire valoir votre droit de rétractation, rendez-vous sur notre page politique de confidentialité',
                    ),
                    'allow_custom'      => 0,
                    'default_value'     => array(),
                    'layout'            => 'vertical',
                    'toggle'            => 0,
                    'return_format'     => 'value',
                    'translations'      => 'copy_once',
                    'acfe_settings'     => array(
                        '5f6863dd90564' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863df90565' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'save_custom'       => 0,
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_5f685d7838f1f',
                    'label'             => 'Captcha',
                    'name'              => 'captcha',
                    'type'              => 'acfe_recaptcha',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => 'mt-0 flex justify-center',
                        'id'    => '',
                    ),
                    'acfe_save_meta'    => 0,
                    'acfe_permissions'  => '',
                    'version'           => 'v2',
                    'v2_theme'          => 'light',
                    'v2_size'           => 'normal',
                    'site_key'          => '',
                    'secret_key'        => '',
                    'translations'      => 'copy_once',
                    'acfe_settings'     => array(
                        '5f6863ec90566' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                '5f6863ef90567' => array(
                                    'acfe_settings_setting_type' => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                        '5fd0fc7876f64' => array(
                            'acfe_settings_location' => 'admin',
                            'acfe_settings_settings' => array(
                                '5fd0fc7b76f65' => array(
                                    'acfe_settings_setting_type' => 'hide_field',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'disabled'          => 0,
                    'readonly'          => 0,
                    'v3_hide_logo'      => false,
                    'acfe_form'         => true,
                ),
            ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'soumission',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => false,
            'description'           => '',
            'acfe_display_title'    => '',
            'acfe_autosync'         => array(
                0 => 'json',
            ),
            'acfe_permissions'      => '',
            'acfe_form'             => 1,
            'acfe_meta'             => '',
            'acfe_note'             => '',
        )
    );

endif;
