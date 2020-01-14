<?php
/**
 * Advanced Metabox
 *
 * @package PLUGIN_NICENAME
 * @package PLUGIN_NICENAME\PLUGIN_PREFIX_UPPER_Admin_Core
 * @since 1.0.0
 */
?>

<form id="PLUGIN_PREFIX_LOWER-admin-form" method="post" action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>" >
	<input type="hidden" name="action" value="PLUGIN_PREFIX_LOWER_toplevel_advanced">

	<div class="PLUGIN_PREFIX_LOWER-row">
		<div class="PLUGIN_PREFIX_LOWER-row-first-cell">
			<label>Checkbox:</label>
		</div>
		<div>
			<input type="checkbox" id="PLUGIN_PREFIX_LOWER_checkbox" name="PLUGIN_PREFIX_LOWER_checkbox" />
			<label for="PLUGIN_PREFIX_LOWER_checkbox" >On/Off</label>
		</div>
	</div>
	<?php submit_button( __( 'Save' ), 'primary', 'PLUGIN_PREFIX_LOWER_save', false ); ?>
</form>
