<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('ERE_MAP_GOOGLE')) {
    class ERE_MAP_GOOGLE {
        private static $_instance;

        public static function get_instance() {
            if ( self::$_instance == null ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        private $cluster_marker_enable;

        public function init() {
            add_action('init',array($this,'register_assets'),7);
            add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'),1);
        }
        public function register_assets() {
            $api_key = ere_get_option('googlemap_api_key', 'AIzaSyBqmFdSPp4-iY_BG14j_eUeLwOn9Oj4a4Q');
            $ssl_enable = ere_get_option('googlemap_ssl', 0);
            $ssl_enable = filter_var($ssl_enable,FILTER_VALIDATE_BOOLEAN) ;
            $this->cluster_marker_enable = ere_get_option('googlemap_pin_cluster', 1);
            $this->cluster_marker_enable = filter_var($this->cluster_marker_enable,FILTER_VALIDATE_BOOLEAN) ;
            $zoom = absint(ere_get_option('googlemap_zoom_level', 12)) ;
            $skin = ere_get_option('googlemap_skin','');
            $skin_custom = ere_get_option('googlemap_style', '');
            $feature_types = ere_get_option('googlemap_autocomplete_types','geocode');
            $countries = ere_get_option('default_country', 'US');
            $args = [];
            $args['key'] = $api_key;
            $args['libraries'] = 'places';
            $args['language'] = get_locale();
            $args['v'] = 3;
            // Load Google Maps.
            if ($ssl_enable) {
                wp_register_script( 'google-map', sprintf( 'https://maps.googleapis.com/maps/api/js?%s', http_build_query( $args ) ),array(), null, true );
            } else {
                wp_register_script( 'google-map', sprintf( 'http://maps.googleapis.com/maps/api/js?%s', http_build_query( $args ) ),array(), null, true );
            }

            if ($this->cluster_marker_enable) {
                wp_register_script('markerclusterer',ERE_PLUGIN_URL. 'public/assets/vendors/markerclusterer/markerclusterer.min.js', array('jquery','google-map'), '2.1.11', true);
            }

            wp_register_script('infobox', ERE_PLUGIN_URL. 'public/assets/vendors/infobox/infobox.min.js', array('google-map'), '1.1.19', true);
            $js_min_suffix = ere_get_option('enable_min_js', 0) == 1 ? '.min' : '';
            $css_min_suffix = ere_get_option('enable_min_css', 0) == 1 ? '.min' : '';
            wp_register_script(ERE_PLUGIN_PREFIX .  'map', ERE_PLUGIN_URL. 'public/assets/map/js/google-map' . $js_min_suffix . '.js', array('jquery'), ERE_PLUGIN_VER, true);
            wp_register_style(ERE_PLUGIN_PREFIX .  'map',  ERE_PLUGIN_URL. 'public/assets/map/css/google-map' . $css_min_suffix . '.css', array(), ERE_PLUGIN_VER);


            $map_directions_distance_units = ere_get_option('map_directions_distance_units', 'metre');

            wp_localize_script(ERE_PLUGIN_PREFIX .  'map','ere_map_vars',array(
                'zoom' => $zoom,
                'cluster_marker_enable' => $this->cluster_marker_enable,
                'marker' => ERE_MAP::get_instance()->get_marker(),
                'skin' => $skin,
                'skin_custom' => $skin_custom,
                'types' => $feature_types,
                'countries' => $countries,
                'units' => $map_directions_distance_units,
                'api_key' => $api_key
            ));
        }

        public function enqueue_assets() {
            wp_enqueue_script('google-map');
            if (filter_var($this->cluster_marker_enable , FILTER_VALIDATE_BOOLEAN)) {
                wp_enqueue_script('markerclusterer');
            }
            wp_enqueue_script('infobox');

            // Load Maps assets.
            wp_enqueue_script(ERE_PLUGIN_PREFIX .  'map');
            wp_enqueue_style(ERE_PLUGIN_PREFIX .  'map');
        }
    }
}