<?php namespace NMGNtech\Admin;

/**
 * Class Validation
 * @package NMGNtech\Admin
 */
class Validation {

	/**
	 * Validate integers.
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public static function integer( $input ) {
		return filter_var( filter_var( $input, FILTER_SANITIZE_NUMBER_INT ), FILTER_VALIDATE_INT );
	}

	/**
	 * Alias for the integer validation.
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public static function int( $input ) {
		return self::integer( $input );
	}

	/**
	 * Sanitize strings.
	 * @param $input
	 *
	 * @return mixed
	 */
	public static function string( $input ) {
		return filter_var( filter_var( $input, FILTER_SANITIZE_STRING ) );
	}

	/**
	 * Alias for the string validation.
	 *
	 * @param $input
	 *
	 * @return mixed
	 */
	public static function str( $input ) {
		return self::string( $input );
	}

	/**
	 * Check if required fields aren't empty.
	 *
	 * @param $input
	 *
	 * @return bool
	 */
	public static function required( $input ) {
		$input = trim( $input );

		return !empty( $input );
	}

	/**
	 * Validate email
	 * @param $input
	 *
	 * @return mixed
	 */
	public static function email( $input ) {
		return filter_var( filter_var( $input, FILTER_SANITIZE_EMAIL ), FILTER_VALIDATE_EMAIL );
	}

	/**
	 * Validate URLs
	 * @param $input
	 *
	 * @return mixed
	 */
	public static function url( $input ) {
		return filter_var( filter_var( $input, FILTER_SANITIZE_URL ), FILTER_VALIDATE_URL );
	}
}
