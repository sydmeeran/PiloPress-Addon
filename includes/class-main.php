<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PIP_Addon_Main' ) ) {

    class PIP_Addon_Main {

        public function __construct() {
            // WP hooks
            add_action( 'init', array( $this, 'theme_supports' ) );
            add_action( 'admin_init', array( $this, 'customize_admin' ) );
            add_action( 'login_enqueue_scripts', array( $this, 'login_logo_style' ) );
            add_action( 'wp_head', array( $this, 'enqueue_gtm' ) );
            add_action( 'after_body_open_tag', array( $this, 'enqueue_gtm_noscript' ) );
            add_filter( 'login_headerurl', array( $this, 'login_header_url' ) );
            add_filter( 'login_headertitle', array( $this, 'login_header_title' ) );

            // ACF hooks
            add_filter( 'acf/load_field/name=bg_color', array( $this, 'pip_load_color_to_config' ) );
        }

        /**
         * Add theme supports
         */
        public function theme_supports() {
            add_theme_support( 'custom-logo' );
            add_theme_support( 'post-thumbnails' );
            add_post_type_support( 'post', 'excerpt' );
        }

        /**
         * Change login logo
         */
        public function login_logo_style() {
            $logo_id = get_theme_mod( 'custom_logo' );
            $logo    = wp_get_attachment_image_src( $logo_id, 'full' );

            if ( $logo ):
                ?>
                <style type="text/css">
                    #login h1 a, .login h1 a {
                        background-image: url('<?php echo reset($logo); ?>');
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
                    $field['choices'][ $color['classes'] ] = $color['name'];
                }
            }

            return $field;
        }

        /**
         * Enqueue Gtag script in head
         */
        public function enqueue_gtm() {
            $gtm = get_field('gtm', 'pip_addon_options');
            if (isset($gtm) && !empty($gtm)):
                ?>
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','<?php echo $gtm; ?>');</script>
                <!-- End Google Tag Manager -->
                <?php
            endif;
        }

        /**
         * Enqueue Gtag no-script after body open tag
         */
        public function enqueue_gtm_noscript() {
            $gtm = get_field('gtm', 'pip_addon_options');
            if (isset($gtm) && !empty($gtm)):
                ?>
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm; ?>"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
                <?php
            endif;
        }
    }

    // Instantiate
    new PIP_Addon_Main();
}