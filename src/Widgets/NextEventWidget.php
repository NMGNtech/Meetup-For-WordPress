<?php namespace NMGNtech\Widgets;

class NextEventWidget extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'mwp_next_event_widget',
			'Meetup for WordPress - Next Event',
			array( 'description' => 'Next event Widget' )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo 'Next meetup data here';
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		return $instance;
	}

	public function form( $instance ) {
	}
}
