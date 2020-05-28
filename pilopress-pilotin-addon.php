<?php
/**
 * Plugin Name:         Pilo'Press - Pilot'in Addon
 * Plugin URI:          https://www.pilot-in.com
 * Description:         Quick start config we use at Pilot'in for WordPress & Pilo'Press
 * Version:             0.1
 * Author:              Pilot'in
 * Author URI:          https://www.pilot-in.com
 * License:             GPLv2 or later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP:        5.6 or higher
 * Requires at least:   4.9 or higher
 * Text Domain:         pip-pi-addon
 * Domain Path:         /lang
 */

defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'PIP_PI_Addon' ) ) {
    class PIP_PI_Addon {

        // Plugin version
        var $version = '0.1';

        // PiloPress
        var $pip = false;

        /**
         * Pilo'Press - Pilot'in Addon constructor.
         */
        public function __construct() {
            // Do nothing.
        }

        /**
         * Initialize plugin
         */
        public function initialize() {

            // Constants
            $this->define( 'PIP_PI_FILE', __FILE__ );
            $this->define( 'PIP_PI_PATH', plugin_dir_path( __FILE__ ) );
            $this->define( 'PIP_PI_URL', plugin_dir_url( __FILE__ ) );
            $this->define( 'PIP_PI_BASENAME', plugin_basename( __FILE__ ) );

            // Init
            include_once PIP_PI_PATH . 'init.php';

            // Load
            add_action( 'acf/include_field_types', array( $this, 'load' ) );

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

            // Main
            pip_include( 'includes/class-main.php' );

            // Helpers
            pip_include( 'includes/helpers.php' );

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
 * @return PIP_PI_Addon
 */
function pip_pi_addon() {
    global $pip_pi_addon;

    if ( !isset( $pip_pi_addon ) ) {
        $pip_pi_addon = new PIP_PI_Addon();
        $pip_pi_addon->initialize();
    }

    return $pip_pi_addon;
}

// Instantiate
pip_pi_addon();
