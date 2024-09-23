<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if ( ! class_exists( 'ERE_MAP' ) ) {
    class ERE_MAP {
        private static $_instance;

        public static function get_instance() {
            if ( self::$_instance == null ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init() {
            $this->google()->init();
            add_action( 'wp_footer', array( $this, 'include_templates' ) );
        }

        public function google() {
            require_once ERE_PLUGIN_DIR . 'includes/map/google.php';
            return ERE_MAP_GOOGLE::get_instance();
        }

        public function include_templates() {
            ere_get_template( 'map/marker.php' );
            ere_get_template( 'map/popup.php' );
        }

        public function get_marker() {
            $map_icon_default = ERE_PLUGIN_URL . 'public/assets/images/map-marker-icon.png';
            $marker_icon = ere_get_option( 'marker_icon' );
            if ( is_array( $marker_icon ) && isset( $marker_icon['url'] ) && ! empty( $marker_icon['url'] ) ) {
                $map_icon_default = $marker_icon['url'];
            }
            $marker_html = sprintf( '<img src="%s" />', esc_url( $map_icon_default ) );
            return array(
                'type' => 'image',
                'html' => $marker_html
            );
        }


    }

    ERE_MAP::get_instance()->init();
}