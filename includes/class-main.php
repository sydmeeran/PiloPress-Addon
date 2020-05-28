<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PIP_PI_Addon_Main' ) ) {

    class PIP_PI_Addon_Main {

        public function __construct() {
            // WP hooks
            add_action( 'admin_init', array( $this, 'customize_admin' ) );

            // ACF hooks
            add_filter( 'acf/load_field/name=bg_color', array( $this, 'pip_load_color_to_config' ) );
        }

        /**
         * Customize admin
         */
        public function customize_admin() {
            // Yoast not activated
            if ( !class_exists( 'WPSEO_Post_Type' ) ) {
                return;
            }

            // Get all post types
            $post_types = WPSEO_Post_Type::get_accessible_post_types();

            // If no post types, return
            if ( !is_array( $post_types ) || $post_types === [] ) {
                return;
            }

            // Browse post types
            foreach ( $post_types as $post_type ) {
                $filter = sprintf( 'get_user_option_%s', sprintf( 'manage%scolumnshidden', 'edit-' . $post_type ) );
                add_filter( $filter, [ $this, 'column_hidden' ], 10, 3 );
            }
        }

        /**
         * Hide Yoast columns
         *
         * @param $result
         * @param $option
         * @param $user
         *
         * @return array
         */
        public function column_hidden( $result, $option, $user ) {
            global $wpdb;

            // Return if user choose which column to display
            if ( $user->has_prop( $wpdb->get_blog_prefix() . $option ) || $user->has_prop( $option ) ) {
                return $result;
            }

            // If not array, set it to array
            if ( !is_array( $result ) ) {
                $result = [];
            }

            // Add Yoast columns
            $result = array_merge( $result, array(
                'wpseo-links',
                'wpseo-score',
                'wpseo-score-readability',
                'wpseo-title',
                'wpseo-metadesc',
                'wpseo-focuskw',
            ) );

            // Remove duplicated values
            $result = array_unique( $result );

            return $result;
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