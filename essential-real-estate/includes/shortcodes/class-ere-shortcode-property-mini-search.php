<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_Property_Mini_Search')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_Property_Mini_Search
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
            wp_enqueue_script(ERE_PLUGIN_PREFIX . 'mini_search_js');
			return ere_get_template_html('shortcodes/property-mini-search/property-mini-search.php', array('atts' => $atts));
		}
	}
}