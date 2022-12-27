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

namespace CustomAuthViaApi\Common;

use CustomAuthViaApi\App\Frontend\Templates;
use CustomAuthViaApi\Common\Abstracts\Base;

/**
 * Main function class for external uses
 *
 * @see custom_auth_via_api()
 * @package CustomAuthViaApi\Common
 */
class Functions extends Base {
	/**
	 * Get plugin data by using custom_auth_via_api()->getData()
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getData(): array {
		return $this->plugin->data();
	}

	/**
	 * Get the template instantiated class using custom_auth_via_api()->templates()
	 *
	 * @return Templates
	 * @since 1.0.0
	 */
	public function templates(): Templates {
		return new Templates();
	}
}
