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

namespace CustomAuthViaApi\Common\Traits;

/**
 * The singleton skeleton trait to instantiate the class only once
 *
 * @package CustomAuthViaApi\Common\Traits
 * @since 1.0.0
 */
trait Singleton {
	private static $instance;

	final private function __construct() {
	}

	final public function __clone() {
	}

	final public function __wakeup() {
	}

	/**
	 * @return self
	 * @since 1.0.0
	 */
	final public static function init(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
