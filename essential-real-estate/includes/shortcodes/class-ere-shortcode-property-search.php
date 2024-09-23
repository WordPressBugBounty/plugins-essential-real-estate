<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_Property_Search')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_Property_Search
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
			$search_styles = isset($atts['search_styles']) ? $atts['search_styles'] : 'style-default';
			$map_search_enable = isset($atts['map_search_enable']) ? $atts['map_search_enable'] : '';

			if ($search_styles === 'style-vertical' || $search_styles === 'style-absolute') {
				$map_search_enable='true';
			}

			if ($map_search_enable == 'true') {
				wp_enqueue_script(ERE_PLUGIN_PREFIX . 'search_js_map');
			} else {
				wp_enqueue_script(ERE_PLUGIN_PREFIX . 'search_js');
			}
			return ere_get_template_html('shortcodes/property-search/property-search.php', array('atts' => $atts));
		}
	}
}