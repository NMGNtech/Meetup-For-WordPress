<?php
/**
 * Plugin Name: Meetup-for-wp
 * Version: 0.1-alpha
 * Description: PLUGIN DESCRIPTION HERE
 * Author: NMGNtech
 * Author URI: http://www.NMGNtech.nl
 * Plugin URI: -
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
 */
class MeetupForWP {

	/** @var \NMGNtech\Meetup */
	private $instance;
	private $frontend;
	private $admin;

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

	public function init_frontend() {
		$this->frontend = new NMGNtech\Frontend\Frontend();
	}

	public function init_backend() {
		$this->admin = new NMGNtech\Admin\Admin();
	}

	public function next_event() {
		return $this->instance->event( $this->instance->nextEvent() );
	}
}

new MeetupForWP();


