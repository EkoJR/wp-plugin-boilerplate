<?php
/**
 * Initial/Core operations with WP.
 *
 * May contain public operations.
 *
 * @package PLUGIN-NICENAME
 */

/**
 * Class PLUGIN_PREFIX_UPPER_Core
 *
 * @since 1.0.0
 */
class PLUGIN_PREFIX_UPPER_Core {

	/**
	 * PLUGIN_PREFIX_UPPER_Core constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'action_init' ), 3 );
	}

	/**
	 * Required files.
	 *
	 * Adds files via include/require_once.
	 *
	 * @since 1.0.0
	 */
	private function _requires() {
		require_once PLUGIN_PREFIX_UPPER_DIR . 'includes/functions.php';
		require_once PLUGIN_PREFIX_UPPER_DIR . 'includes/template.php';

		if ( current_user_can( 'administrator' ) ) {
			require_once PLUGIN_PREFIX_UPPER_DIR . 'admin/class-PLUGIN_PREFIX_LOWER-admin-core.php';
		}
	}

	/**
	 * Initialize plugin's core.
	 *
	 * @since 1.0.0
	 */
	public function action_init() {
		$this->_requires();

		add_action( 'plugins_loaded', array( $this, 'action_load_plugin_textdomain' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'action_enqueue_scripts') );

		if ( current_user_can( 'administrator' ) ) {
			add_action( 'init', array( 'PLUGIN_PREFIX_UPPER_Admin_Core', 'get_instance' ) );
		}
	}

	/**
	 * Load Textdomain
	 *
	 * Hook for loading the textdomain directory path/location.
	 *
	 * @since 1.0.0
	 *
	 * @link https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/
	 */
	public function action_load_plugin_textdomain() {
		$lang_dir = PLUGIN_PREFIX_UPPER_PLUGIN_BASENAME . PLUGIN_PREFIX_UPPER_DOMAIN_PATH. '/';
		load_plugin_textdomain( PLUGIN_PREFIX_UPPER_TEXTDOMAIN, false, $lang_dir );
	}

	/**
	 * Enqueue Scripts & Styles on Frontend.
	 *
	 * @since 1.0.0
	 */
	public function action_enqueue_scripts() {
		global $post;

		wp_deregister_script( 'PLUGIN_PREFIX_LOWER-public' );

		wp_register_script(
			'PLUGIN_PREFIX_LOWER-public',
			PLUGIN_PREFIX_UPPER_URL . 'public/js/public.js',
			array( 'jquery' ),
			PLUGIN_PREFIX_UPPER_VERSION,
			false
		);

		wp_enqueue_script( 'PLUGIN_PREFIX_LOWER-public' );

		// Used with debugging JS to help investigate AJAX where/how in it failed.
		$wp_debug = false;
		if ( defined( 'WP_DEBUG' ) ) {
			$wp_debug = (boolean) WP_DEBUG;
		}

		// wpDebug:   Help to troubleshoot and debug issues.
		// ajaxurl:   Frontend doesn't include ajaxurl variable.
		// nonceAJAX: Security for frontend AJAX endpoints.
		$localize_data = array(
			'wpDebug'   => $wp_debug,
			'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			'nonceAJAX' => wp_create_nonce( 'PLUGIN_PREFIX_LOWER-public' ),
		);
		wp_localize_script( 'PLUGIN_PREFIX_LOWER-public', 'PLUGIN_PREFIX_LOWER_public_obj', $localize_data );
	}


}


