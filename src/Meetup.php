<?php namespace NMGNtech;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use NMGNtech\Exceptions\MeetupGroupNotSetException;
use NMGNtech\Exceptions\MeetupKeyNotSetException;

/**
 * Class Meetup
 *
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

	/**
	 * Meetup constructor.
	 *
	 * @param string $key The Meetup API key.
	 * @param string $group The Meetup group name.
	 *
	 * @throws MeetupGroupNotSetException
	 * @throws MeetupKeyNotSetException
	 */
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
	 * Setups the Meetup client.
	 *
	 * @return void
	 */
	private function setupClient() {
		$this->client = MeetupKeyAuthClient::factory( [
			'key' => $this->key
		] );
	}

	/**
	 * Retrieves all the events for the set group.
	 *
	 * @param string $fields The fields that need to be retrieved.
	 *
	 * @return \DMS\Service\Meetup\Response\MultiResultResponse The Meetup API response.
	 */
	public function events($fields = '') {
		return $this->client->getGroup([
				'urlname' => $this->group,
			    'fields' => $fields
			]);
	}

	/**
	 * Retrieves the next event for the set group.
	 *
	 * @return array The next event's information.
	 */
	public function nextEvent() {
		$events = $this->client->getGroupEvents([
			'urlname' => $this->group,
			'scroll' => 'next_upcoming',
		]);

		return $events[0];
	}

	/**
	 * Retrieves a list of next events for the set group.
	 *
	 * @return array The next event's information.
	 */
	public function nextEvents() {
		$events = $this->client->getGroupEvents([
			'urlname' => $this->group,
			'scroll' => 'next_upcoming',
		]);

		return $events->getData();
	}

	/**
	 * Retrieves the RSVPs for a particular event.
	 *
	 * @param array $event The event to retrieve the RSVPs for.
	 *
	 * @return array The RSVPs or unknown if there's no RSVP limit.
	 */
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

	/**
	 * Retrieves an event by it's ID.
	 *
	 * @param string $id The event's ID.
	 *
	 * @return array The event.
	 */
	public function event( $id ) {
		return $this->client->getEvent( [ 'id' => $id ] );
	}
}
