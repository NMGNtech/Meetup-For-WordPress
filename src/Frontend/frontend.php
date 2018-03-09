<?php namespace NMGNtech\Frontend;

use NMGNtech\Exceptions\MeetupGroupNotSetException;
use NMGNtech\Exceptions\MeetupKeyNotSetException;
use NMGNtech\Meetup;

/**
 * Class Frontend
 *
 * @package NMGNtech\Frontend
 */
class Frontend {

	/**
	 * Frontend constructor.
	 */
	public function __construct() {

		try {
			$this->init();
		} catch ( MeetupKeyNotSetException $exception ) {
			// Something profound
		} catch ( MeetupGroupNotSetException $exception ) {
			// Something profound
		}
	}

	/**
	 * Initializes the front-end.
	 *
	 * @return void
	 */
	public function init() {
		$this->add_shortcodes();
	}

	/**
	 * Retrieves the next event's description if there's a cached version of it.
	 *
	 * @return string The next event's description. Empty string if no data is available.
	 */
	public function next_event_description() {
		if ( $this->is_cached_event_available() ) {
			return $this->get_cached_event()['description'];
		}

		return '';
	}

	/**
	 * Retrieves the next event's venue if there's a cached version of it.
	 *
	 * @return array The venue.
	 */
	public function get_venue() {
		return $this->get_cached_event()['venue'];
	}

	/**
	 * Get the address for the next event.
	 *
	 * @return string The venue's address.
	 */
	public function next_event_address() {
		$venue = $this->get_venue();

		return sprintf(
			'<div><strong>%s</strong><p>%s<br />%s</p></div>',
			$venue['name'],
			$venue['address_1'],
			$venue['city']
		);
	}

	/**
	 * Gets the map of the next event.
	 *
	 * @return string A Google Maps embedded map of the venue location.
	 */
	public function next_event_map() {
		$venue = $this->get_venue();

		return sprintf(
			'<iframe width="675" height="375" frameborder="0" style="border: 0" src="https://www.google.com/maps/embed/v1/place?key=%s&q=%s&zoom=18" allowfullscreen></iframe>',
			get_option( MWP_PREFIX . 'map-api-key' ),
			$venue['name'] . ',' . $venue['city']
		);
	}

	/**
	 * Displays the cached event's name.
	 *
	 * @return void
	 */
	public function next_events() {
		foreach ( $this->get_cached_events() as $cached_event ) {
			echo $cached_event['name'] . "\n";
		}
	}

	/**
	 * Adds shortcodes to be used in pages and post.
	 *
	 * @return void
	 */
	public function add_shortcodes() {
		add_shortcode( 'meetup_wp_next_event', [ $this, 'next_event_description' ] );
		add_shortcode( 'meetup_wp_next_event_address', [ $this, 'next_event_address' ] );
		add_shortcode( 'meetup_wp_next_event_map', [ $this, 'next_event_map' ] );
		add_shortcode( 'meetup_wp_next_events', [ $this, 'next_events' ] );
	}

	/**
	 * Determines whether or not an event was cached.
	 *
	 * @return bool Whether or not a cached event is available.
	 */
	protected function is_cached_event_available() {
		return get_transient( 'mwp_next_event' ) !== false;
	}

	/**
	 * Determines whether or not events were cached.
	 *
	 * @return bool Whether or not cached events are available.
	 */
	protected function are_cached_events_available() {
		return get_transient( 'mwp_next_events' ) !== false;
	}

	/**
	 * Gets the cached event from the transient (if present).
	 *
	 * @return array The cached event.
	 */
	protected function get_cached_event() {
		return get_transient( 'mwp_next_events' )[0];
	}

	/**
	 * Gets the cached events from the transient (if present).
	 *
	 * @return array The cached event.
	 */
	protected function get_cached_events() {
		return get_transient( 'mwp_next_events' );
	}
}

new Frontend();
