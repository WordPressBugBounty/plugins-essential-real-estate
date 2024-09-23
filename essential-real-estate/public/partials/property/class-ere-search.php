<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('ERE_Search')) {
    /**
     * Class ERE_Search
     */

    class ERE_Search
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


        public function query_all_properties()
        {
            $data = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby'   => array(
                    'menu_order'=>'ASC',
                    'date' =>'DESC',
                ),
            );
            $featured_toplist = ere_get_option('featured_toplist', 1);
            if($featured_toplist!=0)
            {
                /*$data['orderby'] = array(
                    'menu_order'=>'ASC',
                    'meta_value_num' => 'DESC',
                    'date' => 'DESC',
                );
                $data['meta_key'] = ERE_METABOX_PREFIX . 'property_featured';*/
	            $data['ere_orderby_featured'] = true;
            }
            return new WP_Query($data);
        }

        public function ere_property_search_ajax()
        {
            check_ajax_referer('ere_search_map_ajax_nonce', 'ere_security_search_map');
            $search_type = isset($_REQUEST['search_type']) ? ere_clean(wp_unslash($_REQUEST['search_type']))  : '';
            $query_args = ere_get_property_query_args();
            $query_args = apply_filters('ere_property_search_ajax_query_args',$query_args);
            $the_query = new WP_Query($query_args);
            $properties = array();
            $property_html = '';
            $custom_property_image_size = ere_get_option( 'search_property_image_size', ere_get_loop_property_image_size_default() );
            $property_item_class = array('property-item');
            if($search_type == 'map_and_content') {
                $property_html = '<div class="list-property-result-ajax">';
            }
            while ($the_query->have_posts()): $the_query->the_post();
                $property_id = get_the_ID();
                $property_location = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_location', true);
                if (!empty($property_location['location'])) {
                    $lat_lng = explode(',', $property_location['location']);
                } else {
                    $lat_lng = array();
                }
                $attach_id = get_post_thumbnail_id();
                $width = 100;
                $height = 100;
                if (!empty($attach_id)) {
                    $image_src = ere_image_resize_id($attach_id, $height, $width, true);
                } else {
                    $image_src= ERE_PLUGIN_URL . 'public/assets/images/no-image.jpg';
                    $default_image=ere_get_option('default_property_image','');
                    if($default_image!='')
                    {
                        $image_src=$default_image['url'];
                    }
                }
                $property_type = get_the_terms($property_id, 'property-type');
                $property_url = '';
                if ($property_type) {
                    $property_type_id = $property_type[0]->term_id;
                    $property_type_icon = get_term_meta($property_type_id, 'property_type_icon', true);
                    if (is_array($property_type_icon) && count($property_type_icon) > 0) {
                        $property_url = $property_type_icon['url'];
                    }
                }

                $property_address = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_address', true);
                $properties_price = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_price', true);
                $properties_price = ere_get_format_money($properties_price);
                $prop = new stdClass();
                $prop->image_url = $image_src;
                $prop->title = get_the_title();
                $prop->lat = $lat_lng[0];
                $prop->lng = $lat_lng[1];
                $prop->url = get_permalink();
                $prop->price = $properties_price;
                $prop->address = $property_address;
                if ($property_url == '') {
                    $property_url = ERE_PLUGIN_URL . 'public/assets/images/map-marker-icon.png';
                    $default_marker=ere_get_option('marker_icon','');
                    if($default_marker!='')
                    {
                        if(is_array($default_marker)&& $default_marker['url']!='')
                        {
                            $property_url=$default_marker['url'];
                        }
                    }
                }
                $prop->marker_icon = $property_url;
                array_push($properties, $prop);

                if($search_type == 'map_and_content') {
                    $property_html .= ere_get_template_html('content-property.php', array(
                        'custom_property_image_size' => $custom_property_image_size,
                        'property_item_class' => $property_item_class,
                    ));
                }
            endwhile;
            if($search_type == 'map_and_content') {
                $property_html .= '</div>';
            }
            if (count($properties) > 0) {
                echo wp_json_encode(array('success' => true, 'properties' => $properties, 'property_html' => $property_html));
            } else {
                echo wp_json_encode(array('success' => false));
            }
            wp_reset_postdata();
            die();
        }

        public function ere_property_search_map_ajax()
        {
            check_ajax_referer('ere_search_map_ajax_nonce', 'ere_security_search_map');


            $meta_query = array();
            $tax_query = array();
	        $keyword_array = '';

	        $keyword = isset($_REQUEST['keyword']) ? ere_clean(wp_unslash($_REQUEST['keyword']))  : '';
            $title = isset($_REQUEST['title']) ? ere_clean(wp_unslash($_REQUEST['title']))  : '';
            $address = isset($_REQUEST['address']) ? ere_clean(wp_unslash($_REQUEST['address']))  : '';
            $type = isset($_REQUEST['type']) ? ere_clean(wp_unslash($_REQUEST['type']))  : '';
            $city = isset($_REQUEST['city']) ? ere_clean(wp_unslash($_REQUEST['city']))  : '';
            $status = isset($_REQUEST['status']) ? ere_clean(wp_unslash($_REQUEST['status']))  : '';
	        $rooms = isset($_REQUEST['rooms']) ? ere_clean(wp_unslash($_REQUEST['rooms']))  : '';
            $bathrooms = isset($_REQUEST['bathrooms']) ? ere_clean(wp_unslash($_REQUEST['bathrooms']))  : '';
            $bedrooms = isset($_REQUEST['bedrooms']) ? ere_clean(wp_unslash($_REQUEST['bedrooms']))  : '';
            $min_area = isset($_REQUEST['min_area']) ? ere_clean(wp_unslash($_REQUEST['min_area']))  : '';
            $max_area = isset($_REQUEST['max_area']) ? ere_clean(wp_unslash($_REQUEST['max_area'])) : '';
            $min_price = isset($_REQUEST['min_price']) ? ere_clean(wp_unslash($_REQUEST['min_price'])) : '';
            $max_price = isset($_REQUEST['max_price']) ? ere_clean(wp_unslash($_REQUEST['max_price'])) : '';
            $state = isset($_REQUEST['state']) ? ere_clean(wp_unslash($_REQUEST['state'])) : '';
            $country = isset($_REQUEST['country']) ? ere_clean(wp_unslash($_REQUEST['country'])) : '';
            $neighborhood = isset($_REQUEST['neighborhood']) ? ere_clean(wp_unslash($_REQUEST['neighborhood'])) : '';
            $label = isset($_REQUEST['label']) ? ere_clean(wp_unslash($_REQUEST['label'])) : '';
            $garage = isset($_REQUEST['garage']) ? ere_clean(wp_unslash($_REQUEST['garage'])) : '';
            $min_land_area = isset($_REQUEST['min_land_area']) ? ere_clean(wp_unslash($_REQUEST['min_land_area'])) : '';
            $max_land_area = isset($_REQUEST['max_land_area']) ? ere_clean(wp_unslash($_REQUEST['max_land_area'])) : '';
            $property_identity = isset($_REQUEST['property_identity']) ? ere_clean(wp_unslash($_REQUEST['property_identity'])) : '';
            $features = isset($_REQUEST['features']) ? ere_clean(wp_unslash($_REQUEST['features'])) : '';
            $search_type = isset($_REQUEST['search_type']) ? ere_clean(wp_unslash($_REQUEST['search_type'])) : '';
            $paged = isset($_REQUEST['paged']) ? ere_clean(wp_unslash($_REQUEST['paged'])) : '1';
            $item_amount = isset($_REQUEST['item_amount']) ? ere_clean(wp_unslash($_REQUEST['item_amount'])) : '18';
            $marker_image_size = isset($_REQUEST['marker_image_size']) ? ere_clean(wp_unslash($_REQUEST['marker_image_size'])) : '100x100';
            $_atts = array(
                'keyword' => $keyword,
                'title' => $title,
                'address' => $address,
                'type' => $type,
                'city' => $city,
                'status' => $status,
                'bathrooms' => $bathrooms,
                'bedrooms' => $bedrooms,
                'rooms' => $rooms,
                'min-area' => $min_area,
                'max-area' => $max_area,
                'min-price' => $min_price,
                'max-price' => $max_price,
                'state' => $state,
                'country' => $country,
                'neighborhood' => $neighborhood,
                'label' => $label,
                'garage' => $garage,
                'min-land-area' => $min_land_area,
                'max-land-area' => $max_land_area,
                'property_identity' => $property_identity,
                'features' => $features,
                'item_amount' => ($item_amount > 0) ? $item_amount : -1,
                'paged' => $paged,
            );
            $query_args = ere_get_property_query_args($_atts);
	        $query_args = apply_filters('ere_property_search_map_ajax_query_args',$query_args);
            $data = new WP_Query($query_args);
            $properties = array();
            $total_post = $data->found_posts;
	        ob_start();
            if($total_post > 0){
                $custom_property_image_size = '370x220';
                $property_item_class = array('property-item ere-item-wrap');

                if ($search_type == 'map_and_content') {
                    ?>
                    <div class="list-property-result-ajax">
                    <?php
                }
                ?>
                <div class="ere-property clearfix property-grid property-vertical-map-listing col-gap-10 columns-3 columns-md-3 columns-sm-2 columns-xs-1 columns-mb-1">
                <?php
                while ($data->have_posts()): $data->the_post();
                    $property_id = get_the_ID();
                    $property_location = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_location', true);
                    $lat = '';
                    $lng = '';
                    if (!empty($property_location['location'])) {
                        $lat_lng = explode(',', $property_location['location']);
                        $lat = $lat_lng[0];
                        $lng = $lat_lng[1];
                    } else {
                        $lat_lng = array();
                    }
                    $attach_id = get_post_thumbnail_id();
                    if (preg_match('/\d+x\d+/', $marker_image_size)) {
                        $image_sizes = explode('x', $marker_image_size);
                        $width=$image_sizes[0];$height= $image_sizes[1];
                        $image_src = ere_image_resize_id($attach_id, $width, $height, true);
                    } else {
                        if (!in_array($marker_image_size, array('full', 'thumbnail'))) {
                            $marker_image_size = 'full';
                        }
                        $image_src_arr = wp_get_attachment_image_src($attach_id, $marker_image_size);
                        if (is_array($image_src_arr)) {
                        	$image_src = $image_src_arr[0];
                        }
                    }
                    //$marker_image_size
                    $property_type = get_the_terms($property_id, 'property-type');
                    $property_url = '';
                    if ($property_type) {
                        $property_type_id = $property_type[0]->term_id;
                        $property_type_icon = get_term_meta($property_type_id, 'property_type_icon', true);
                        if (is_array($property_type_icon) && count($property_type_icon) > 0) {
                            $property_url = $property_type_icon['url'];
                        }
                    }

                    $property_address = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_address', true);
                    $properties_price = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_price', true);
                    $properties_price = ere_get_format_money($properties_price);
                    $prop = new stdClass();
                    $prop->image_url = $image_src;
                    $prop->title = get_the_title();
                    $prop->lat = $lat;
                    $prop->lng = $lng;
                    $prop->url = get_permalink();
                    $prop->price = $properties_price;
                    $prop->address = $property_address;
                    if ($property_url == '') {
                        $property_url = ERE_PLUGIN_URL . 'public/assets/images/map-marker-icon.png';
                        $default_marker=ere_get_option('marker_icon','');
                        if($default_marker!='')
                        {
                            if(is_array($default_marker)&& $default_marker['url']!='')
                            {
                                $property_url=$default_marker['url'];
                            }
                        }
                    }
                    $prop->marker_icon = $property_url;
                    array_push($properties, $prop);
                    if ($search_type == 'map_and_content') {
                        ere_get_template('content-property.php', array(
                            'custom_property_image_size' => $custom_property_image_size,
                            'property_item_class' => $property_item_class,
                        ));
                    }
                endwhile;?>
                </div>
                <div class="property-search-map-paging-wrap">
                    <?php $max_num_pages = $data->max_num_pages;
                    set_query_var('paged', $paged);
                    ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages));
                    ?>
                </div>
                <?php
                if ($search_type == 'map_and_content') {?>
                    </div><?php
                }
            }
            wp_reset_postdata();
            $property_html = ob_get_clean();
            if (count($properties) > 0) {
                echo wp_json_encode(array('success' => true, 'properties' => $properties, 'property_html' => $property_html,'total_post'=>$total_post));
            } else {
                echo wp_json_encode(array('success' => false));
            }
            die();
        }

        public function ere_ajax_change_price_on_status_change()
        {
            $slide_html=$min_price_html=$max_price_html='';
            $request_status = isset($_POST['status']) ? ere_clean(wp_unslash($_POST['status']))  : '';
            $price_is_slider = isset($_POST['price_is_slider']) ? ere_clean(wp_unslash($_POST['price_is_slider']))  : '';
            if (!empty($price_is_slider)&& $price_is_slider=='true') {
	            $min_price = ere_get_option('property_price_slider_min',200);
	            $max_price = ere_get_option('property_price_slider_max',2500000);
	            if ($request_status !== '') {
		            $property_price_slider_search_field = ere_get_option('property_price_slider_search_field', '');
		            if ($property_price_slider_search_field != '') {
			            foreach ($property_price_slider_search_field as $data) {
				            $term_id = (isset($data['property_price_slider_property_status']) ? $data['property_price_slider_property_status'] : '');
				            $term = get_term_by('id', $term_id, 'property-status');
				            if ($term->slug == $request_status) {
					            $min_price = (isset($data['property_price_slider_min']) ? $data['property_price_slider_min'] : $min_price);
					            $max_price = (isset($data['property_price_slider_max']) ? $data['property_price_slider_max'] : $max_price);
					            break;
				            }
			            }
		            }
	            }

                $min_price_change = $min_price;
                $max_price_change = $max_price;
                $slide_html='<div class="ere-sliderbar-price ere-sliderbar-filter" data-min-default="'. esc_attr($min_price) .'" data-max-default="'. esc_attr($max_price) .'" data-min="'. esc_attr($min_price_change) .'" data-max="'. esc_attr($max_price_change) .'">
                    <div class="title-slider-filter">'. esc_html__('Price', 'essential-real-estate').'[<span class="min-value">'. wp_kses_post(ere_get_format_money($min_price_change))  .'</span> - <span class="max-value">'. wp_kses_post(ere_get_format_money($max_price_change))  .'</span>]
                        <input type="hidden" name="min-price" class="min-input-request"
                               value="'. esc_attr($min_price_change) .'">
                        <input type="hidden" name="max-price" class="max-input-request"
                               value="'. esc_attr($max_price_change).'">
                    </div>
                    <div class="sidebar-filter"></div>
                </div>';
            }
            else
            {
	            $property_price_dropdown_min= apply_filters('ere_price_dropdown_min_default', ere_get_option('property_price_dropdown_min','0,100,300,500,700,900,1100,1300,1500,1700,1900')) ;
	            $property_price_dropdown_max= apply_filters('ere_price_dropdown_max_default', ere_get_option('property_price_dropdown_max','200,400,600,800,1000,1200,1400,1600,1800,2000')) ;
                $property_price_dropdown_search_field = ere_get_option('property_price_dropdown_search_field','');
                if ($property_price_dropdown_search_field != '') {
                    foreach ($property_price_dropdown_search_field as $data) {
                        $term_id =(isset($data['property_price_dropdown_property_status']) ? $data['property_price_dropdown_property_status'] : '');
                        $term = get_term_by('id', $term_id, 'property-status');
                        if($term->slug==$request_status)
                        {
                            $property_price_dropdown_min = (isset($data['property_price_dropdown_min']) ? $data['property_price_dropdown_min'] : $property_price_dropdown_min);
                            $property_price_dropdown_max = (isset($data['property_price_dropdown_max']) ? $data['property_price_dropdown_max'] : $property_price_dropdown_max);
                            break;
                        }
                    }
                }
                $min_price_html='<option value="">'.esc_html__('Min Price', 'essential-real-estate').'</option>';
                $property_price_array_min = explode(',', $property_price_dropdown_min);
                if (is_array($property_price_array_min) && !empty($property_price_array_min)) {
                    foreach ($property_price_array_min as $n) {
                        $min_price_html.='<option value="'. esc_attr($n) .'">';
                        $min_price_html.=  ere_get_format_money_search_field($n).'</option>';
                    }
                }
                $max_price_html='<option value="">'.esc_html__('Max Price', 'essential-real-estate').'</option>';
                $property_price_array_max = explode(',', $property_price_dropdown_max);
                if (is_array($property_price_array_max) && !empty($property_price_array_max)) {
                    foreach ($property_price_array_max as $n) {
                        $max_price_html.='<option value="'. esc_attr($n) .'">';
                        $max_price_html.=ere_get_format_money_search_field($n).'</option>';
                    }
                }
            }
            echo wp_json_encode(array('slide_html' => $slide_html, 'min_price_html' => $min_price_html, 'max_price_html' => $max_price_html));
            die();
        }
    }
}