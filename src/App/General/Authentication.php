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

declare( strict_types=1 );

namespace CustomAuthViaApi\App\General;

use CustomAuthViaApi\Common\Abstracts\Base;
use JetBrains\PhpStorm\NoReturn;
use WP_Error;
use WP_User;

/**
 * Class Authentication
 *
 * @package CustomAuthViaApi\App\General
 * @since 1.0.0
 */
class Authentication extends Base {
	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init(): void {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 *
		 */
		add_filter( "authenticate", [ $this, 'authenticate' ], 10, 3 );

		add_action( 'user_register', [ $this, 'user_register' ], 10, 2 );
	}

	/**
	 * @param WP_User|WP_Error|null $user
	 * @param string $email
	 * @param string $password
	 *
	 * @return WP_User|WP_Error
	 */
	public function authenticate( null|WP_User|WP_Error $user, string $email, string $password ): WP_User|WP_Error {
		if ( $email === '' || $password === '' ) {
			return new WP_Error( 'denied', __( "ERROR: User/pass bad" ) );
		}

		$args = [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
			],
			'body'    => [
				'grant_type' => 'password',
				'username'   => $email,
				'password'   => $password
			],
		];

		$response = wp_remote_post( get_option( 'rd_ca_api_login' ), $args );

		if ( $response['response']['code'] === 400 ) {
			$user = new WP_Error( 'denied', __( "ERROR: User/pass bad" ) );
		} else {
			$user_obj = new WP_User();
			$user     = $user_obj->get_data_by( 'email', $email );
			$user     = new WP_User( $user->ID );

			if ( $user->ID === 0 ) {
				$new_user_id = wp_insert_user([
					'user_email' => $email,
					'user_login' => $email
				]);

				$user = new WP_User ( $new_user_id );
			}
		}
		return $user;
	}

	public function user_register( int $user_id, array $userdata ): void {
		$args = [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
			],
			'body'    => [
				'UserName' => $userdata['user_email'],
				'Email' => $userdata['user_email'],
				'Password'   => $userdata['user_pass'],
				"RoleId" => "c0563e0c-8fe4-4f2f-97df-d0b02370da1b",
				"SourceApp" => 4
			],
		];

		wp_remote_post( get_option( 'rd_ca_api_registration' ), $args );
	}
}