<?php
/**
 * Plugin Name:         Pilo'Press - Addon
 * Plugin URI:          https://www.pilot-in.com
 * Description:         Quick start config we use at Pilot'in for WordPress & Pilo'Press
 * Version:             0.1
 * Author:              Pilot'in
 * Author URI:          https://www.pilot-in.com
 * License:             GPLv2 or later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP:        5.6 or higher
 * Requires at least:   4.9 or higher
 * Text Domain:         pip-addon
 * Domain Path:         /lang
 */

defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'PIP_Addon' ) ) {
    class PIP_Addon {

        // Plugin version
        var $version = '0.1';

        // PiloPress
        var $pip = false;

        /**
         * Pilo'Press - Addon constructor.
         */
        public function __construct() {
            // Do nothing.
        }

        /**
         * Initialize plugin
         */
        public function initialize() {

            // Constants
            $this->define( 'PIP_ADDON_FILE', __FILE__ );
            $this->define( 'PIP_ADDON_PATH', plugin_dir_path( __FILE__ ) );
            $this->define( 'PIP_ADDON_URL', plugin_dir_url( __FILE__ ) );
            $this->define( 'PIP_ADDON_BASENAME', plugin_basename( __FILE__ ) );
            $this->define( 'PIP_THEME_PATH', get_stylesheet_directory() );
            $this->define( 'PIP_THEME_URL', get_stylesheet_directory_uri() );

            // Init
            include_once PIP_ADDON_PATH . 'init.php';

            // Load
            add_action( 'plugins_loaded', array( $this, 'load' ) );

            // Hide login
            pip_addon_include( 'includes/class-hide-login.php' );

            // Classic Editor
            pip_addon_include( 'includes/class-classic-editor.php' );
        }

        /**
         * Load classes
         */
        public function load() {

            // Check if Pilo'Press is activated
            if ( !$this->has_pip() ) {
                return;
            }

            // Includes
            add_action( 'acf/init', array( $this, 'includes' ) );

        }

        /**
         * Include files
         */
        public function includes() {

            pip_addon_include( 'includes/class-bottom-admin-bar.php' );
            pip_addon_include( 'includes/class-main.php' );
            pip_addon_include( 'includes/helpers.php' );
            pip_addon_include( 'includes/field-group-configuration.php' );

        }

        /**
         * Define constants
         *
         * @param      $name
         * @param bool $value
         */
        private function define( $name, $value = true ) {
            if ( !defined( $name ) ) {
                define( $name, $value );
            }
        }

        /**
         * Check if Pilo'Press is activated
         *
         * @return bool
         */
        public function has_pip() {
            // If Pilo'Press already available, return
            if ( $this->pip ) {
                return true;
            }

            // Check if Pilo'Press activated
            $this->pip = class_exists( 'PiloPress' );

            return $this->pip;
        }

    }
}

/**
 * Instantiate Pilo'Press - Pilot'in Addon
 *
 * @return PIP_Addon
 */
function pip_addon() {
    global $pip_addon;

    if ( !isset( $pip_addon ) ) {
        $pip_addon = new PIP_Addon();
        $pip_addon->initialize();
    }

    return $pip_addon;
}

// Instantiate
pip_addon();
