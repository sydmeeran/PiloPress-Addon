<?php

defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'PIP_Addon_Admin' ) ) {

    /**
     * Class PIP_Addon_Admin
     */
    class PIP_Addon_Admin {

        /**
         * PIP_Addon_Admin constructor.
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
            add_action( 'admin_print_scripts', array( $this, 'remove_admin_notices' ) );
            add_action( 'admin_init', array( $this, 'customize_admin' ) );
            add_action( 'login_enqueue_scripts', array( $this, 'login_logo_style' ) );
            add_filter( 'login_headerurl', array( $this, 'login_header_url' ) );
            add_filter( 'login_headertitle', array( $this, 'login_header_title' ) );
            add_filter( 'auth_cookie_expiration', array( $this, 'auth_cookie_extend_expiration' ), 10, 3 );
        }

        /**
         * Load admin assets
         */
        public function admin_assets() {
            wp_enqueue_script(
                'pip-addon-layouts',
                PIP_ADDON_URL . 'assets/js/pip-addon-layouts.js',
                array( 'jquery' ),
                1.0,
                true
            );
            wp_enqueue_style(
                'pip-addon-layouts',
                PIP_ADDON_URL . 'assets/css/admin-layouts.css',
                null,
                1.0
            );
        }

        /**
         *  WordPress - Admin
         *  - Hide Admin notices mess
         */
        public function remove_admin_notices() {
            global $wp_filter;
            if ( is_user_admin() ) {
                if ( isset( $wp_filter['user_admin_notices'] ) ) {
                    unset( $wp_filter['user_admin_notices'] );
                }
            } elseif ( isset( $wp_filter['admin_notices'] ) ) {
                unset( $wp_filter['admin_notices'] );
            }

            if ( isset( $wp_filter['all_admin_notices'] ) && apply_filters( 'pip_remove_all_admin_notices', true ) ) {
                unset( $wp_filter['all_admin_notices'] );
            }
        }

        /**
         *  Extend "cabin" logged in duration
         *
         * @param $expiration
         * @param $user_id
         * @param $remember
         *
         * @return float|int
         */
        public function auth_cookie_extend_expiration( $expiration, $user_id, $remember ) {

            // Get current user object
            $current_user = get_user_by( 'ID', $user_id );
            if ( !$current_user ) {
                return $expiration;
            }

            // Check if it's "cabin"
            $current_user_login = $current_user->data->user_login ?? '';
            if ( $current_user_login !== 'cabin' ) {
                return $expiration;
            }

            // Stay logged for a year
            return YEAR_IN_SECONDS;
        }

        /**
         * Change login logo
         */
        public function login_logo_style() {
            $logo_id = get_theme_mod( 'custom_logo' );
            $logo    = wp_get_attachment_image_src( $logo_id, 'full' );

            if ( $logo ) : ?>
                <style type="text/css">
                    #login h1 a, .login h1 a {
                        background-image: url('<?php echo reset( $logo ); ?>');
                        height: 80px;
                        width: 320px;
                        background-repeat: no-repeat;
                        background-size: contain;
                    }
                </style>
            <?php
            endif;
        }

        /**
         * Change login URL
         *
         * @return string|void
         */
        public function login_header_url() {
            return home_url();
        }

        /**
         * Change login title
         *
         * @return string|void
         */
        public function login_header_title() {
            return get_bloginfo( 'name' );
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
            if ( !is_array( $post_types ) || $post_types === array() ) {
                return;
            }

            // Browse post types
            foreach ( $post_types as $post_type ) {
                $filter = sprintf( 'get_user_option_%s', sprintf( 'manage%scolumnshidden', 'edit-' . $post_type ) );
                add_filter( $filter, array( $this, 'column_hidden' ), 10, 3 );
            }
        }

    }

    // Instantiate
    new PIP_Addon_Admin();
}
