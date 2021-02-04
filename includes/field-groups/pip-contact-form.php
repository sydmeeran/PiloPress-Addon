<?php
if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group(
        array(
            'key'                   => 'group_contact_form',
            'title'                 => __( 'Formulaire : Contact', 'pip-addon' ),
            'fields'                => array(
                array(
                    'key'               => 'field_contact_form_name',
                    'label'             => __( 'Nom', 'pip-addon' ),
                    'name'              => 'name',
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
                    'placeholder'       => __( 'Nom', 'pip-addon' ),
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                    'translations'      => 'translate',
                    'acfe_settings'     => array(
                        'name_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'name_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_contact_form_first_name',
                    'label'             => __( 'Prénom', 'pip-addon' ),
                    'name'              => 'first_name',
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
                    'placeholder'       => __( 'Prénom', 'pip-addon' ),
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                    'translations'      => 'translate',
                    'acfe_settings'     => array(
                        'first_name_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'first_name_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_contact_form_',
                    'label'             => __( 'Email', 'pip-addon' ),
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
                    'placeholder'       => __( 'Email', 'pip-addon' ),
                    'prepend'           => '',
                    'append'            => '',
                    'translations'      => 'copy_once',
                    'acfe_settings'     => array(
                        'email_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'email_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'               => 'field_contact_form_phone',
                    'label'             => __( 'Téléphone', 'pip-addon' ),
                    'name'              => 'phone',
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
                    'placeholder'       => __( 'Téléphone', 'pip-addon' ),
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                    'translations'      => 'translate',
                    'acfe_settings'     => array(
                        'phone_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'phone_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'     => '',
                    'acfe_form'         => true,
                ),
                array(
                    'key'                => 'field_contact_form_message',
                    'label'              => __( 'Message', 'pip-addon' ),
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
                    'placeholder'        => __( 'Votre message', 'pip-addon' ),
                    'maxlength'          => '',
                    'rows'               => 3,
                    'new_lines'          => '',
                    'acfe_textarea_code' => 0,
                    'translations'       => 'translate',
                    'acfe_settings'      => array(
                        'message_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'message_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                    ),
                    'acfe_validate'      => '',
                    'acfe_form'          => true,
                ),
                array(
                    'key'               => 'field_contact_form_opt_in',
                    'label'             => __( 'Opt-in', 'pip-addon' ),
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
                        'rgpd' => __( "Les informations recueillies dans ce formulaire sont utilisées par MONSITE pour répondre à votre demande. Pour plus d'informations et pour faire valoir votre droit de rétractation, rendez-vous sur notre page <a href='#'>politique de confidentialité</a>", 'pip-addon' ),
                    ),
                    'allow_custom'      => 0,
                    'default_value'     => array(),
                    'layout'            => 'vertical',
                    'toggle'            => 0,
                    'return_format'     => 'value',
                    'translations'      => 'copy_once',
                    'acfe_settings'     => array(
                        'opt-in_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'opt-in_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
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
                    'key'               => 'field_contact_form_captcha',
                    'label'             => __( 'Captcha', 'pip-addon' ),
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
                        'captcha_settings_1' => array(
                            'acfe_settings_location' => 'front',
                            'acfe_settings_settings' => array(
                                'captcha_settings_1_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_label',
                                    'acfe_settings_setting_operator' => 'true',
                                ),
                            ),
                        ),
                        'captcha_settings_2' => array(
                            'acfe_settings_location' => 'admin',
                            'acfe_settings_settings' => array(
                                'captcha_settings_2_setting_1' => array(
                                    'acfe_settings_setting_type'     => 'hide_field',
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

}
