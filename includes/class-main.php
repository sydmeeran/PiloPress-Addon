<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'PIP_Addon_Main' ) ) {

    class PIP_Addon_Main {

        public function __construct() {

            // WP hooks
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'front_assets' ) );
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
            add_action( 'wp_footer', array( $this, 'enqueue_font_awesome_pro' ) );
            add_filter( 'template_include', array( $this, 'search_template' ), 20 );
            add_filter( 'template_include', array( $this, 'taxonomy_template' ), 20 );
            add_filter( 'auth_cookie_expiration', array( $this, 'auth_cookie_extend_expiration' ), 10, 3 );
            add_filter( 'acf/get_field_group_style', array( $this, 'pip_display_wysiwyg_on_product' ), 20, 2 );
            add_filter( 'nav_menu_css_class', array( $this, 'menu_item_parent_css_class' ), 10, 4 );
            add_filter( 'nav_menu_submenu_css_class', array( $this, 'menu_item_submenu_css_class' ), 10, 4 );
            add_filter( 'wp_nav_menu_objects', array( $this, 'menu_items_fa_icons' ), 9, 2 );

            // WC hooks
            add_filter( 'woocommerce_locate_template', array( $this, 'wc_template_path' ), 99, 3 );

            // ACF hooks
            add_filter( 'acf/fields/google_map/api', array( $this, 'acf_register_map_api' ) );
            add_filter( 'acf/load_field/name=bg_color', array( $this, 'pip_load_color_to_config' ) );
            add_filter( 'acf/render_field_settings/type=pip_font_color', array( $this, 'pip_font_color_settings' ), 20, 1 );
            add_filter( 'acf/format_value/type=pip_font_color', array( $this, 'pip_font_color_format_value' ), 20, 3 );
            add_filter( 'acf/prepare_field_group_for_import', array( $this, 'pip_flexible_args' ) );
            add_filter( 'acf/load_field_groups', array( $this, 'pip_flexible_layouts_locations' ), 30 );
            add_filter( 'acf/load_field/name=tailwind_config', array( $this, 'pip_tailwind_config_default' ), 20 );
            add_filter( 'acf/load_field/name=tailwind_style', array( $this, 'pip_tailwind_style_default' ), 20 );
            add_filter( 'option_acffa_settings', array( $this, 'acf_field_fa_pro_activation' ), 20 );

            // ACFE hooks
            acfe_update_setting( 'modules/single_meta', true );

            // PIP hooks
            add_filter( 'pip/builder/locations', array( $this, 'pip_flexible_locations' ) );

        }

        /**
         *  Menu item - Add "Font Awesome" icon to "text"
         */
        public function menu_items_fa_icons( $items, $args ) {

            if ( !$items ) {
                return $items;
            }

            foreach ( $items as &$item ) {

                $show_menu_icon = get_field( 'menu_icon_switch', $item );
                if ( !$show_menu_icon ) {
                    continue;
                }

                $menu_icon           = get_field( 'menu_icon', $item );
                $menu_icon_style     = get_field( 'menu_icon_style', $item );
                $menu_icon_position  = get_field( 'menu_icon_placement', $item );
                $menu_icon_hide_text = get_field( 'menu_icon_hide_text', $item );
                $old_item_title      = pip_maybe_get( $item, 'title' );

                /** Font Awesome style */
                if ( $menu_icon_style ) {
                    $menu_icon = str_replace( 'fas', $menu_icon_style, $menu_icon );
                }

                /** Hide text */
                if ( $menu_icon_hide_text ) {

                    $item->title = $menu_icon;

                } else {

                    /** Menu icon position */
                    if ( $menu_icon_position === 'gauche' ) {

                        $menu_icon   = str_replace( 'class="', 'class="mr-1 ', $menu_icon );
                        $item->title = $menu_icon . $old_item_title;

                    } elseif ( $menu_icon_position === 'droite' ) {

                        $menu_icon   = str_replace( 'class="', 'class="ml-1 ', $menu_icon );
                        $item->title = $old_item_title . $menu_icon;

                    }
                }
            }

            return $items;
        }

        /**
         *  Menu - Submenu
         *  - Add "tailwind" classes on parent menu items
         */
        public function menu_item_parent_css_class( $classes, $item, $args, $depth ) {

            /** Skip non-parent menu items */
            if ( !array_search( 'menu-item-has-children', $classes, true ) ) {
                return $classes;
            }

            $new_classes = 'relative group';
            $new_classes = explode( ' ', $new_classes );
            $classes     = array_merge( $classes, $new_classes );

            return $classes;
        }

        /**
         *  Menu - Submenu
         *  - Add "tailwind" classes on parent menu items
         */
        public function menu_item_submenu_css_class( $classes, $args, $depth ) {

            $new_classes = 'absolute hidden group-hover:block top-full right-0 p-4 shadow bg-white';
            $new_classes = explode( ' ', $new_classes );
            $classes     = array_merge( $classes, $new_classes );

            return $classes;
        }

        /**
         *  Load WooCommerce templates from PiloPress WooCommerce folder
         */
        public function wc_template_folder_path( $template, $template_name, $template_path ) {

            $default_template = $template;

            // Look within passed path within the plugin - this is priority.
            $template = trailingslashit( $template_path ) . $template_name;

            // Get default template
            if ( !file_exists( $template ) || WC_TEMPLATE_DEBUG_MODE ) {
                return $default_template;
            }

            return $template;
        }

        /**
         *  Load WooCommerce templates from PiloPress WooCommerce folder
         */
        public function wc_template_path( $template, $template_name, $template_path ) {

            // 1. If WooCommerce template in theme (default)
            $theme_folder_path = get_stylesheet_directory() . '/woocommerce';
            $theme_template    = trailingslashit( $theme_folder_path ) . $template_name;
            if ( file_exists( $theme_template ) ) {
                return $theme_template;
            }

            // 2. If WooCommerce template in addon
            $addon_folder_path = trailingslashit( PIP_ADDON_PATH ) . 'templates/woocommerce/';
            $addon_template    = trailingslashit( $addon_folder_path ) . $template_name;
            if ( file_exists( $addon_template ) ) {
                return $addon_template;
            }

            // 3. Default template folder
            return $template;
        }

        /**
         *  Add more locations to the main flexible (archives...)
         *
         * @param $locations
         *
         * @return mixed
         */
        public function pip_flexible_locations( $locations ) {

            // Post type archive (ACFE)
            // TODO: Uncomment after ACFE fix
//            $locations[] = array(
//                array(
//                    'param'    => 'post_type_archive',
//                    'operator' => '==',
//                    'value'    => 'all',
//                ),
//            );

            // Menu items
            $locations[] = array(
                array(
                    'param'    => 'nav_menu_item',
                    'operator' => '==',
                    'value'    => 'all',
                ),
            );

            // Taxonomies
            $locations[] = array(
                array(
                    'param'    => 'taxonomy',
                    'operator' => '==',
                    'value'    => 'all',
                ),
            );

            return $locations;
        }

        /**
         *  Merge "Layouts" location with "Main flexible" location
         *  (so we doesn't have to set manually same location everytime on layouts)
         *
         * @param $field_groups
         *
         * @return mixed
         */
        public function pip_flexible_layouts_locations( $field_groups ) {

            foreach ( $field_groups as &$field_group ) {

                // Exclude non-layouts field groups
                if ( acf_maybe_get( $field_group, '_pip_is_layout' ) !== 1 ) {
                    continue;
                }

                // Exclude layout model
                $fg_title = acf_maybe_get( $field_group, 'title' );
                if ( $fg_title === '_layout_model' ) {
                    continue;
                }

                // Add default locations (like pip-pattern...)
                $flexible_locations   = apply_filters( 'pip/builder/locations', array() );
                $flexible_locations[] = array(
                    array(
                        'param'    => 'pip-pattern',
                        'operator' => '==',
                        'value'    => 'all',
                    ),
                );

                $flexible_locations_flat = !empty( $flexible_locations ) ? array_flatten_recursive( $flexible_locations ) : array();

                $layout_locations = acf_maybe_get( $field_group, 'location' );
                foreach ( $layout_locations as $layout_location ) {

                    $layout_param = wp_list_pluck( $layout_location, 'param' );
                    $layout_param = reset( $layout_param );

                    // Add only new location
                    if ( !in_array( $layout_param, $flexible_locations_flat ) ) {
                        $flexible_locations[] = $layout_location;
                    }
                }

                $field_group['location'] = $flexible_locations;
            }

            return $field_groups;
        }

        /**
         *  Allow display of native WYSIWYG in product edition (needed for native WooCommerce display)
         */
        public function pip_display_wysiwyg_on_product( $style, $field_group ) {

            $current_screen   = get_current_screen();
            $screen_base      = pip_maybe_get( $current_screen, 'base' );
            $screen_post_type = pip_maybe_get( $current_screen, 'post_type' );

            if (
                !$current_screen ||
                $screen_base !== 'post' ||
                $screen_post_type !== 'product'
            ) {
                return $style;
            }

            return '';
        }

        /**
         *  Extend "cabin" logged in duration
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
         *  Assets to load on front-end
         */
        public function front_assets() {

            // Variables to pass to front-end JavaScript context
            $pip_js_object = array(
                'ajax'    => admin_url( 'admin-ajax.php' ),
                'theme'   => PIP_THEME_URL,
                'layouts' => PIP_THEME_URL . '/pilopress/layouts',
            );
            wp_localize_script( 'jquery', 'pipAddon', $pip_js_object );

        }

        /**
         *  Enqueue Font Awesome Pro CSS
         */
        public function enqueue_font_awesome_pro() {
            if ( is_admin() ) {
                return;
            }

            $fa_url = apply_filters( 'ACFFA_get_fa_url', '//pro.fontawesome.com/releases/v5.14.0/css/all.css' );
            wp_enqueue_style( 'fa-pro', $fa_url, array(), null );
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
            wp_enqueue_style( 'pip-addon-layouts', PIP_ADDON_URL . 'assets/css/admin-layouts.css' );
        }

        /**
         * Add theme supports
         */
        public function init_hook() {

            // Theme support
            add_theme_support( 'custom-logo' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'title-tag' );
            add_theme_support( 'menus' );

            // 3rd party theme support
            add_theme_support( 'woocommerce' );

            // Edit post
            add_post_type_support( 'post', 'excerpt' );
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
            if ( function_exists( 'pip_get_colors' ) ) {
                $colors = pip_get_colors();
            } else {
                $colors = PIP_TinyMCE::get_custom_colors();
            }

            if ( $colors ) {
                foreach ( $colors as $color ) {
                    $classes      = acf_maybe_get( $color, 'classes' );
                    $classes      = $classes ? str_replace( 'text-', '', $classes ) : acf_maybe_get( $color, 'class_name' );
                    $new_colors[] = array(
                        'name'    => $color['name'],
                        'font'    => $color['name'],
                        'classes' => 'bg-' . $classes,
                    );
                }
            }

            // Add default empty value (to avoid saving some color by mistake)
            $field['choices'][] = '- Choisir -';

            if ( is_array( $new_colors ) ) {
                foreach ( $new_colors as $color ) {
                    $field['choices'][ $color['classes'] ] = $color['name'];
                }
            }

            return $field;
        }

        /**
         * Add a render field setting to change class output in value
         *
         * @param $field
         */
        public function pip_font_color_settings( $field ) {

            // Select: Class output
            acf_render_field_setting(
                $field,
                array(
                    'label'             => __( 'Return Value', 'acf' ),
                    'instructions'      => __( 'Classe retournée dans le champ', 'pip-addon' ),
                    'name'              => 'class_output',
                    'type'              => 'select',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '',
                        'class' => '',
                        'id'    => '',
                    ),
                    'acfe_permissions'  => '',
                    'choices'           => array(
                        'text'       => __( 'Classe de texte', 'pip-addon' ),
                        'background' => __( 'Classe de fond', 'pip-addon' ),
                        'border'     => __( 'Classe de bordure', 'pip-addon' ),
                    ),
                    'default_value'     => 'text',
                    'allow_null'        => 1,
                    'multiple'          => 0,
                    'ui'                => 1,
                    'return_format'     => 'value',
                    'acfe_settings'     => '',
                    'acfe_validate'     => '',
                    'ajax'              => 0,
                    'placeholder'       => '',
                )
            );

        }

        /**
         * Change class output in format value
         *
         * @param $value
         * @param $post_id
         * @param $field
         *
         * @return string|string[]
         */
        public function pip_font_color_format_value( $value, $post_id, $field ) {

            $class_output = acf_maybe_get( $field, 'class_output' );
            if ( !$class_output ) {
                return $value;
            }

            if ( version_compare( PiloPress::$version, '0.4.0', '<' ) ) {

                switch ( $class_output ) {
                    case 'background':
                        if ( mb_stripos( $value, 'text-' ) === 0 ) {
                            $value = str_replace( 'text-', 'bg-', $value );
                        } else {
                            $value = 'bg-' . $value;
                        }
                        break;

                    case 'border':
                        if ( mb_stripos( $value, 'text-' ) === 0 ) {
                            $value = str_replace( 'text-', 'border-', $value );
                        } else {
                            $value = 'border-' . $value;
                        }
                        break;

                    case 'text':
                    default:
                        // Don't change value
                        break;
                }
            } else {

                switch ( $class_output ) {
                    case 'text':
                        $value = 'text-' . $value;
                        break;
                    case 'background':
                        $value = 'bg-' . $value;
                        break;
                    case 'border':
                        $value = 'border-' . $value;
                        break;
                }
            }

            return $value;
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
                        function (w, d, s, l, i) {
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
         *
         * @param $api
         *
         * @return mixed
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
         *  Template: Use "search.php" template inside the PiloPress-Addon
         */
        public function search_template( $template ) {

            if ( !is_search() ) {
                return $template;
            }

            // In plugin
            $template = PIP_ADDON_PATH . 'templates/search.php';

            return $template;
        }

        /**
         *  Template: Use "taxonomy.php" template inside the PiloPress-Addon
         */
        public function taxonomy_template( $template ) {

            if ( !is_tax() ) {
                return $template;
            }

            // In plugin
            $template = PIP_ADDON_PATH . 'templates/taxonomy.php';

            return $template;
        }

        /**
         *  Edit PIP Flexible args
         *
         * @param $field_group
         *
         * @return mixed
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
         *
         * @param $field
         *
         * @return mixed
         */
        public function pip_tailwind_config_default( $field ) {

            ob_start(); ?>
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    'theme': {
        'colors': {
            'transparent': 'transparent',
            'current': 'currentColor',
            'black': '#2E2B28',
            'white': '#FFFFFF',
            'gray': defaultTheme.colors.gray,
            'primary': '#575756',
            'primary-500': '#575756',
            'secondary': '#E2101B',
            'secondary-500': '#E2101B',
        },
        'fontFamily': {
            'primary': ['NomDeLaFont', ...defaultTheme.fontFamily.sans],
            'secondary': ['NomDeLaFont', ...defaultTheme.fontFamily.serif],
        },
        'inset': {
            '0': 0,
            auto: 'auto',
            '1/2': '50%',
            'full': '100%',
        },
        'container': {
            'center': 'true',
            'padding': {
                default: '2rem',
                'lg': 0,
            },
        },
        'extend': {
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
        'display': ['responsive', 'group-hover'],
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
         *
         * @param $field
         *
         * @return mixed
         */
        public function pip_tailwind_style_default( $field ) {

            ob_start(); ?>
@tailwind base;
@tailwind components;

body {
    @apply font-primary;
}

/** Headings */
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

/* Inputs */
.select2 > .selection > .select2-selection,
input[type="email"],
input[type="password"],
input[type="text"],
input[type="tel"],
input[type="number"],
select,
textarea {
    @apply text-sm border-2 border-gray rounded p-2;
}

/* Select2 - Fix margin */
.select2 > .selection > .select2-selection {
    margin: 0;
}

/* Select2 - Fix arrow position */
.select2 > .selection > .select2-selection > .select2-selection__arrow {
    top: 50%;
    right: 1%;
    transform: translateY(-50%);
}

/* Select2 - Fix clear icon position */
.select2 > .selection .select2-selection__clear {
    padding: 0 .5em;
    margin-right: calc(1% + 1em);
}

/* Select2 - Fix select style */
.select2 > .selection > .select2-selection > .select2-selection__rendered {
    padding: 0;
    line-height: inherit;
}

/** Select2 - Dropdown - Option selected - Hover */
.select2-results > .select2-results__options > .select2-results__option--highlighted[aria-selected],
.select2-results > .select2-results__options > .select2-results__option--highlighted[data-selected] {
    @apply bg-secondary;
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
