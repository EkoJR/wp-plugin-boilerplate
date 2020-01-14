<?php
/**
 * Toplevel Page
 *
 * Content displayed when the Settings Submenu Callback is executed.
 *
 * @link https://github.com
 *
 * @package PLUGIN_NICENAME
 * @package PLUGIN_NICENAME\PLUGIN_PREFIX_UPPER_Admin_Core
 * @since 0.4.0
 */

global $hook_suffix;

?>
<div class="wrap" >
	<h2><?php esc_html_e( 'TopLevel Page', PLUGIN_PREFIX_UPPER_TEXTDOMAIN ); ?></h2>
	<?php settings_errors(); ?>
	<div id="PLUGIN_PREFIX_LOWER-toplevel-form" >
		<?php
		// Used to save closed meta boxes and their order.
		wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
		wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
		// Group name from register_settings.
		settings_fields( 'PLUGIN_PREFIX_LOWER_toplevel' );
		?>
		<div id="poststuff" >
			<div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>" >
				<div id="post-body-content" >
					<?php do_meta_boxes( $hook_suffix, 'normal', null ); ?>
				</div>
				<div id="postbox-container-1" class="postbox-container" >
					<?php do_meta_boxes( $hook_suffix, 'side', null ); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container" >
					<?php do_meta_boxes( $hook_suffix, 'advanced', null ); ?>
				</div>
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div>
	<!--</form>-->
</div><!-- .wrap -->
