<?php
/**
 * Plugin Name: Meetup for WordPress
 * Version: 0.1
 * Description: A plugin that makes it possible to easily integrate the Meetup API into your website.
 * Author: NMGN.tech
 * Author URI: https://www.NMGN.tech
 * Plugin URI: -
 * GitHub Plugin URI: https://github.com/NMGNtech/Meetup-For-WordPress
 * Text Domain: meetup-for-wp
 * Domain Path: /languages
 *
 * @package Meetup-for-wp
 */

require __DIR__ . '/vendor/autoload.php';

use NMGNtech\Frontend\Frontend;
use NMGNtech\Admin\Admin;

/**
 * Class MeetupForWP.
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

		add_action( 'widgets_init', [ $this, 'register_widgets' ] );
	}

	/**
	 * Initializes the front-end.
	 *
	 * @return void
	 */
	public function init_frontend() {
		$this->frontend = new Frontend();
	}

	/**
	 * Initializes the backend.
	 *
	 * @return void
	 */
	public function init_backend() {
		$this->admin = new Admin();
	}

	/**
	 * Registers the widgets with WordPress.
	 *
	 * @return void
	 */
	public function register_widgets() {
		register_widget( 'NMGNtech\Widgets\NextEventWidget' );
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

// Create a new instance.
new MeetupForWP();
