/**
 * Admin UI JavaScript
 *
 * @summary     Admin JavaScript / jQuery for UI design and conditional logic.
 *
 * @since       1.0.0
 * @package     PLUGIN_PREFIX_UPPER_Admin_Core
 * @requires    jQuery
 */

( function($) {
	/**
	 * WordPress MetaBox Workaround (toggle)
	 */
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	postboxes.add_postbox_toggles( pagenow );
})(jQuery);
