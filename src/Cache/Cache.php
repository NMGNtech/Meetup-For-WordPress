<?php

/**
 * Class Cache
 */
class Cache {

	const MWP_PREFIX = 'mwp_';

	private static $instance;

	/**
	 * @return mixed
	 */
	public static function getInstance() {
		if ( static::$instance === null ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	// Protecting this instance against potential wrongful usage.
	protected function __construct() {
		
	}
}
