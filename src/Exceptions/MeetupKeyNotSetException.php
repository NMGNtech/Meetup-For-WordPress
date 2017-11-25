<?php namespace NMGNtech\Exceptions;

/**
 * Exception MeetupKeyNotSetException
 *
 * @package NMGNtech\Exceptions
 */
class MeetupKeyNotSetException extends \Exception {

	/**
	 * MeetupKeyNotSetException constructor.
	 */
	public function __construct() {
	    parent::__construct( 'No Meetup API key was set.' );
	}
}
