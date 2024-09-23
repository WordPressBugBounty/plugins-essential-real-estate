<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_Property_Search_Map')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_Property_Search_Map
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
			wp_enqueue_script(ERE_PLUGIN_PREFIX . 'search_map');
			return ere_get_template_html('shortcodes/property-search-map/property-search-map.php', array('atts' => $atts));
		}
	}
}