<?php
/**
 * Custom Auth via API
 *
 * @package   custom-auth-via-api
 * @author    R-DEV <office@r-dev.cloud>
 * @copyright 2022 Custom Auth via API
 * @license   MIT
 * @link      https://r-dev.cloud
 *
 * Plugin Name:     Custom Auth via API
 * Plugin URI:      https://r-dev.cloud
 * Description:     Plugin allows to change default login process to integrate with custom API auth
 * Version:         1.0.0
 * Author:          R-DEV
 * Author URI:      https://r-dev.cloud
 * Text Domain:     custom-auth-via-api
 * Domain Path:     /languages
 * Requires PHP:    7.1
 * Requires WP:     5.5.0
 * Namespace:       CustomAuthViaApi
 */

declare( strict_types = 1 );

/**
 * Define the default root file of the plugin
 *
 * @since 1.0.0
 */
const CUSTOM_AUTH_VIA_API_PLUGIN_FILE = __FILE__;

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
$custom_auth_via_api_autoloader = require plugin_dir_path( CUSTOM_AUTH_VIA_API_PLUGIN_FILE ) . 'vendor/autoload.php';

/**
 * Setup hooks (activation, deactivation, uninstall)
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, [ 'CustomAuthViaApi\Config\Setup', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'CustomAuthViaApi\Config\Setup', 'deactivation' ] );
register_uninstall_hook( __FILE__, [ 'CustomAuthViaApi\Config\Setup', 'uninstall' ] );

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( '\CustomAuthViaApi\Bootstrap' ) ) {
	wp_die( __( 'Custom Auth via API is unable to find the Bootstrap class.', 'custom-auth-via-api' ) );
}
add_action(
	'plugins_loaded',
	static function () use ( $custom_auth_via_api_autoloader ) {
		/**
		 * @see \CustomAuthViaApi\Bootstrap
		 */
		try {
			new \CustomAuthViaApi\Bootstrap( $custom_auth_via_api_autoloader );
		} catch ( Exception $e ) {
			wp_die( __( 'Custom Auth via API is unable to run the Bootstrap class.', 'custom-auth-via-api' ) );
		}
	}
);

/**
 * Create a main function for external uses
 *
 * @return \CustomAuthViaApi\Common\Functions
 * @since 1.0.0
 */
function custom_auth_via_api(): \CustomAuthViaApi\Common\Functions {
	return new \CustomAuthViaApi\Common\Functions();
}
