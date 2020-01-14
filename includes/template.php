<?php

if ( 'PLUGIN_PREFIX_LOWER_locate_template' ) {
	/**
	 * Locate a template and return the path for inclusion.
	 *
	 * This is the load order:
	 *
	 * yourtheme/$template_path/$template_name
	 * yourtheme/$template_name
	 * $default_path/$template_name
	 *
	 * @since 1.0.0
	 *
	 * @param string $template_name Template name.
	 * @param string $template_path Template path. (default: '').
	 * @param string $default_path  Default path. (default: '').
	 * @return string
	 */
	function PLUGIN_PREFIX_LOWER_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path ) {
			$template_path = 'PLUGIN-NICENAME/';
		}

		if ( ! $default_path ) {
			$default_path = PLUGIN_PREFIX_UPPER_DIR . 'templates/';
		}

		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);

		// Default template.
		if ( ! $template || PLUGIN_PREFIX_UPPER_TEMPLATE_DEBUG_MODE ) {
			$template = $default_path . $template_name;
		}

		// Return what we found.
		return apply_filters( 'PLUGIN_PREFIX_LOWER_locate_template', $template, $template_name, $template_path );
	}
}

if ( ! function_exists( 'PLUGIN_PREFIX_LOWER_get_template' ) ) {
	/**
	 * PLUGIN_PREFIX_UPPER Get Template
	 *
	 * @since 1.0.0
	 *
	 * @param string $template_name
	 * @param array  $args
	 * @param string $template_path
	 * @param string $default_path
	 */
	function PLUGIN_PREFIX_LOWER_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		// EXTRACT.
		foreach ( $args as $arg_key => $arg_value ) {
			if ( ! is_numeric( $arg_key ) ) {
				$$arg_key = $arg_value;
			} else {
				$arg_key  = 'arg_' . $arg_key;
				$$arg_key = $arg_value;
			}
		}

		$dir = PLUGIN_PREFIX_LOWER_locate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $dir ) ) {
			/* translators: %s template name */
			_doing_it_wrong( __FUNCTION__, sprintf( __( 'Template %s does not exist.', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ), '<code>' . $dir . '</code>' ), PLUGIN_PREFIX_UPPER_VERSION );
			return;
		}

		// Allow 3rd party plugin filter template file from their plugin.
		$dir = apply_filters( 'PLUGIN_PREFIX_LOWER_get_template', $dir, $template_name, $args, $template_path, $default_path );

		do_action( 'PLUGIN_PREFIX_LOWER_before_template_part', $template_name, $template_path, $dir, $args );

		include $dir;

		do_action( 'PLUGIN_PREFIX_LOWER_after_template_part', $template_name, $template_path, $dir, $args );
	}
}

if ( 'PLUGIN_PREFIX_LOWER_get_template_part' ) {
	/**
	 * Get template part.
	 *
	 * PLUGIN_PREFIX_UPPER_TEMPLATE_DEBUG_MODE will prevent overrides in themes from taking priority.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed  $slug Template slug.
	 * @param string $name Template name (default: '').
	 * @param array $args
	 */
	function PLUGIN_PREFIX_LOWER_get_template_part( $slug, $name = '', $args = array() ) {
		$template = '';
		$slug_name = $slug . '-' . $name . '.php';

		// EXTRACT.
		//extract( $args );
		foreach ( $args as $arg_key => $arg_value ) {
			if ( ! is_numeric( $arg_key ) ) {
				$$arg_key = $arg_value;
			} else {
				$arg_key  = 'arg_' . $arg_key;
				$$arg_key = $arg_value;
			}
		}


		// Look in yourtheme/slug-name.php and yourtheme/PLUGIN-NICENAME/slug-name.php.
		if ( $name && ! PLUGIN_PREFIX_UPPER_TEMPLATE_DEBUG_MODE ) {
			$template = locate_template(
				array(
					$slug_name,
					'PLUGIN-NICENAME/' . $slug_name,
				)
			);
		}

		// Get default slug-name.php.
		if ( ! $template && $name && file_exists( PLUGIN_PREFIX_UPPER_DIR . '/templates/' . $slug_name ) ) {
			$template = PLUGIN_PREFIX_UPPER_DIR . '/templates/' . $slug_name;
		}

		// If template file doesn't exist, use slug.
		// Look in yourtheme/slug.php and yourtheme/PLUGIN-NICENAME/slug.php.
		if ( ! $template && ! PLUGIN_PREFIX_UPPER_TEMPLATE_DEBUG_MODE ) {
			$template = locate_template( array( $slug . '.php', 'PLUGIN-NICENAME/' . $slug . '.php' ) );
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters( 'PLUGIN_PREFIX_LOWER_get_template_part', $template, $slug, $name );

		if ( $template ) {
			include $template;
		}
	}
}
