<?php
/**
 * PLUGIN_PREFIX_UPPER Admin Core Class
 *
 * @package PLUGIN-NICENAME
 * @since 1.0.0
 */

/**
 * Class PLUGIN_PREFIX_UPPER_Admin_Core
 *
 * @since 1.0.0
 */
class PLUGIN_PREFIX_UPPER_Admin_Core {

	/**
	 * Singleton Instance
	 *
	 * @since  1.0
	 * @access private
	 * @var null $instance Singleton Class Instance.
	 */
	protected static $instance = null;

	/**
	 * Throws error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @ignore
	 * @since  1.0.0
	 *
	 * @access private
	 */
	private function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin\' huh?', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ), PLUGIN_PREFIX_UPPER_VERSION );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @ignore
	 * @since  1.0
	 * @access private
	 */
	private function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin\' huh?', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ), PLUGIN_PREFIX_UPPER_VERSION );
	}

	/**
	 * Get Singleton Instance.
	 *
	 * @since  1.0
	 *
	 * @access private
	 * @return object
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * PLUGIN_PREFIX_UPPER_Admin_Core constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// Settings Data.


		if ( defined( 'WP_ADMIN' ) && WP_ADMIN && is_blog_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'admin_menu', array( $this, 'action_admin_menu' ) );

			add_action( 'add_meta_boxes', array( $this, 'menu_page_meta_boxes' ) );
		}
	}

	/**
	 * Admin Enqueue Scripts.
	 *
	 * @since 1.0.0
	 *
	 * @see wp-admin/admin-header.php
	 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
	 *
	 * @param string $hook_suffix The suffix for the current Admin page.
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		wp_deregister_script( 'PLUGIN_PREFIX_LOWER-admin-js' );

		if ( 'toplevel_page_PLUGIN_PREFIX_LOWER_toplevel' === $hook_suffix) {

			wp_register_script(
				'PLUGIN_PREFIX_LOWER-admin-js',
				PLUGIN_PREFIX_UPPER_URL . 'admin/js/admin.js',
				array( 'jquery' ),
				PLUGIN_PREFIX_UPPER_VERSION,
				true
			);

			wp_register_script(
				'PLUGIN_PREFIX_LOWER-admin-ui-js',
				PLUGIN_PREFIX_UPPER_URL . 'admin/js/admin-ui.js',
				array( 'jquery' ),
				PLUGIN_PREFIX_UPPER_VERSION,
				true
			);

			wp_enqueue_script( 'postbox' );
			wp_enqueue_script( 'PLUGIN_PREFIX_LOWER-admin-js' );
			wp_enqueue_script( 'PLUGIN_PREFIX_LOWER-admin-ui-js' );

			// Used with debugging JS to help investigate AJAX where/how in it failed.
			$wp_debug = false;
			if ( defined( 'WP_DEBUG' ) ) {
				$wp_debug = (boolean) WP_DEBUG;
			}
			$PLUGIN_PREFIX_LOWER_admin_localize = array(
				'wpDebug'   => $wp_debug,
				'nonceAJAX' => wp_create_nonce( 'PLUGIN_PREFIX_LOWER-admin' ),
			);
			wp_localize_script( 'PLUGIN_PREFIX_LOWER-admin-js', 'PLUGIN_PREFIX_LOWER_admin_obj', $PLUGIN_PREFIX_LOWER_admin_localize );

			wp_enqueue_style(
				'PLUGIN_PREFIX_LOWER-admin-css',
				PLUGIN_PREFIX_UPPER_URL . 'admin/css/admin.css',
				false,
				PLUGIN_PREFIX_UPPER_VERSION,
				false
			);

			$screen_args = array(
				'max'     => 2,
				'default' => 2,
			);
			add_screen_option( 'layout_columns', $screen_args );

			global $post_type;
			do_action( 'add_meta_boxes', $hook_suffix, $post_type );
		}
	}
	
	/**
	 * Admin Menu.
	 *
	 * @since 1.0.0
	 *
	 * @uses hook 'admin_menu'
	 * @see wp-admin/admin-header.php
	 * @link https://developer.wordpress.org/reference/functions/add_menu_page/
	 */
	public function action_admin_menu() {
		add_menu_page(
			__( 'PLUGIN_NAME Page Title', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ),
			__( 'PLUGIN_NAME', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ),
			'administrator',
			'PLUGIN_PREFIX_LOWER_toplevel',
			array( $this, 'cb_toplevel_page' ), // Callback function if toplevel is added.
			'dashicons-lightbulb',
			58
		);
	}

	/**
	 * Settings Page (Callback).
	 *
	 * @since 1.0.0
	 */
	public function cb_toplevel_page() {
		PLUGIN_PREFIX_LOWER_get_template( 'admin/toplevel-page.php' );
	}

	/**
	 * Admin/Menu Page Meta Boxes.
	 *
	 * @since 1.0.0
	 *
	 * @uses hook 'add_meta_boxes'.
	 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
	 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
	 */
	public function menu_page_meta_boxes() {
		add_meta_box(
			'PLUGIN_PREFIX_LOWER-side',
			__( 'Side', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ),
			array( $this, 'cb_toplevel_meta_box_side' ),
			'toplevel_page_PLUGIN_PREFIX_LOWER_toplevel',
			// 'normal', 'advanced', 'side'.
			'side',
			// 'high', 'sorted', 'core', 'default', 'low'.
			'core'
		);
		add_meta_box(
			'PLUGIN_PREFIX_LOWER-normal',
			__( 'Normal', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ),
			array( $this, 'cb_toplevel_meta_box_normal' ),
			'toplevel_page_PLUGIN_PREFIX_LOWER_toplevel',
			'normal',
			'high'
		);
		add_meta_box(
			'PLUGIN_PREFIX_LOWER-advanced',
			__( 'Advanced', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ),
			array( $this, 'cb_toplevel_meta_box_advanced' ),
			'toplevel_page_PLUGIN_PREFIX_LOWER_toplevel',
			'advanced',
			'core'
		);
	}

	/**
	 * Side Meta Box.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post    Current WP_Post object.
	 * @param array   $metabox With Meta Box id, title, callback, and args elements.
	 */
	public function cb_toplevel_meta_box_side( $post, $metabox ) {
		$args = array(
			'post'    => $post,
			'metabox' => $metabox,
		);

		PLUGIN_PREFIX_LOWER_get_template( 'admin/meta-box/toplevel-side.php', $args );
	}

	/**
	 * Normal Meta Box.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post    Current WP_Post object.
	 * @param array   $metabox With Meta Box id, title, callback, and args elements.
	 */
	public function cb_toplevel_meta_box_normal( $post, $metabox ) {
		$args = array(
			'post'    => $post,
			'metabox' => $metabox,
		);

		PLUGIN_PREFIX_LOWER_get_template( 'admin/meta-box/toplevel-normal.php', $args );
	}

	/**
	 * Advanced Meta Box.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post    Current WP_Post object.
	 * @param array   $metabox With Meta Box id, title, callback, and args elements.
	 */
	public function cb_toplevel_meta_box_advanced( $post, $metabox ) {
		$args = array(
			'post'    => $post,
			'metabox' => $metabox,
		);

		PLUGIN_PREFIX_LOWER_get_template( 'admin/meta-box/toplevel-advanced.php', $args );
	}

}
