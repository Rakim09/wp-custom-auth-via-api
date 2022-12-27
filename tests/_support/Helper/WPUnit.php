<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class WPUnit extends \Codeception\Module
{
	// wrapper for wp has_filter()
	public static function has_filter ( $filter, $obj, $function ): bool {
		$registered = has_filter( $filter,
			array(
				$obj,
				$function
			) );
		if ( $registered ) {
			return true;
		} else {
			return false;
		}
	}
}
