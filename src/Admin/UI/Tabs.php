<?php

class Tabs {

	private $tabs = [];
	protected $active_tab = '';

	public function __construct() {

	}

	public function add_tab( array $tab ) {
		array_push( $this->tabs, $tab );
	}

	public function get_active_tab() {
		return $this->active_tab;
	}

	public function set_active_tab( $tab ) {
		if ( ! in_array( $tab->id, array_keys( $this->tabs ), true ) ) {
			throw new Error( 'Invalid tab selected' );
		}

		$this->active_tab = $tab;
	}

	public function render() {
		foreach ( $this->tabs as $tab ) {
			// Render
		}
	}
}
