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

namespace CustomAuthViaApi\App\Backend;

use CustomAuthViaApi\Common\Abstracts\Base;

/**
 * Class Settings
 *
 * @package CustomAuthViaApi\App\Backend
 * @since 1.0.0
 */
class Settings extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init(): void {
		/**
		 * This backend class is only being instantiated in the backend as requested in the Bootstrap class
		 *
		 * @see Requester::isAdminBackend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here for admin settings specific functions
		 */
		add_action('admin_menu', [ $this, 'registerSettingsMenu' ]);

		add_action( 'admin_init', [ $this, 'registerSettingFields' ] );

		add_filter( 'allowed_options', function ($allowed_options) {
			$allowed_options['custom-auth-general-settings'] = [
				'rd_ca_api_login',
				'rd_ca_api_registration'
			];
			return $allowed_options;
		});
	}

	/**
	 * Register plugin settings menu
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function registerSettingsMenu(): void {
		add_options_page(
			__( 'Custom Auth via API settings', $this->plugin->textDomain() ),
			__( 'Custom Auth via API', $this->plugin->textDomain() ),
			'administrator',
			'custom-auth-general-settings',
			[ $this, 'renderSettingsPage' ],
		);
	}

	public function renderSettingsPage(): void {
		require_once $this->plugin->templatePath().'/admin/custom-auth-settings.php';
	}

	public function registerSettingFields(): void {
		add_settings_section(
			'custom-auth-general-settings-section',
			__( 'General', $this->plugin->textDomain() ),
			[ $this, 'settingsSectionCallback' ],
			'custom-auth-general-settings',
		);

		add_settings_field(
			'rd_ca_api_login',
			'Login URL',
			[ $this, 'renderSettingsField' ],
			'custom-auth-general-settings',
			'custom-auth-general-settings-section',
			[
				'label_for' => 'rd_ca_api_login',
				'required' => true,
			]
		);

		add_settings_field(
			'rd_ca_api_registration',
			'Registration URL',
			[ $this, 'renderSettingsField' ],
			'custom-auth-general-settings',
			'custom-auth-general-settings-section',
			[
				'label_for' => 'rd_ca_api_registration',
				'required' => true,
			]
		);

		register_setting(
			'custom-auth-general-settings-section',
			'rd_ca_api_login',
		);

		register_setting(
			'custom-auth-general-settings-section',
			'rd_ca_api_registration',
		);
	}

	public function settingsSectionCallback( array $args ): void {
		echo "";
	}

	public function renderSettingsField( array $args ): void {
		$value = get_option( $args['label_for'] );

		$html = sprintf(
			'<input
				class="regular-text"
				name="%1$s"
				id="%1$s"
				type="text"
				value="%2$s"
				%3$s
			/>',
			$args['label_for'],
			esc_attr( $value ),
			$args['required'] ? 'required="required"' : '',
		);

		if ( isset( $args['description'] ) && '' !== $args['description'] ) {
			$html .= sprintf(
				'<p class="description" id="%1$s">
					%2$s
				</p>',
				$args['label_for'] . '-description',
				$args['description'],
			);
		}

		echo $html;
	}
}
