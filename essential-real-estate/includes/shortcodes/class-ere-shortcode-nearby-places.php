<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_NearBy_Places')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_NearBy_Places
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
            wp_enqueue_script(ERE_PLUGIN_PREFIX . 'nearby-places');
			return ere_get_template_html('shortcodes/nearby-places/nearby-places.php', array('atts' => $atts));
		}
	}
}