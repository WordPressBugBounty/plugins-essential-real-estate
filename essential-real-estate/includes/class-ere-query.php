<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'ERE_Query' ) ) {
	class ERE_Query {
		private static $_instance;
		private $parameters = [];

		private $_atts = [];

		private $_query_args = [];

		public static function get_instance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			// meta query
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_address' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_bathroom' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_bedroom' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_room' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_garage' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_price' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_area' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_land_area' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_country' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_identity' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_featured' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_custom_fields' ) );
			add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_user' ) );
            add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_property_search_ajax' ) );
            add_filter( 'ere_property_query_meta_query', array( $this, 'get_meta_query_advanced_search' ) );

			// tax query
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_type' ) );
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_status' ) );
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_label' ) );
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_city' ) );
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_state' ) );
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_neighborhood' ) );
			add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_feature' ) );
            add_filter( 'ere_property_query_tax_query', array( $this, 'get_tax_query_property_search_ajax' ) );

		}

		public function reset_parameter() {
			$this->parameters = [];
		}

		public function set_parameter( $parameter ) {
			$this->parameters[] = $parameter;
		}

		public function get_parameters() {
			return $this->parameters;
		}

		public function set_atts($atts = array()) {
			$this->_atts = wp_parse_args($atts, array(
				'keyword' => '',
				'title' => '',
				'address' => '',
				'type' => '',
				'city' => '',
				'status' => '',
				'bathrooms' => '',
				'bedrooms' => '',
				'rooms' => '',
				'min-area' => '',
				'max-area' => '',
				'min-price' => '',
				'max-price' => '',
				'state' => '',
				'country' => '',
				'neighborhood' => '',
				'label' => '',
				'garage' => '',
				'min-land-area' => '',
				'max-land-area' => '',
				'property_identity' => '',
				'features' => '',
				'item_amount' => '',
				'paged' => 1,
				'sortby' => '',
				'user_id' => '',
				'author_id' => '',
				'agent_id' => '',
				'featured' => FALSE
			));
		}

		public function get_property_query_args($atts = array(), $query_args = array()) {
			$this->reset_parameter();
			$this->set_atts($atts);
			$item_amount = isset($_REQUEST['item_amount']) ? ere_clean(wp_unslash($_REQUEST['item_amount'])) : $this->_atts['item_amount'];
			$paged   =  get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : (get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : $this->_atts['paged']);
			$sortby = isset( $_REQUEST['sortby'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['sortby'] ) ) : $this->_atts['sortby'];

			$this->_query_args = wp_parse_args($query_args,[
				'post_type'      => 'property',
				'posts_per_page' => ($item_amount > 0) ? $item_amount : -1,
				'paged' => $paged,
				'post_status'    => 'publish',
				'orderby'        => [
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				],
			]);

			if (in_array($sortby,['a_price','d_price','a_date','d_date','featured','most_viewed'])) {
				if ( $sortby == 'a_price' ) {
					$this->_query_args['orderby']  = 'meta_value_num';
					$this->_query_args['meta_key'] = ERE_METABOX_PREFIX . 'property_price';
					$this->_query_args['order']    = 'ASC';
				} else if ( $sortby == 'd_price' ) {
					$this->_query_args['orderby']  = 'meta_value_num';
					$this->_query_args['meta_key'] = ERE_METABOX_PREFIX . 'property_price';
					$this->_query_args['order']    = 'DESC';
				} else if ( $sortby == 'featured' ) {
					$this->_query_args['ere_orderby_featured'] = TRUE;
				} else if ( $sortby == 'most_viewed' ) {
					$this->_query_args['ere_orderby_viewed'] = TRUE;
				} else if ( $sortby == 'a_date' ) {
					$this->_query_args['orderby'] = 'date';
					$this->_query_args['order']   = 'ASC';
				} else if ( $sortby == 'd_date' ) {
					$this->_query_args['orderby'] = 'date';
					$this->_query_args['order']   = 'DESC';
				}
			} else {
				$featured_toplist = ere_get_option('featured_toplist', 1);
				if($featured_toplist !=0 )
				{
					$this->_query_args['ere_orderby_featured'] = true;
				}
			}

			$meta_query         = $this->get_meta_query();
			$tax_query          = $this->get_tax_query();
			if ( count( $meta_query ) > 1 ) {
				$meta_query['relation'] = 'AND';
			}
			if ( count( $tax_query ) > 1 ) {
				$tax_query['relation'] = 'AND';
			}

			$keyword = isset($_REQUEST['keyword']) ? ere_clean(wp_unslash($_REQUEST['keyword']))  : $this->_atts['keyword'];
			$keyword_meta_query = $keyword_tax_query = '';
			if ( ! empty( $keyword ) ) {
				$keyword_field = ere_get_option( 'keyword_field', 'prop_address' );
				if ( $keyword_field === 'prop_address' ) {
					$keyword_meta_query = $this->get_meta_query_keyword( $keyword );
				} elseif ( $keyword_field === 'prop_city_state_county' ) {
					$keyword_tax_query = $this->get_tax_query_keyword( $keyword );
				} else {
					$this->_query_args['s'] = $keyword;
                    $this->set_parameter( wp_kses_post(sprintf( __( 'Keyword: <strong>%s</strong>', 'essential-real-estate' ), $keyword )));
				}

			}

            $title = isset($_REQUEST['title']) ? ere_clean(wp_unslash($_REQUEST['title']))  : $this->_atts['title'];
            if (!empty($title)) {
                $this->_query_args['s'] = $title;
                /* translators: %s: parameter address */
                $this->set_parameter( wp_kses_post(sprintf( __( 'Title: <strong>%s</strong>', 'essential-real-estate' ), $title )));
            }

			$_meta_query = $this->_query_args['meta_query'] ?? '';
			$this->_query_args['meta_query'] = array(
				'relation' => 'AND'
			);

			if (!empty($meta_query)) {
				$this->_query_args['meta_query'][] = $meta_query;
			}


			if (!empty($keyword_meta_query)) {
				$this->_query_args['meta_query'][] = $keyword_meta_query;
			}

			if (!empty($_meta_query)) {
				$this->_query_args['meta_query'][] = $_meta_query;
			}

			$_tax_query = $this->_query_args['tax_query'] ?? '';
			$this->_query_args['tax_query'] = array(
				'relation' => 'AND'
			);


			if (!empty($tax_query)) {
				$this->_query_args['tax_query'][] = $tax_query;
			}


			if (!empty($keyword_tax_query)) {
				$this->_query_args['tax_query'][] = $keyword_tax_query;
			}

			if (!empty($_tax_query)) {
				$this->_query_args['tax_query'][] = $_tax_query;
			}
			return apply_filters('ere_get_property_query_args',$this->_query_args);
		}

		public function get_meta_query( $meta_query = array() ) {
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}

			return array_filter( apply_filters( 'ere_property_query_meta_query', $meta_query, $this ) );
		}

		public function get_tax_query( $tax_query = array()) {
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array(
					'relation' => 'AND',
				);
			}

			return array_filter( apply_filters( 'ere_property_query_tax_query', $tax_query, $this ) );
		}

		public function get_meta_query_keyword( $keyword ) {
			return [
				'relation' => 'OR',
				[
					'key'     => ERE_METABOX_PREFIX . 'property_address',
					'value'   => $keyword,
					'type'    => 'CHAR',
					'compare' => 'LIKE',
				],
				[
					'key'     => ERE_METABOX_PREFIX . 'property_zip',
					'value'   => $keyword,
					'type'    => 'CHAR',
					'compare' => 'LIKE',
				],
				[
					'key'     => ERE_METABOX_PREFIX . 'property_identity',
					'value'   => $keyword,
					'type'    => 'CHAR',
					'compare' => '=',
				],
			];
		}

		public function get_tax_query_keyword( $keyword ) {
			$taxlocation[] = sanitize_title( $keyword );
			return [
				'relation' => 'OR',
				[
					'taxonomy' => 'property-state',
					'field'    => 'slug',
					'terms'    => $taxlocation,
				],
				[
					'taxonomy' => 'property-city',
					'field'    => 'slug',
					'terms'    => $taxlocation,
				],
				[
					'taxonomy' => 'property-neighborhood',
					'field'    => 'slug',
					'terms'    => $taxlocation,
				],
			];
		}

		public function get_meta_query_address($meta_query) {
			$address = isset($_REQUEST['address']) ? ere_clean(wp_unslash($_REQUEST['address']))  : $this->_atts['address'];
			if (!empty($address)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_address',
					'value' => $address,
					'type' => 'CHAR',
					'compare' => 'LIKE',
				);
                /* translators: %s: parameter address */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Keyword: <strong>%s</strong>', 'essential-real-estate' ), $address )));
			}
			return $meta_query;
		}

		public function get_meta_query_bathroom( $meta_query ) {
			$bathrooms = isset($_REQUEST['bathrooms']) ? ere_clean(wp_unslash($_REQUEST['bathrooms']))  : $this->_atts['bathrooms'];
			if (!empty($bathrooms)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_bathrooms',
					'value' => $bathrooms,
					'type' => 'CHAR',
					'compare' => '=',
				);
                /* translators: %s: parameter bathrooms */
				$this->set_parameter(wp_kses_post(sprintf( __( 'Bathroom: <strong>%s</strong>', 'essential-real-estate' ), $bathrooms )));
			}
			return $meta_query;
		}

		public function get_meta_query_bedroom( $meta_query ) {
			$bedrooms = isset($_REQUEST['bedrooms']) ? ere_clean(wp_unslash($_REQUEST['bedrooms']))  : $this->_atts['bedrooms'];
			if (!empty($bedrooms)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_bedrooms',
					'value' => $bedrooms,
					'type' => 'CHAR',
					'compare' => '=',
				);
                /* translators: %s: parameter bedrooms */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Bedroom: <strong>%s</strong>', 'essential-real-estate' ), $bedrooms )) );
			}
			return $meta_query;
		}

		public function get_meta_query_room( $meta_query ) {
			$rooms = isset($_REQUEST['rooms']) ? ere_clean(wp_unslash($_REQUEST['rooms']))  : $this->_atts['rooms'];
			if (!empty($rooms)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_rooms',
					'value' => $rooms,
					'type' => 'CHAR',
					'compare' => '=',
				);
                /* translators: %s: parameter rooms */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Room: <strong>%s</strong>', 'essential-real-estate' ), $rooms )) );
			}
			return $meta_query;
		}

		public function get_meta_query_garage( $meta_query ) {
			$garage = isset($_REQUEST['garage']) ? ere_clean(wp_unslash($_REQUEST['garage']))  : $this->_atts['garage'];
			if (!empty($garage)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_garage',
					'value' => $garage,
					'type' => 'CHAR',
					'compare' => '=',
				);
                /* translators: %s: parameter garage */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Garage: <strong>%s</strong>', 'essential-real-estate' ), $garage )) );
			}
			return $meta_query;
		}

		public function get_meta_query_price( $meta_query ) {
			$min_price = isset($_REQUEST['min-price']) ? ere_clean(wp_unslash($_REQUEST['min-price']))  : $this->_atts['min-price'];
			$max_price = isset($_REQUEST['max-price']) ? ere_clean(wp_unslash($_REQUEST['max-price']))  : $this->_atts['max-price'];
			$property_price_query_args = $this->get_property_price_query_args($min_price, $max_price);
			if (!empty($property_price_query_args)) {
				$meta_query[] = $property_price_query_args;
			}
			return $meta_query;
		}

		public function get_property_price_query_args($min_price, $max_price){
			$query_args = [];
			if (!empty($min_price) && !empty($max_price)) {
				$min_price = doubleval(ere_clean_double_val($min_price));
				$max_price = doubleval(ere_clean_double_val($max_price));

				if (($min_price >= 0) && ($max_price >= $min_price)) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_price',
						'value'   => [ $min_price, $max_price ],
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					];
                    /* translators: %1$s: min price; %2$s: max price */
					$this->set_parameter( wp_kses_post(sprintf( __( 'Price: <strong>%1$s - %2$s</strong>', 'essential-real-estate' ), $min_price, $max_price )));
				}
			} else if (!empty($min_price)) {
				$min_price = doubleval(ere_clean_double_val($min_price));
				if ($min_price >= 0) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_price',
						'value'   => $min_price,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					];
                    /* translators: %s: parameter min price */
					$this->set_parameter( wp_kses_post(sprintf( __( 'Min Price: <strong>%s</strong>', 'essential-real-estate' ), $min_price )));
				}
			} else if (!empty($max_price)) {
				$max_price = doubleval(ere_clean_double_val($max_price));
				if ($max_price >= 0) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_price',
						'value'   => $max_price,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					];
                    /* translators: %s: parameter max price */
					$this->set_parameter( wp_kses_post(sprintf( __( 'Max Price: <strong>%s</strong>', 'essential-real-estate' ), $max_price )) );
				}
			}
			return $query_args;
		}

		public function get_meta_query_area( $meta_query ) {
			$min_area = isset($_REQUEST['min-area']) ? ere_clean(wp_unslash($_REQUEST['min-area']))  : $this->_atts['min-area'];
			$max_area = isset($_REQUEST['max-area']) ? ere_clean(wp_unslash($_REQUEST['max-area']))  : $this->_atts['max-area'];
			$property_size_query_args = $this->get_property_size_query_args($min_area,$max_area);
			if (!empty($property_size_query_args)) {
				$meta_query[] = $property_size_query_args;
			}
			return $meta_query;
		}

		public function get_property_size_query_args($min_area, $max_area) {
			$query_args = [];
			if (!empty($min_area) && !empty($max_area)) {
				$min_area = intval($min_area);
				$max_area = intval($max_area);

				if (($min_area >= 0)  && ($max_area >= $min_area)) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_size',
						'value'   => [ $min_area, $max_area ],
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					];
                    /* translators: %1$s: min size; %2$s: max size */
					$this->set_parameter( wp_kses_post(sprintf( __( 'Size: <strong>%1$s - %2$s</strong>', 'essential-real-estate' ), $min_area, $max_area )));
				}

			} else if (!empty($max_area)) {
				$max_area = intval($max_area);
				if ($max_area >= 0) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_size',
						'value'   => $max_area,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					];
                    /* translators: %s: parameter max area */
					$this->set_parameter(wp_kses_post(sprintf( __( 'Max Area: <strong> %s</strong>', 'essential-real-estate' ), $max_area ) ));
				}
			} else if (!empty($min_area)) {
				$min_area = intval($min_area);
				if ($min_area >= 0) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_size',
						'value'   => $min_area,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					];
                    /* translators: %s: parameter min area */
					$this->set_parameter(wp_kses_post(sprintf( __( 'Min Area: <strong> %s</strong>', 'essential-real-estate' ), $min_area ) ));
				}
			}
			return $query_args;
		}

		public function get_meta_query_land_area( $meta_query ) {
			$min_land_area = isset($_REQUEST['min-land-area']) ? ere_clean(wp_unslash($_REQUEST['min-land-area']))  : $this->_atts['min-land-area'];
			$max_land_area = isset($_REQUEST['max-land-area']) ? ere_clean(wp_unslash($_REQUEST['max-land-area'])) : $this->_atts['max-land-area'];
			$property_land_size_query_args = $this->get_property_land_size_query_args($min_land_area,$max_land_area);
			if (!empty($property_land_size_query_args)) {
				$meta_query[] = $property_land_size_query_args;
			}
			return $meta_query;
		}

		public function get_property_land_size_query_args($min_land_area, $max_land_area) {
			$query_args = [];
			if (!empty($min_land_area) && !empty($max_land_area)) {
				$min_land_area = intval($min_land_area);
				$max_land_area = intval($max_land_area);

				if (($min_land_area >= 0)  && ($max_land_area >= $min_land_area)) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_land',
						'value'   => [ $min_land_area, $max_land_area ],
						'type'    => 'NUMERIC',
						'compare' => 'BETWEEN',
					];
                    /* translators: %1$s: min land size, %2$s: max land size */
					$this->set_parameter( wp_kses_post(sprintf( __( 'Land size: <strong>%1$s - %2$s</strong>', 'essential-real-estate' ), $min_land_area, $max_land_area )));
				}

			} else if (!empty($max_land_area)) {
				$max_land_area = intval($max_land_area);
				if ($max_land_area >= 0) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_land',
						'value'   => $max_land_area,
						'type'    => 'NUMERIC',
						'compare' => '<=',
					];
                    /* translators: %s: parameter max land size */
					$this->set_parameter( wp_kses_post(sprintf( __( 'Max Land size: <strong>%s</strong>', 'essential-real-estate' ), $max_land_area )));
				}
			} else if (!empty($min_land_area)) {
				$min_land_area = intval($min_land_area);
				if ($min_land_area >= 0) {
					$query_args = [
						'key'     => ERE_METABOX_PREFIX . 'property_land',
						'value'   => $min_land_area,
						'type'    => 'NUMERIC',
						'compare' => '>=',
					];
                    /* translators: %s: parameter min land size */
					$this->set_parameter(wp_kses_post(sprintf( __( 'Min Land size: <strong>%s</strong>', 'essential-real-estate' ), $min_land_area )));
				}
			}
			return $query_args;
		}

		public function get_meta_query_country( $meta_query ) {
			$country = isset($_REQUEST['country']) ? ere_clean(wp_unslash($_REQUEST['country']))  : $this->_atts['country'];
			if (!empty($country)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_country',
					'value' => $country,
					'type' => 'CHAR',
					'compare' => '=',
				);
                /* translators: %s: parameter country */
				$this->set_parameter(wp_kses_post(sprintf( __( 'Country: <strong>%s</strong>', 'essential-real-estate' ), $country ) ));
			}
			return $meta_query;
		}

		public function get_meta_query_identity( $meta_query ) {
			$property_identity = isset($_REQUEST['property_identity']) ? ere_clean(wp_unslash($_REQUEST['property_identity']))  : $this->_atts['property_identity'];
			if ( ! empty( $property_identity ) ) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX. 'property_identity',
					'value' => $property_identity,
					'type' => 'CHAR',
					'compare' => '=',
				);
                /* translators: %s: parameter property identity */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Property identity: <strong>%s</strong>', 'essential-real-estate' ), $property_identity ) ));
			}

			return $meta_query;
		}

		public function get_meta_query_featured( $meta_query ) {
			$property_featured = isset($_REQUEST['featured']) ? ere_clean(wp_unslash($_REQUEST['featured']))  : $this->_atts['featured'];
			if (  filter_var($property_featured, FILTER_VALIDATE_BOOLEAN)) {
				$meta_query[] = array(
					'key' => ERE_METABOX_PREFIX . 'property_featured',
					'value' => true,
					'compare' => '=',
				);
			}
			return $meta_query;
		}



		public function get_meta_query_custom_fields($meta_query) {
			$additional_fields = ere_get_search_additional_fields();
			foreach ($additional_fields as $id => $title) {
				$field = ere_get_search_additional_field($id);
				if ($field === false) {
					continue;
				}
				$field_type = isset($field['field_type']) ? $field['field_type'] : 'text';
				$field_value = isset($_REQUEST[$id]) ? ere_clean( wp_unslash( $_REQUEST[$id] ) ) : '';
				if (!empty($field_value)) {
					if ($field_type === 'checkbox_list') {
						$meta_query[]      = array(
							'key'     => ERE_METABOX_PREFIX . $id,
							'value'   => $field_value,
							'type'    => 'CHAR',
							'compare' => 'LIKE',
						);
					} else {
						$meta_query[]      = array(
							'key'     => ERE_METABOX_PREFIX . $id,
							'value'   => $field_value,
							'type'    => 'CHAR',
							'compare' => '=',
						);
					}
                    /* translators: %1$s: title of additional field, %2$s: value of additional field */
					$this->set_parameter( sprintf(__( '%1$s: <strong>%2$s</strong>', 'essential-real-estate' ) ,$title , $field_value ) );
				}
			}

			return $meta_query;
		}

		public function get_meta_query_user($meta_query) {
			$user_id = isset($_REQUEST['user_id']) ? ere_clean(wp_unslash($_REQUEST['user_id'])) : $this->_atts['user_id'];
			$agent_id = isset($_REQUEST['agent_id']) ? ere_clean(wp_unslash($_REQUEST['agent_id'])) : $this->_atts['agent_id'];
			$author_id =  isset($_REQUEST['author_id']) ? ere_clean(wp_unslash($_REQUEST['author_id'])) : $this->_atts['author_id'];
			if (!empty($user_id)) {
				$author_id = $user_id;
				$agent_id = get_user_meta($author_id,ERE_METABOX_PREFIX . 'author_agent_id', TRUE);
			}

			if (!empty($agent_id) && empty($author_id)) {
				$author_id = get_post_meta($agent_id, ERE_METABOX_PREFIX . 'agent_user_id', TRUE);
			}

			if (!empty($author_id) && !empty($agent_id)) {
				$meta_query[] = array(
					'relation' => 'OR',
					array(
						'key' => ERE_METABOX_PREFIX . 'property_agent',
                        'value' => explode(',', $agent_id),
                        'compare' => 'IN'
					),
					array(
						'key' => ERE_METABOX_PREFIX . 'property_author',
                        'value' => explode(',', $author_id),
                        'compare' => 'IN'
					)
				);
			} else {
				if (!empty($author_id)) {
					$this->_query_args['author'] = $author_id;
				} else if (!empty($agent_id)) {
					$meta_query[] = [
						'key'     => ERE_METABOX_PREFIX . 'property_agent',
                        'value' => explode(',', $agent_id),
                        'compare' => 'IN'
					];
				}
			}
			return $meta_query;
		}


		public function get_tax_query_type( $tax_query ) {
			$type = isset( $_REQUEST['type'] ) ?  wp_unslash( $_REQUEST['type'] )  : $this->_atts['type'];
			if ( ! empty( $type ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-type',
					'field'    => 'slug',
					'terms'    => $type
				);

				if (is_array($type)) {
					$type = implode( ', ', $type );
				}
                /* translators: %s: parameter property type */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Type: <strong>%s</strong>', 'essential-real-estate' ), $type )));
			}

			return $tax_query;
		}

		public function get_tax_query_status( $tax_query ) {
			$status = isset( $_REQUEST['status'] ) ?  wp_unslash( $_REQUEST['status'] )  : $this->_atts['status'];
			if ( ! empty( $status ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-status',
					'field'    => 'slug',
					'terms'    => $status
				);

				if (is_array($status)) {
					$status = implode( ', ', $status );
				}
                /* translators: %s: parameter property status */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Status: <strong>%s</strong>', 'essential-real-estate' ), $status )));
			}

			return $tax_query;
		}

		public function get_tax_query_label( $tax_query ) {
			$label = isset( $_REQUEST['label'] ) ?  wp_unslash( $_REQUEST['label'] )  : $this->_atts['label'];
			if ( ! empty( $label ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-label',
					'field'    => 'slug',
					'terms'    => $label
				);

				if (is_array($label)) {
					$label = implode( ', ', $label );
				}
                /* translators: %s: parameter property label */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Label: <strong>%s</strong>', 'essential-real-estate' ), $label )));
			}

			return $tax_query;
		}

		public function get_tax_query_city( $tax_query ) {
			$city = isset( $_REQUEST['city'] ) ?  wp_unslash( $_REQUEST['city'] )  : $this->_atts['city'];
			if ( ! empty( $city ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-city',
					'field'    => 'slug',
					'terms'    => $city
				);

				if (is_array($city)) {
					$city = implode( ', ', $city );
				}
                /* translators: %s: parameter city */
				$this->set_parameter( wp_kses_post(sprintf( __( 'City: <strong>%s</strong>', 'essential-real-estate' ), $city )));
			}

			return $tax_query;
		}

		public function get_tax_query_state( $tax_query ) {
			$state = isset( $_REQUEST['state'] ) ?  wp_unslash( $_REQUEST['state'] )  : $this->_atts['state'];
			if ( ! empty( $state ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-state',
					'field'    => 'slug',
					'terms'    => $state
				);

				if (is_array($state)) {
					$state = implode( ', ', $state );
				}
                /* translators: %s: parameter state */
				$this->set_parameter( wp_kses_post(sprintf( __( 'State: <strong>%s</strong>', 'essential-real-estate' ), $state )));
			}

			return $tax_query;
		}

		public function get_tax_query_neighborhood( $tax_query ) {
			$neighborhood = isset( $_REQUEST['neighborhood'] ) ?  wp_unslash( $_REQUEST['neighborhood'] )  : $this->_atts['neighborhood'];
			if ( ! empty( $neighborhood ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-neighborhood',
					'field'    => 'slug',
					'terms'    => $neighborhood
				);

				if (is_array($neighborhood)) {
					$neighborhood = implode( ', ', $neighborhood );
				}
                /* translators: %s: parameter neighborhood */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Neighborhood: <strong>%s</strong>', 'essential-real-estate' ), $neighborhood )));
			}

			return $tax_query;
		}

		public function get_tax_query_feature( $tax_query ) {
			$features = isset( $_REQUEST['features'] ) ?  wp_unslash( $_REQUEST['features'] )  : $this->_atts['features'];
			if ( ! empty( $features )) {
				if (is_string($features) && strpos($features,';')) {
					$features = explode(';',$features);
				}

				$tax_query[] = array(
					'taxonomy' => 'property-feature',
					'field'    => 'slug',
					'terms'    => $features
				);
                /* translators: %s: parameter property features */
				$this->set_parameter( wp_kses_post(sprintf( __( 'Features: <strong>%s</strong>', 'essential-real-estate' ), implode( ', ', $features ) ))  );
			}
			return $tax_query;
		}

        public function get_meta_query_property_search_ajax($meta_query) {
            $meta_query = apply_filters('ere_property_search_ajax_meta_query_args',$meta_query);
            return $meta_query;
        }

        public function get_meta_query_advanced_search($meta_query) {
            $meta_query = apply_filters('ere_ere_advanced_search_meta_query_args',$meta_query);
            return $meta_query;
        }

        public function get_tax_query_property_search_ajax($tax_query) {
            $tax_query = apply_filters('ere_property_search_ajax_tax_query_args',$tax_query);
            return $tax_query;
        }
	}
	ERE_Query::get_instance()->init();
}