<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('ERE_Shortcode_Property_Slider')) {
	/**
	 * Class ERE_Shortcode_Package
	 */
	class ERE_Shortcode_Property_Slider
	{
		/**
		 * Package shortcode
		 */
		public static function output( $atts )
		{
            wp_enqueue_script(ERE_PLUGIN_PREFIX . 'owl_carousel');
			return ere_get_template_html('shortcodes/property-slider/property-slider.php', array('atts' => $atts));
		}
	}
}