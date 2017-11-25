<?php
/**
 * Plugin Name: Meetup-for-wp
 * Version: 0.1-alpha
 * Description: PLUGIN DESCRIPTION HERE
 * Author: NMGNtech
 * Author URI: http://www.NMGNtech.nl
 * Plugin URI: -
 * GitHub Plugin URI: https://github.com/NMGNtech/Meetup-For-WordPress
 * Text Domain: meetup-for-wp
 * Domain Path: /languages
 * @package Meetup-for-wp
 */

require __DIR__ . '/vendor/autoload.php';

/**
 * TODO
 * - Meetup API key input
 * - Additional fields input
 * - Shortcode support
 * - Map toggle
 * - Map styling etc
 * - Travis build
 */
class MeetupForWP {

	/** @var \NMGNtech\Meetup */
	private $instance;

	/**
	 * @var \NMGNtech\Frontend\Frontend
	 */
	private $frontend;

	/**
	 * @var \NMGNtech\Admin\Admin
	 */
	private $admin;

	/**
	 * MeetupForWP constructor.
	 */
	public function __construct() {

		if ( ! defined( 'MWP_PREFIX' ) ) {
			define('MWP_PREFIX', 'mwp-');
		}

		if ( is_admin() ) {
			add_action( 'plugins_loaded', [ $this, 'init_backend' ] );
		}

		if ( ! is_admin() ) {
			add_action( 'plugins_loaded', [ $this, 'init_frontend' ] );
		}
	}

	/**
	 * Initializes the front-end.
	 *
	 * @return void
	 */
	public function init_frontend() {
		$this->frontend = new NMGNtech\Frontend\Frontend();
	}

	/**
	 * Initializes the backend.
	 *
	 * @return void
	 */
	public function init_backend() {
		$this->admin = new NMGNtech\Admin\Admin();
	}

	/**
	 * Retrieves the next event's information.
	 *
	 * @return array Information about the next event.
	 */
	public function next_event() {
		return $this->instance->event( $this->instance->nextEvent() );
	}
}

new MeetupForWP();


