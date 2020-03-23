<?php
/*
Plugin Name: PLUGIN_NAME
Description: Plugin Boilerplate.
Version: 1.0.0
Author: EkoJR
License: GPLv2
License: URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: PLUGIN-NICENAME
Domain Path: /languages
 */

// Define Constants.
if (
		! defined( 'PLUGIN_PREFIX_UPPER_PLUGIN_BASENAME' ) &&
		! defined( 'PLUGIN_PREFIX_UPPER_VERSION' ) &&
		! defined( 'PLUGIN_PREFIX_UPPER_PLUGIN_NAME' ) &&
		! defined( 'PLUGIN_PREFIX_TEXTDOMAIN' )
) {
	// PHP < 5.2 compatibility for __DIR__.
	// Avoid using `plugin_basename()` with situations that don't store the plugin directory in `WP_PLUGIN_DIR`; ex. unit testing with Tracis CI.
	$directory        = dirname( __FILE__ );
	$root_dir         = wp_normalize_path( str_replace( basename( $directory ), '', $directory ) );
	$plugin_basename  = wp_normalize_path( str_replace( str_replace( basename( $directory ), '', $directory ), '', __FILE__ ) );
	$plugin_dir       = $root_dir . $plugin_basename;

	// Use get_file_data with this file, and get the plugin's file data with default_headers.
	$default_headers = array(
		'Name'       => 'Plugin Name',
		'Version'    => 'Version',
		'TextDomain' => 'Text Domain',
		'DomainPath' => 'Domain Path',
	);

	$plugin_data = get_file_data( $plugin_dir, $default_headers );

	/**
	 * Plugin Basename.
	 *
	 * @since 1.0.0
	 *
	 * @var string PLUGIN_PREFIX_UPPER_PLUGIN_BASENAME Plugin basename on WP platform. Eg. 'PLUGIN-NICENAME/PLUGIN-NICENAME.php`.
	 */
	define( 'PLUGIN_PREFIX_UPPER_PLUGIN_BASENAME', $plugin_basename );

	/**
	 * Plugin Version Number
	 *
	 * @since 1.0.0
	 *
	 * @var string $PLUGIN_PREFIX_UPPER_VERSION Contains the plugin's version number. Eg. '1.2.3'
	 */
	define( 'PLUGIN_PREFIX_UPPER_VERSION', $plugin_data['Version'] );

	/**
	 * Plugin Display Name
	 *
	 * @since 1.0.0
	 *
	 * @var string $PLUGIN_PREFIX_UPPER_DISPLAY_NAME Contains 'PLUGIN_NAME'.
	 */
	define( 'PLUGIN_PREFIX_UPPER_DISPLAY_NAME', $plugin_data['Name'] );

	/**
	 * Plugin's Text Domain
	 *
	 * @since 1.0.0
	 *
	 * @var string $PLUGIN_PREFIX_UPPER_TEXTDOMAIN Stores the TextDomain to be used with localizations.
	 */
	define( 'PLUGIN_PREFIX_UPPER_TEXTDOMAIN', $plugin_data['TextDomain'] );

	if ( ! defined( 'PLUGIN_PREFIX_UPPER_DOMAIN_PATH' ) ) {

		/**
		 * Plugin's Text Domain Path
		 *
		 * @since 1.0.0
		 *
		 * @var string $PLUGIN_PREFIX_UPPER_DOMAIN_PATH Directory for storing languages.
		 */
		define( 'PLUGIN_PREFIX_UPPER_DOMAIN_PATH', $plugin_data['DomainPath'] );
	}

	if ( ! defined( 'PLUGIN_PREFIX_UPPER_DIR' ) ) {

		/**
		 * Plugin's directory
		 *
		 * @since 1.0.0
		 *
		 * @var string $PLUGIN_PREFIX_UPPER_DIR Plugin's root directory.
		 */
		define( 'PLUGIN_PREFIX_UPPER_DIR', plugin_dir_path( $plugin_dir ) );
	}

	if ( ! defined( 'PLUGIN_PREFIX_UPPER_URL' ) ) {

		/**
		 * Plugin's URL
		 *
		 * @since 1.0.0
		 *
		 * @var string $PLUGIN_PREFIX_UPPER_URL Plugin's URL location.
		 */
		define( 'PLUGIN_PREFIX_UPPER_URL', plugin_dir_url( $plugin_dir ) );
	}

	if ( ! defined( 'PLUGIN_PREFIX_UPPER_LOG_FILEPATH' ) ) {

		/**
		 * Plugin's Log Filepath.
		 *
		 * Used with PHP's `error_log()`.
		 *
		 * @since 1.0.0
		 *
		 * @var string $PLUGIN_PREFIX_UPPER_LOG_FILEPATH Plugin's URL location.
		 */
		define( 'PLUGIN_PREFIX_UPPER_LOG_FILEPATH', WP_CONTENT_DIR . '/debug-PLUGIN-NICENAME.log' );
	}
}

// Initialize Plugin (Single instance).
require_once plugin_dir_path( __FILE__ ) . 'class-PLUGIN_PREFIX_LOWER-core.php';
global $PLUGIN_PREFIX_LOWER_core;

if ( is_null( $PLUGIN_PREFIX_LOWER_core ) ) {
	$PLUGIN_PREFIX_LOWER_core = new PLUGIN_PREFIX_UPPER_Core();
}
