<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PIP_Addon_Main' ) ) {

    class PIP_Addon_Main {

        public function __construct() {

            // WP hooks
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
            add_action( 'init', array( $this, 'init_hook' ) );
            add_action( 'admin_init', array( $this, 'customize_admin' ) );
            add_action( 'login_enqueue_scripts', array( $this, 'login_logo_style' ) );
            add_action( 'wp_head', array( $this, 'enqueue_gtm' ) );
            add_action( 'after_body_open_tag', array( $this, 'enqueue_gtm_noscript' ) );
            add_filter( 'login_headerurl', array( $this, 'login_header_url' ) );
            add_filter( 'login_headertitle', array( $this, 'login_header_title' ) );
            add_action( 'admin_print_scripts', array( $this, 'remove_admin_notices' ) );
            add_action( 'sanitize_file_name', array( $this, 'sanitize_file_name' ) );
            add_action( 'upload_mimes', array( $this, 'upload_mime_types' ) );
            add_action( 'admin_menu', array( $this, 'remove_useless_menus' ) );
            add_action( 'admin_menu', array( $this, 'move_comments_menu' ) );
            add_action( 'admin_menu', array( $this, 'move_page_menu' ) );
            add_action( 'wp_before_admin_bar_render', array( $this, 'remove_useless_bar_menus' ) );

            // ACF hooks
            add_filter( 'acf/fields/google_map/api', array( $this, 'acf_register_map_api' ) );
            add_filter( 'acf/load_field/name=bg_color', array( $this, 'pip_load_color_to_config' ) );
            add_filter( 'acf/prepare_field_group_for_import', array( $this, 'pip_flexible_args' ) );
            add_filter( 'acf/load_field/name=tailwind_config', array( $this, 'pip_tailwind_config_default' ), 20 );
            add_filter( 'acf/load_field/name=tailwind_style', array( $this, 'pip_tailwind_style_default' ), 20 );
            add_filter( 'option_acffa_settings', array( $this, 'acf_field_fa_pro_activation' ), 20 );

        }

        /**
         *  ACF field "Font Awesome" plugin
         *  - Force Pro mode (to have pro icons in select in the back-office)
         */
        public function acf_field_fa_pro_activation( $acf_fa_params ) {
            $acf_fa_params['acffa_pro_cdn'] = true;
            return $acf_fa_params;
        }

        /**
         * Load admin assets
         */
        public function admin_assets() {
            wp_enqueue_script( 'pip-addon-layouts', PIP_ADDON_URL . 'assets/js/pip-addon-layouts.js', array( 'jquery' ), '', true );
        }

        /**
         * Add theme supports
         */
        public function init_hook() {
            // Theme support
            add_theme_support( 'custom-logo' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'title-tag' );
            add_post_type_support( 'post', 'excerpt' );

            // Remove tags
            unregister_taxonomy_for_object_type( 'post_tag', 'post' );

            // Capability
            $capability = apply_filters( 'pip/options/capability', acf_get_setting( 'capability' ) );
            if ( !current_user_can( $capability ) ) {
                return;
            }

            // Add option page
            acf_add_options_page(
                array(
                    'page_title'  => __( 'Settings', 'pip-addon' ),
                    'menu_title'  => __( 'Settings', 'pip-addon' ),
                    'menu_slug'   => 'pip_addon_settings',
                    'capability'  => $capability,
                    'position'    => '',
                    'parent_slug' => 'pilopress',
                    'icon_url'    => '',
                    'redirect'    => true,
                    'post_id'     => 'pip_addon_settings',
                    'autoload'    => false,
                )
            );

            // Add default menu
            register_nav_menus(
                array(
                    'header-menu' => __( 'Header', 'text_domain' ),
                    'footer-menu' => __( 'Footer', 'text_domain' ),
                )
            );
        }

        /**
         * Change login logo
         */
        public function login_logo_style() {
            $logo_id = get_theme_mod( 'custom_logo' );
            $logo    = wp_get_attachment_image_src( $logo_id, 'full' );

            if ( $logo ) :
                ?>
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
         *  Move post_type "Page" to top + Add separator after "post_types"
         */
        public function move_page_menu() {
            global $menu;

            // Page
            $menu['4.5'] = $menu[20];
            unset( $menu[20] );

            // Separator
            $menu['8.5'] = array(
                '',
                'read',
                'separator8.5',
                '',
                'wp-menu-separator',
            );
        }

        /**
         *  Move comments into post_type post submenu
         */
        public function move_comments_menu() {
            add_submenu_page( 'edit.php', 'Commentaires', 'Commentaires', 'manage_options', 'edit-comments.php' );
            remove_menu_page( 'edit-comments.php' );
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
                $result = array();
            }

            // Add Yoast columns
            $result = array_merge(
                $result,
                array(
                    'wpseo-links',
                    'wpseo-score',
                    'wpseo-score-readability',
                    'wpseo-title',
                    'wpseo-metadesc',
                    'wpseo-focuskw',
                )
            );

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

            // Add default empty value (to avoid saving some color by mistake)
            $field['choices'][] = __( '- Choisir -', 'pilot-in' );

            if ( is_array( $new_colors ) ) {
                foreach ( $new_colors as $color ) {
                    $field['choices'][ $color['classes'] ] = $color['name'];
                }
            }

            return $field;
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

            if ( isset( $wp_filter['all_admin_notices'] ) ) {
                unset( $wp_filter['all_admin_notices'] );
            }
        }

        /**
         * Enqueue GTM script in head
         */
        public function enqueue_gtm() {
            $gtm = get_field( 'gtm', 'pip_addon_settings' );
            if ( $gtm ) :
                ?>
                <script>(
                        function ( w, d, s, l, i ) {
                            w[l] = w[l] || []
                            w[l].push( { 'gtm.start': new Date().getTime(), event: 'gtm.js' } )
                            var f                            = d.getElementsByTagName( s )[0],
                                j = d.createElement( s ), dl = l != 'dataLayer' ? '&l=' + l : ''
                            j.async                          = true
                            j.src                            =
                                'https://www.googletagmanager.com/gtm.js?id=' + i + dl
                            f.parentNode.insertBefore( j, f )
                        }
                    )( window, document, 'script', 'dataLayer', '<?php echo $gtm; ?>' )
                </script>
                <?php
            endif;
        }

        /**
         * Enqueue GTM no-script after body open tag
         */
        public function enqueue_gtm_noscript() {
            $gtm = get_field( 'gtm', 'pip_addon_settings' );
            if ( $gtm ) :
                ?>
                <noscript>
                    <iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm; ?>"
                            height="0" width="0" style="display:none;visibility:hidden"></iframe>
                </noscript>
                <?php
            endif;
        }

        /**
         * Register Gmap Api Key for ACF Pro
         */
        public function acf_register_map_api( $api ) {
            $api['key'] = get_field( 'gmap', 'pip_addon_settings' );

            return $api;
        }

        /**
         * Image upload sanitize
         *
         * @param $input
         *
         * @return string
         */
        public function sanitize_file_name( $input ) {
            $path      = pathinfo( $input );
            $extension = ( isset( $path['extension'] ) && !empty( $path['extension'] ) ) ? $path['extension'] : '';
            $file      = ( !empty( $extension ) ) ? preg_replace( '/.' . $extension . '$/', '', $input ) : $input;

            return sanitize_title( str_replace( '_', '-', $file ) ) . ( ( !empty( $extension ) ) ? '.' . $extension : '' );
        }

        /**
         * Allow more file types upload
         *
         * @param $mimes
         *
         * @return mixed
         */
        public function upload_mime_types( $mimes ) {
            $mimes['svg']   = 'image/svg+xml';
            $mimes['woff']  = 'application/font-woff';
            $mimes['woff2'] = 'application/font-woff2';

            return $mimes;
        }

        /**
         * Remove some menus
         */
        public function remove_useless_menus() {
            remove_menu_page( 'edit-comments.php' );
        }

        /**
         * Remove some menus
         */
        public function remove_useless_bar_menus() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu( 'comments' );
        }

        /**
         *  Edit PIP Flexible args
         */
        public function pip_flexible_args( $field_group ) {

            $field_group_key = acf_maybe_get( $field_group, 'key' );
            if ( mb_stripos( $field_group_key, PIP_Flexible::get_flexible_field_name() ) === false ) {
                return $field_group;
            }

            $fields = acf_maybe_get( $field_group, 'fields' );
            if ( empty( $fields ) ) {
                return $field_group;
            }

            $flexible_args       = reset( $fields );
            $acfe_flexible_modal = acf_maybe_get( $flexible_args, 'acfe_flexible_modal' );
            if ( !$acfe_flexible_modal ) {
                return $field_group;
            }

            // Set 4 layouts per row in layouts modal
            $field_group['fields'][0]['acfe_flexible_modal']['acfe_flexible_modal_col'] = 4;

            return $field_group;

        }

        /**
         *  Change tailwind config default value
         */
        public function pip_tailwind_config_default( $field ) {

            ob_start(); ?>
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    'theme': {
        'colors': {
            'primary-500': '#575756',
            'primary': '#575756',
            'secondary-500': '#E2101B',
            'secondary': '#E2101B',
            'black': '#2E2B28',
            'white': '#FFFFFF',
            'grey': defaultTheme.colors.grey,
        },
        'fontFamily': {
            'primary': ['NomDeLaFont', ...defaultTheme.fontFamily.sans],
            'secondary': ['NomDeLaFont', ...defaultTheme.fontFamily.serif],
        },
        'extend': {
            'colors': {
                'grey': '#D2D2D2',
            },
            'spacing': {
                '75': '18.75rem',
                '84': '21rem',
                '88': '22rem',
                '96': '24rem',
                '100': '25rem',
                '112': '28rem',
                '120': '30rem',
                '124': '31rem',
                '136': '34rem',
                '138': '34.5rem',
                '140': '35rem',
                '150': '37.5rem',
                '152': '38rem',
                '162': '40.5rem',
                '176': '44rem',
                '186': '46.5rem',
                '192': '48rem',
                '200': '50rem',
            },
        }
    },
    'variants': {

    },
    'plugins': [

    ],
};
            <?php
            $field['default_value'] = ob_get_clean();
            return $field;

        }

        /**
         *  Change tailwind style default value
         */
        public function pip_tailwind_style_default( $field ) {

            ob_start(); ?>
@tailwind base;
@tailwind components;

h1,
.h1 {
    @apply font-primary leading-tight uppercase font-semibold text-black text-4xl;
}

h2,
.h2 {
    @apply font-primary leading-tight uppercase font-semibold text-black text-3xl;
}

h3,
.h3 {
    @apply font-primary leading-tight uppercase font-semibold text-black text-2xl;
}

h4,
.h4 {
    @apply font-primary leading-tight font-semibold text-black text-xl;
}

h5,
.h5 {
    @apply font-primary leading-tight font-semibold text-black text-lg;
}

h6,
.h6 {
    @apply font-primary leading-tight font-semibold text-black text-base;
}

@tailwind utilities;
            <?php
            $field['default_value'] = ob_get_clean();
            return $field;

        }

    }

    // Instantiate
    new PIP_Addon_Main();
}
