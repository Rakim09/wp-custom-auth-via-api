<?php
/**
 * Custom Auth via API
 *
 * @package   custom-auth-via-api
 * @author    R-DEV <office@r-dev.cloud>
 * @copyright 2022 Custom Auth via API
 * @license   MIT
 * @link      https://r-dev.cloud
 */

declare( strict_types = 1 );

namespace CustomAuthViaApi\Common\Utils;

use CustomAuthViaApi\Config\Plugin;

/**
 * Utility to show prettified wp_die errors, write debug logs as
 * string or array and to deactivate plugin and print a notice
 *
 * @package CustomAuthViaApi\Config
 * @since 1.0.0
 */
class Errors {

	/**
	 * Get the plugin data in static form
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function getPluginData(): array {
		return Plugin::init()->data();
	}

	/**
	 * Prettified wp_die error function
	 *
	 * @param $message : The error message
	 * @param string $subtitle : Specified title of the error
	 * @param string $source : File source of the error
	 * @param string $title : General title of the error
	 * @param string $exception
	 * @since 1.0.0
	 */
	public static function wpDie( $message = '', $subtitle = '', $source = '', $exception = '', $title = '' ) {
		if ( $message ) {
			$plugin = self::getPluginData();
			$title = $title ? $title : $plugin['name'] . ' ' . $plugin['version'] . ' ' . __( '&rsaquo; Fatal Error', 'custom-auth-via-api' );
			Errors::writeLog(
				[
					'title'     => $title . ' - ' . $subtitle,
					'message'   => $message,
					'source'    => $source,
					'exception' => $exception,
				]
			);
			$source = $source ? '<code>' .
				sprintf(  /* translators: %s: file path */
					__( 'Error source: %s', 'custom-auth-via-api' ), $source
				) . '</code><BR><BR>' : '';
			$footer = $source . '<a href="' . $plugin['uri'] . '">' . $plugin['uri'] . '</a>';
			$message = '<p>' . $message . '</p>';
			$message .= $exception ? '<p><strong>Exception: </strong><BR>' . $exception . '</p>' : '';
			$message = "<h1>{$title}<br><small>{$subtitle}</small></h1>{$message}<hr><p>{$footer}</p>";
			wp_die( $message, $title );
		} else {
			wp_die();
		}
	}

	/**
	 * De-activates the plugin and shows notice error in back-end
	 *
	 * @param $message : The error message
	 * @param string $subtitle : Specified title of the error
	 * @param string $source : File source of the error
	 * @param string $title : General title of the error
	 * @param string $exception
	 * @since 1.0.0
	 */
	public static function pluginDie( $message = '', $subtitle = '', $source = '', $exception = '', $title = '' ) {
		if ( $message ) {
			$plugin = self::getPluginData();
			$title = $title ? $title : $plugin['name'] . ' ' . $plugin['version'] . ' ' . __( '&rsaquo; Plugin Disabled', 'custom-auth-via-api' );
			Errors::writeLog(
				[
					'title'     => $title . ' - ' . $subtitle,
					'message'   => $message,
					'source'    => $source,
					'exception' => $exception,
				]
			);
			$source = $source ? '<small>' .
				sprintf( /* translators: %s: file path */
					__( 'Error source: %s', 'custom-auth-via-api' ), $source
				) . '</small> - ' : '';
			$footer = $source . '<a href="' . $plugin['uri'] . '"><small>' . $plugin['uri'] . '</small></a>';
			$error = "<strong><h3>{$title}</h3>{$subtitle}</strong><p>{$message}</p><hr><p>{$footer}</p>";
			global $custom_auth_via_api_die_notice;
			$custom_auth_via_api_die_notice = $error;
			add_action( 'admin_notices',
				static function () {
					global $custom_auth_via_api_die_notice;
					echo wp_kses_post(
						sprintf(
							'<div class="notice notice-error"><p>%s</p></div>',
							$custom_auth_via_api_die_notice
						)
					);
				}
			);
		}
		add_action( 'admin_init',
			static function () {
				deactivate_plugins( plugin_basename( CUSTOM_AUTH_VIA_API_PLUGIN_FILE ) ); // phpcs:disable ImportDetection.Imports.RequireImports.Symbol -- this constant is global
			}
		);
	}

	/**
	 * Writes a log if wp_debug is enables
	 *
	 * @param $log
	 * @since 1.0.0
	 */
	public static function writeLog( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
