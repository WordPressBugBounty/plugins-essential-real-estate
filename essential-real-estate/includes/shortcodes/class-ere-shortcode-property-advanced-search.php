<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_Property_Advanced_Search')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_Property_Advanced_Search
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
			wp_enqueue_script(ERE_PLUGIN_PREFIX . 'advanced_search_js');
			return ere_get_template_html('shortcodes/property-advanced-search/property-advanced-search.php', array('atts' => $atts));
		}
	}
}