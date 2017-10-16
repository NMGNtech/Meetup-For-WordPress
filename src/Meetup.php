<?php namespace NMGNtech;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use NMGNtech\Exceptions\MeetupGroupNotSetException;
use NMGNtech\Exceptions\MeetupKeyNotSetException;

/**
 * Class Meetup
 * @package NMGNtech\Services
 */
class Meetup {
	/**
	 * @var string
	 */
	protected $key;

	/**
	 * @var string
	 */
	protected $group;

	/**
	 * @var MeetupKeyAuthClient
	 */
	protected $client;

	public function __construct($key = '', $group = '') {
		if ( $key === '' ) {
			throw new MeetupKeyNotSetException;
		}

		if ($group === '') {
			throw new MeetupGroupNotSetException;
		}

		$this->key = $key;
		$this->group = $group;

		$this->setupClient();
	}

	/**
	 * Setups the Meetup client
	 */
	private function setupClient() {
		$this->client = MeetupKeyAuthClient::factory( [
			'key' => $this->key
		] );
	}

	public function events($fields = '') {
		return $this->client->getGroup([
				'urlname' => $this->group,
			    'fields' => $fields
			]);
	}

	public function nextEvent() {
		$events = $this->client->getGroupEvents([
			'urlname' => $this->group,
			'scroll' => 'next_upcoming',
		]);

		return $events[0];
	}

	public function get_rsvps( $event ) {
		if ( ! array_key_exists( 'rsvp_limit', $event ) ) {
			return [
				'limit' => 'Unknown',
				'attending' => 'Unknown',
			];
		}

		return [
			'limit' => $event['rsvp_limit'],
			'attending' => $event['yes_rsvp_count'],
		];
	}

	public function event( $id ) {
		return $this->client->getEvent( [ 'id' => $id ] );
	}
}
