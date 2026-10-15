<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('ERE_Save_Search')) {
    /**
     * Class ERE_Search
     */
    class ERE_Save_Search
    {
	    /*
		 * loader instances
		 */
	    private static $_instance;

	    public static function getInstance()
	    {
		    if (self::$_instance == null) {
			    self::$_instance = new self();
		    }

		    return self::$_instance;
	    }

        public static function create_table_save_search()
        {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name         = $wpdb->prefix . 'ere_save_search';
            $sql = "CREATE TABLE $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
              title longtext DEFAULT '' NOT NULL,
              params longtext DEFAULT '' NOT NULL,
			  user_id mediumint(9) NOT NULL,
			  email longtext DEFAULT '' NOT NULL,
			  url longtext DEFAULT '' NOT NULL,
			  query longtext NOT NULL,
			  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  PRIMARY KEY  (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        function save_search_ajax() {

            $nonce = isset($_REQUEST['ere_save_search_ajax']) ? ere_clean(wp_unslash($_REQUEST['ere_save_search_ajax'])) : '';
            if( !wp_verify_nonce( $nonce, 'ere_save_search_nonce_field' ) ) {
                echo wp_json_encode(array(
                    'success' => false,
                    'message' => esc_html__("Permission error!", 'essential-real-estate'),
                ));
                wp_die();
            }
            global $wpdb, $current_user;
            wp_get_current_user();
            $query  =  isset($_REQUEST['ere_query']) ? ere_clean(wp_unslash($_REQUEST['ere_query'])) : '';
            // Never store client-supplied serialized data (PHP Object Injection). Accept JSON only.
            $search_query = self::decode_query($query);
            if (!is_array($search_query)) {
                echo wp_json_encode(array(
                    'success' => false,
                    'message' => esc_html__("Invalid search query!", 'essential-real-estate'),
                ));
                wp_die();
            }
            $query = base64_encode(wp_json_encode($search_query));
            $table_name         =$wpdb->prefix . 'ere_save_search';
            $url  = isset($_REQUEST['ere_url']) ? sanitize_url(wp_unslash($_REQUEST['ere_url'])) : '';
            $title  = isset($_REQUEST['ere_title']) ?  ere_clean(wp_unslash($_REQUEST['ere_title'])) : '';
            $params  = isset($_REQUEST['ere_params']) ?  ere_clean(wp_unslash($_REQUEST['ere_params'])) : '';
            $wpdb->insert(
                $table_name,
                array(
                    'title'     => $title,
                    'params'    => $params,
                    'user_id'   => $current_user->ID,
                    'email'     => $current_user->user_email,
                    'url'       => $url,
                    'query'     => $query,
                    'time'      => current_time( 'mysql' ),
                ),
                array(
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                )
            );

            echo wp_json_encode( array( 'success' => true, 'msg' => esc_html__('Save successfully', 'essential-real-estate') ) );
            wp_die();
        }
        /**
         * Decode a stored/submitted search query without instantiating any PHP objects.
         * Supports the JSON format and legacy serialized rows (objects disallowed).
         *
         * @param string $data base64 encoded query
         * @return array|null
         */
        public static function decode_query($data)
        {
            $decoded = base64_decode((string)$data, true);
            if (!is_string($decoded) || $decoded === '') {
                return null;
            }
            $search_query = json_decode($decoded, true);
            if (!is_array($search_query) && is_serialized($decoded)) {
                $search_query = @unserialize($decoded, array('allowed_classes' => false));
            }
            if (!is_array($search_query) || self::contains_object($search_query)) {
                return null;
            }
            return $search_query;
        }

        private static function contains_object($value)
        {
            if (is_object($value)) {
                return true;
            }
            if (is_array($value)) {
                foreach ($value as $item) {
                    if (self::contains_object($item)) {
                        return true;
                    }
                }
            }
            return false;
        }

        public function get_total_save_search(){
            $user_id = get_current_user_id();
            global $wpdb;
            $results       = $wpdb->get_results( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}ere_save_search WHERE user_id = %d", $user_id), OBJECT );
            return count($results);
        }
    }
}