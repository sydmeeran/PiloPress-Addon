<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PIP_PI_Addon_Main' ) ) {

    class PIP_PI_Addon_Main {

        public function __construct() {
            add_filter( 'acf/load_field/name=bg_color', array( $this, 'pip_load_color_to_config' ) );
        }

        /**
         * Add bg-color to configuration layout
         *
         * @param $field
         *
         * @return mixed
         */
        public function pip_load_color_to_config( $field ) {
            $field['choices'] = array();
            $new_colors       = array();
            $colors           = PIP_TinyMCE::get_custom_colors();

            if ( $colors ) {
                foreach ( $colors as $color ) {
                    $new_class    = str_replace( 'text-', '', $color['classes'] );
                    $new_colors[] = array(
                        'name'    => $color['name'],
                        'font'    => $color['name'],
                        'classes' => 'bg-' . $new_class,
                    );
                }
            }

            if ( is_array( $new_colors ) ) {
                foreach ( $new_colors as $color ) {
                    $value                      = $color['classes'];
                    $label                      = $color['name'];
                    $field['choices'][ $value ] = $label;
                }
            }

            return $field;
        }

    }

    // Instantiate
    new PIP_PI_Addon_Main();
}