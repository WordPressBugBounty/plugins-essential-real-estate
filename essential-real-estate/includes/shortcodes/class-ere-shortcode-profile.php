<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if (!class_exists('ERE_Shortcode_Profile')) {
    class ERE_Shortcode_Profile
    {
        /**
         * Output the cart shortcode.
         *
         * @param array $atts
         */
        public static function output($atts)
        {
            if (is_admin() && !wp_doing_ajax()) {
                return '';
            }
            return ere_get_template_html('account/my-profile.php', array('atts' => $atts));
        }
    }
}