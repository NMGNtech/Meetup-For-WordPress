<?php namespace NMGNtech\Widgets;

/**
 * Class NextEventWidget
 *
 * @package NMGNtech\Widgets
 */
class NextEventWidget extends \WP_Widget {

	/**
	 * NextEventWidget constructor.
	 */
	public function __construct() {
		parent::__construct(
			'mwp_next_event_widget',
			'Meetup for WordPress - Next Event',
			array( 'description' => 'Next event Widget' )
		);
	}

	/**
	 * Creates the widget's front-end output.
	 *
	 * @param array $args The arguments of the widget.
	 * @param object $instance The widget instance.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo 'Next meetup data here';
		echo $args['after_widget'];
	}

	/**
	 * Updates the widget instance.
	 *
	 * @param array $new_instance The new widget instance.
	 * @param array $old_instance The old widget instance.
	 *
	 * @return array The new instance.
	 */
	public function update( $new_instance, $old_instance ) {
		return array();
	}

	/**
	 * Creates the widget's backend input form.
	 *
	 * @param object $instance The widget instance.
	 */
	public function form( $instance ) {
	}
}
