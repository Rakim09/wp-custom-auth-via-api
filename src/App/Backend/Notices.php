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
 * Class Notices
 *
 * @package CustomAuthViaApi\App\Backend
 * @since 1.0.0
 */
class Notices extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This backend class is only being instantiated in the backend as requested in the Bootstrap class
		 *
		 * @see Requester::isAdminBackend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here for admin notices specific functions
		 */
	}
}
