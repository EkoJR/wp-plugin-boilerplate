<?php
/**
 * PLUGIN_PREFIX_UPPER Options
 *
 * @package PLUGIN-NICENAME
 * @since 1.0.0
 */

/**
 * Class PLUGIN_PREFIX_UPPER_Options
 *
 * @since 1.0.0
 */
class PLUGIN_PREFIX_UPPER_Options {

	/**
	 * Singleton Instance.
	 *
	 * @since  1.0.0
	 * @access protected
	 *
	 * @var null $instance Singleton Class Instance.
	 */
	protected static $instance = null;

	/**
	 * Stores plugin options.
	 *
	 * @since 1.0.0
	 *
	 * @var null|array $options
	 */
	public $options = null;

	/**
	 * Throws error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @ignore
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin\' huh?', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ), PLUGIN_PREFIX_UPPER_VERSION );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @ignore
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin\' huh?', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ), PLUGIN_PREFIX_UPPER_VERSION );
	}

	/**
	 * Get Singleton Instance.
	 *
	 * @since  1.0.0
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * PLUGIN_PREFIX_UPPER_Options constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->options = $this->get_options();

		// Used to save at last possible chance.
		// add_action( 'shutdown', array( $this, 'shutdown_save_options' ) );
	}

	/**
	 * Options Defaults.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return array
	 */
	private function options_defaults() {
		$default = array(
			'version' => PLUGIN_PREFIX_UPPER_VERSION, // Required for Database Update.
		);

		return $default;
	}

	/**
	 * Validates Options
	 *
	 * Stores only the known keys.
	 *
	 * @since  1.0.0
	 *
	 * @param array $options Plugin db options array.
	 * @return array
	 */
	public function validate_options( $options ) {
		$valid_options = $this->options_defaults();

		foreach ( $valid_options as $slug => &$value ) {
			if ( isset( $options[ $slug ] ) ) {
				$value = $options[ $slug ];
			}
		}

		return $valid_options;
	}

	/**
	 * Get Options.
	 *
	 * Gets the Options from WordPress database and returns it. If there is no data,
	 * then set to defaults, save, and return options.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_options() {
		$options = get_option( 'PLUGIN_PREFIX_LOWER_options' );

		if ( false !== $options ) {
			$options = wp_parse_args( $options, $this->options_defaults() );
		} else {
			$options = $this->options_defaults();
			$this->update_options( $options );
		}

		return $options;
	}

	/**
	 * Update Options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $options Plugin db options array.
	 * @param array $args    Function arguments.
	 * @return boolean
	 */
	public function update_options( $options, $args = array() ) {
		// Options.
		if ( empty( $options ) ) {
			$options = $this->options;
		} elseif ( ! is_array( $options ) ) {
			return false;
		}
		$options = $this->validate_options( $options );

		// Args.
		$args_default = array(
			'update_object' => true,
		);
		$args = wp_parse_args( $args, $args_default );

		update_option( 'hsi_options', $options );

		// Keep object in sync with database, unless specified otherwise.
		if ( true === $args['update_object'] ) {
			$this->options = $options;
		}

		return true;
	}

	/**
	 * Shutdown Save.
	 *
	 * Saves settings at the last possible chance.
	 *
	 * @since 1.0.0
	 */
	public function shutdown_save_options() {
		$this->update_options( $this->options );
	}

}
