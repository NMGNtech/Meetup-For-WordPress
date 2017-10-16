<?php

/**
 * Class Cache
 */
class Cache {

	const MWP_PREFIX = 'mwp_';

	private static $instance;

	public static function getInstance() {
		if ( static::$instance === null ) {
			static::$instance = new static();
		}

		return static::$instance;
	}



	// Protecting this instance against potential wrongful usage.
	protected function __construct() {
		
	}

	private function __clone() {

	}

	private function __wakeup() {

	}


}
