<?php namespace NMGNtech\Exceptions;

/**
 * Exception MeetupGroupNotSetException.
 *
 * @package NMGNtech\Exceptions
 */
class MeetupGroupNotSetException extends \Exception {

	/**
	 * MeetupGroupNotSetException constructor.
	 */
	public function __construct() {
	    parent::__construct( 'No Meetup group was set.' );
	}
}
