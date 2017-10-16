<?php namespace NMGNtech\Admin;
use NMGNtech\Meetup;

/**
 * Class Admin
 * @package NMGNtech\Admin
 */
class Admin {

	protected $instance;

	public function __construct() {
		$this->register_actions();
	}

	private function register_actions() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );

		add_action( 'admin_post_fetch_data', array( $this, 'fetch_data' ) );
	}

	public function add_menu() {
		add_menu_page( 'Meetup For WP Options', 'Meetup For WP', 'manage_options', 'NMGNtech-mwp', [ $this, 'add_form' ] );

		add_action( 'admin_init', array( $this, 'register_mwp_settings' ) );
	}

	public function fetch_data() {
		$meetup = new Meetup( $this->mwp_option( 'api-key' ), $this->mwp_option( 'meetup-group' ) );

		// Set the transient
		$next_event = $meetup->nextEvent();

		set_transient( 'mwp_next_event', $next_event, HOUR_IN_SENCONDS );

		wp_redirect( admin_url( 'admin.php?page=NMGNtech-mwp' ) );
	}

	public function register_mwp_settings() {
		//register our settings
		register_setting( 'mwp-api-group', MWP_PREFIX . 'api-key', array( $this, 'validate_api_key' ) );
		register_setting( 'mwp-api-group', MWP_PREFIX . 'map-api-key', array( $this, 'validate_map_api_key' ) );
		register_setting( 'mwp-api-group', MWP_PREFIX . 'meetup-group', array( $this, 'validate_group' ) );
		register_setting( 'mwp-api-group', MWP_PREFIX . 'additional-fields', array( $this, 'validate_additional_fields' ) );
	}

	public function validate_api_key( $input ) {
		if ( Validation::required( $input ) === false ) {
			add_settings_error('api-key', 'missing-api-key', 'API key is missing' );

			return '';
		}

		return $input;
	}

	public function validate_map_api_key( $input ) {
		if ( Validation::required( $input ) === false ) {
			add_settings_error('map-api-key', 'missing-map-api-key', 'Google Maps API key is missing' );

			return '';
		}

		return $input;
	}

	public function validate_group( $input ) {
		if ( Validation::required( $input ) === false ) {
			add_settings_error('meetup-group', 'missing-group', 'Meetup group is missing' );

			return '';
		}

		return $input;
	}

	public function validate_additional_fields( $input ) {
		if ( Validation::string( $input ) === false ) {
			add_settings_error('additional-fields', 'additional-fields-non-string', 'Additional fields need to consist of strings' );

			return '';
		}

		return $input;
	}

	/**
	 * @param $field
	 * @param $error_code
	 * @param $error_message
	 */
	public function add_error_message_for_field( $field, $error_code, $error_message ) {
		add_settings_error( $field, $error_code, $error_message );
	}

	/**
	 * @param $field
	 * @param $success_code
	 * @param $success_message
	 */
	public function add_success_message_for_field( $field, $success_code, $success_message  ) {
		add_settings_error( $field, $success_code, $success_message, 'updated' );
	}

	/**
	 * @param $field
	 * @param $success_code
	 * @param $success_message
	 */
	public function add_warning_message_for_field( $field, $success_code, $success_message  ) {
		add_settings_error( $field, $success_code, $success_message, 'notice-warning' );
	}

	public function mwp_option( $option ) {
        return get_option( MWP_PREFIX . $option );
	}

	/**
	 * Generates the settings form.
	 */
	public function add_form() {
		if ( !current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		settings_errors();

		?>
			<div class="wrap">
				<h2>Meetup For WP</h2>
				<form method="post" action="options.php">
					<?php settings_fields( 'mwp-api-group' ); ?>
					<?php do_settings_sections( 'mwp-api-group' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">API Key</th>
							<td><input type="text" name="api-key" value="<?php echo esc_attr( $this->mwp_option('api-key') ); ?>" /></td>
						</tr>

						<tr valign="top">
							<th scope="row">Google Maps API Key</th>
							<td><input type="text" name="map-api-key" value="<?php echo esc_attr( $this->mwp_option('map-api-key') ); ?>" /></td>
						</tr>

						<tr valign="top">
							<th scope="row">Meetup Page</th>
							<td><input type="text" name="meetup-group" value="<?php echo esc_attr( $this->mwp_option('meetup-group') ); ?>" /></td>
						</tr>

						<tr valign="top">
							<th scope="row">Additional fields</th>
							<td><input type="text" name="additional-fields" value="<?php echo esc_attr( $this->mwp_option('additional-fields') ); ?>" /></td>
						</tr>
					</table>

					<p class="submit">
						<a href="<?php echo admin_url( 'admin-post.php?action=fetch_data' ); ?>" class="button button-primary">
							<?php esc_attr_e('Pull in next event data') ?>
						</a>
					</p>

					<?php submit_button(); ?>
				</form>
			</div>
		<?php
	}
}
