<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Get Property Gallery Image
 *
 * @param $property_Id
 *
 * @return false|string[]
 */
function ere_get_property_gallery_image($property_Id) {
	$property_gallery = get_post_meta($property_Id, ERE_METABOX_PREFIX . 'property_images', true);
	if (empty($property_gallery)) {
		return false;
	}
	return explode( '|', $property_gallery);
}

function ere_get_single_property_features_tabs($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $tabs = array();

    $tabs['overview'] = array(
        'title'    => esc_html__( 'Overview', 'essential-real-estate' ),
        'priority' => 10,
        'callback' => 'ere_template_single_property_overview',
        'property_id' => $property_id
    );

    $tabs['features'] = array(
        'title'    => esc_html__( 'Features', 'essential-real-estate' ),
        'priority' => 20,
        'callback' => 'ere_template_single_property_feature',
        'property_id' => $property_id
    );

    $tabs['video'] = array(
        'title'    => esc_html__( 'Video', 'essential-real-estate' ),
        'priority' => 30,
        'callback' => 'ere_template_single_property_video',
        'property_id' => $property_id
    );

    $tabs['virtual_tour'] = array(
        'title'    => esc_html__( 'Virtual Tour', 'essential-real-estate' ),
        'priority' => 30,
        'callback' => 'ere_template_single_property_virtual_tour',
        'property_id' => $property_id
    );

    $tabs = apply_filters( 'ere_single_property_features_tabs', $tabs , $property_id);

    uasort( $tabs, 'ere_sort_by_order_callback' );

    $tabs = array_map( 'ere_content_callback', $tabs );

    return array_filter( $tabs, 'ere_filter_content_callback' );
}

function ere_get_single_property_overview($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    
    $overview = array();

    $overview['property_id'] = array(
        'title'    => esc_html__( 'Property ID', 'essential-real-estate' ),
        'priority' => 10,
        'callback' => 'ere_template_single_property_identity',
        'property_id' => $property_id
    );

    $overview['price'] = array(
        'title'    => esc_html__( 'Price', 'essential-real-estate' ),
        'priority' => 20,
        'callback' => 'ere_template_loop_property_price',
        'property_id' => $property_id
    );

    $overview['type'] = array(
        'title'    => esc_html__( 'Property Type', 'essential-real-estate' ),
        'priority' => 30,
        'callback' => 'ere_template_single_property_type',
        'property_id' => $property_id
    );

    $overview['status'] = array(
        'title'    => esc_html__( 'Property status', 'essential-real-estate' ),
        'priority' => 40,
        'callback' => 'ere_template_single_property_data_status',
        'property_id' => $property_id
    );

    $overview['rooms'] = array(
        'title'    => esc_html__( 'Rooms', 'essential-real-estate' ),
        'priority' => 50,
        'callback' => 'ere_template_single_property_rooms',
        'property_id' => $property_id
    );

    $overview['bedrooms'] = array(
        'title'    => esc_html__( 'Bedrooms', 'essential-real-estate' ),
        'priority' => 60,
        'callback' => 'ere_template_single_property_bedrooms',
        'property_id' => $property_id
    );

    $overview['bathrooms'] = array(
        'title'    => esc_html__( 'Bathrooms', 'essential-real-estate' ),
        'priority' => 70,
        'callback' => 'ere_template_single_property_bathrooms',
        'property_id' => $property_id
    );

    $overview['year'] = array(
        'title'    => esc_html__( 'Year Built', 'essential-real-estate' ),
        'priority' => 80,
        'callback' => 'ere_template_single_property_year',
        'property_id' => $property_id
    );

    $overview['size'] = array(
        'title'    => esc_html__( 'Size', 'essential-real-estate' ),
        'priority' => 90,
        'callback' => 'ere_template_single_property_size',
        'property_id' => $property_id
    );

    $overview['land_size'] = array(
        'title'    => esc_html__( 'Land area', 'essential-real-estate' ),
        'priority' => 100,
        'callback' => 'ere_template_single_property_land_size',
        'property_id' => $property_id
    );

    $overview['label'] = array(
        'title'    => esc_html__( 'Label', 'essential-real-estate' ),
        'priority' => 110,
        'callback' => 'ere_template_single_property_label',
        'property_id' => $property_id
    );

    $overview['garages'] = array(
        'title'    => esc_html__( 'Garages', 'essential-real-estate' ),
        'priority' => 120,
        'callback' => 'ere_template_single_property_garage',
        'property_id' => $property_id
    );

    $overview['garages_size'] = array(
        'title'    => esc_html__( 'Garage Size', 'essential-real-estate' ),
        'priority' => 130,
        'callback' => 'ere_template_single_property_garage_size',
        'property_id' => $property_id
    );

    $priority = 140;
    $additional_fields = ere_render_additional_fields();
    foreach ( $additional_fields as $key => $field ) {
        $property_field         = get_post_meta( $property_id, $field['id'], true );
        $property_field_content = $property_field;
        if ( $field['type'] == 'checkbox_list' ) {
            $property_field_content = '';
            if ( is_array( $property_field ) ) {
                foreach ( $property_field as $value => $v ) {
                    $property_field_content .= $v . ', ';
                }
            }
            $property_field_content = rtrim( $property_field_content, ', ' );
        }
        if ( $field['type'] === 'textarea' ) {
            $property_field_content = wpautop( $property_field_content );
        }
        if ( ! empty( $property_field_content ) ) {
            $overview[ $field['id'] ] = array(
                'title'    => $field['title'],
                'content'  => '<span>' . $property_field_content . '</span>',
                'priority' => $priority,
            );
        }
        $priority+= 10;
    }


    $additional_features = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'additional_features', true );
    if ( $additional_features > 0 ) {
        $additional_feature_title = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'additional_feature_title', true );
        $additional_feature_value = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'additional_feature_value', true );
        for ( $i = 0; $i < $additional_features; $i ++ ) {
            if ( ! empty( $additional_feature_title[ $i ] ) && ! empty( $additional_feature_value[ $i ] ) ) {
                $overview[ sanitize_title( $additional_feature_title[ $i ] ) ] = array(
                    'title'    => $additional_feature_title[ $i ],
                    'content'  => '<span>' . $additional_feature_value[ $i ] . '</span>',
                    'priority' => $priority,
                );
                $priority+= 10;
            }
        }
    }


    $overview = apply_filters( 'ere_single_property_overview', $overview );

    uasort( $overview, 'ere_sort_by_order_callback' );

    $overview = array_map( 'ere_content_callback', $overview );

    return array_filter( $overview, 'ere_filter_content_callback' );
}

function ere_get_property_features( $args = array() ) {
    $args     = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $features = get_the_terms( $args['property_id'], 'property-feature' );

    if ( is_a( $features, 'WP_Error' ) ) {
        return false;
    }

    return $features;
}

function ere_get_property_video( $args = array() ) {
    $args     = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_id = $args['property_id'];
    $property_video       = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_video_url', true );
    if ($property_video == '') {
        return false;
    }
    $property_video_image = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_video_image', true );
    return array(
        'video_url'   => $property_video,
        'video_image' => $property_video_image
    );

}

function ere_get_property_virtual_tour($args = array()) {
    $args     = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_id = $args['property_id'];
    $property_image_360         = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_image_360', true );
    $property_image_360         = ( isset( $property_image_360 ) && is_array( $property_image_360 ) ) ? $property_image_360['url'] : '';
    $property_virtual_tour      = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_virtual_tour', true );
    $property_virtual_tour_type = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_virtual_tour_type', true );
    if ( empty( $property_virtual_tour_type ) ) {
        $property_virtual_tour_type = '0';
    }
    if ( ! empty( $property_virtual_tour ) || $property_image_360 != '' ) {
        return array(
            'property_image_360'         => $property_image_360,
            'property_virtual_tour'      => $property_virtual_tour,
            'property_virtual_tour_type' => $property_virtual_tour_type
        );
    }

    return false;

}

function ere_get_property_price_slider($status = '') {
    $min_price = ere_get_option('property_price_slider_min',200);
    $max_price = ere_get_option('property_price_slider_max',2500000);
    if (!empty($status)) {
        $property_price_slider_search_field = ere_get_option('property_price_slider_search_field','');
        if ($property_price_slider_search_field != '') {
            foreach ($property_price_slider_search_field as $data) {
                $term_id =(isset($data['property_price_slider_property_status']) ? $data['property_price_slider_property_status'] : '');
                $term = get_term_by('id', $term_id, 'property-status');
                if($term)
                {
                    if ( $term->slug == $status)
                    {
                        $min_price = (isset($data['property_price_slider_min']) ? $data['property_price_slider_min'] : $min_price);
                        $max_price = (isset($data['property_price_slider_max']) ? $data['property_price_slider_max'] : $max_price);
                        break;
                    }
                }
            }
        }
    }
    return [
        'min-price' => $min_price,
        'max-price' => $max_price
    ];
}

function ere_get_property_price_dropdown( $status = '' ) {
    $property_price_dropdown_min = apply_filters( 'ere_price_dropdown_min_default', ere_get_option( 'property_price_dropdown_min', '0,100,300,500,700,900,1100,1300,1500,1700,1900' ) );
    $property_price_dropdown_max = apply_filters( 'ere_price_dropdown_max_default', ere_get_option( 'property_price_dropdown_max', '200,400,600,800,1000,1200,1400,1600,1800,2000' ) );
    if ( ! empty( $status ) ) {
        $property_price_dropdown_search_field = ere_get_option( 'property_price_dropdown_search_field', '' );
        if ( ! empty( $property_price_dropdown_search_field ) && is_array( $property_price_dropdown_search_field ) ) {
            foreach ( $property_price_dropdown_search_field as $data ) {
                $term_id = $data['property_price_dropdown_property_status'] ?? '';
                $term    = get_term_by( 'id', $term_id, 'property-status' );
                if ( $term ) {
                    if ( $term->slug == $status ) {
                        $property_price_dropdown_min = $data['property_price_dropdown_min'] ?? $property_price_dropdown_min;
                        $property_price_dropdown_max = $data['property_price_dropdown_max'] ?? $property_price_dropdown_max;
                        break;
                    }
                }
            }
        }
    }

    return [
        'min-price' => $property_price_dropdown_min,
        'max-price' => $property_price_dropdown_max,
    ];
}

function ere_get_property_query_args($atts = array(), $query_args = array()) {
    return ERE_Query::get_instance()->get_property_query_args($atts, $query_args);
}

function ere_get_property_query_parameters() {
    return ERE_Query::get_instance()->get_parameters();
}

function ere_get_property_sort_by() {
    return apply_filters('ere_property_sort_by',[
        'default' => esc_html__('Default Order','essential-real-estate'),
        'featured' => esc_html__('Featured','essential-real-estate'),
        'most_viewed' => esc_html__('Most Viewed','essential-real-estate'),
        'a_price' => esc_html__('Price (Low to High)','essential-real-estate'),
        'd_price' => esc_html__('Price (High to Low)','essential-real-estate'),
        'a_date' => esc_html__('Date (Old to New)','essential-real-estate'),
        'd_date' => esc_html__('Date (New to Old)','essential-real-estate')
    ]);
}



function ere_get_loop_property_featured_label($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $meta = array();

    $meta['featured'] = array(
        'priority' => 10,
        'callback' => 'ere_template_loop_property_featured',
        'property_id' => $property_id
    );

    $meta['label'] = array(
        'priority' => 20,
        'callback' => 'ere_template_loop_property_term_label',
        'property_id' => $property_id
    );


    $meta = apply_filters( 'ere_loop_property_featured_label', $meta );

    uasort( $meta, 'ere_sort_by_order_callback' );

    $meta = array_map( 'ere_content_callback', $meta );

    return array_filter( $meta, 'ere_filter_content_callback' );
}


function ere_get_agent_info_of_property($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $agent_display_option = get_post_meta($property_id,ERE_METABOX_PREFIX . 'agent_display_option',true);
    $property_agent       = get_post_meta($property_id,ERE_METABOX_PREFIX . 'property_agent', true);
    $agent_name           = $agent_link = '';
    if ( $agent_display_option == 'author_info' ) {
        $user_id = get_post_field( 'post_author', $property_id );
        $user_info = get_userdata( $user_id );
        if ( empty( $user_info->first_name ) && empty( $user_info->last_name ) ) {
            $agent_name = $user_info->user_login;
        } else {
            $agent_name = $user_info->first_name . ' ' . $user_info->last_name;
        }
        if ( !empty($author_agent_id) && (get_post_status( $author_agent_id ) == 'publish') ) {
            $agent_link = get_the_permalink( $author_agent_id );
        } else {
            $agent_link = '#';
        }

    } elseif ( $agent_display_option == 'other_info' ) {
        $agent_name = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_other_contact_name' , true);
    } elseif ( $agent_display_option == 'agent_info' && ! empty( $property_agent ) ) {
        $agent_name = get_the_title( $property_agent );
        $agent_link = get_the_permalink( $property_agent );
    }

    if (empty($agent_name)) {
        return false;
    }

    if (empty($agent_link)) {
        $agent_link = '#';
    }

    return array(
        'name' => $agent_name,
        'link' => $agent_link
    );
}

function ere_get_agent_contact_info_of_property($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $agent_display_option = get_post_meta($property_id,ERE_METABOX_PREFIX . 'agent_display_option',true);
    $agent_id       = get_post_meta($property_id,ERE_METABOX_PREFIX . 'property_agent', true);
    $user_id = '';
    $agent_name = $agent_link = $email = $avatar_src = $agent_position = $agent_facebook_url = $agent_twitter_url = $agent_linkedin_url = $agent_pinterest_url = $agent_skype = $agent_youtube_url = $agent_vimeo_url = $agent_mobile_number = $agent_office_address = $agent_website_url = $agent_description = '';
    $agent_type = $agent_instagram_url = '';
    if ($agent_display_option === 'agent_info') {
        $property_agent_status = get_post_status($agent_id);
        if ($property_agent_status !== 'publish') {
            $agent_display_option = 'author_info';
        }
    }

    $avatar_width = 270;
    $avatar_height = 340;
    $avatar_size = apply_filters('ere_single_property_contact_agent_avatar_size','270x340') ;
    if (preg_match('/\d+x\d+/', $avatar_size)) {
        $avatar_sizes = explode('x', $avatar_size);
        $avatar_width = $avatar_sizes[0];
        $avatar_height = $avatar_sizes[1];
    }



    $no_avatar_src = ERE_PLUGIN_URL . 'public/assets/images/profile-avatar.png';
    $default_avatar=ere_get_option('default_user_avatar','');
    if($default_avatar!='')
    {
        if(is_array($default_avatar)&& $default_avatar['url']!='')
        {
            $resize = ere_image_resize_url($default_avatar['url'], $avatar_width, $avatar_height, true);
            if ($resize != null && is_array($resize)) {
                $no_avatar_src = $resize['url'];
            }
        }
    }


    if ( $agent_display_option == 'author_info' ) {
        $user_id = get_post_field( 'post_author', $property_id );
        $user_info = get_userdata( $user_id );
        if ( empty( $user_info->first_name ) && empty( $user_info->last_name ) ) {
            $agent_name = $user_info->user_login;
        } else {
            $agent_name = $user_info->first_name . ' ' . $user_info->last_name;
        }

        $author_agent_id = get_the_author_meta( ERE_METABOX_PREFIX . 'author_agent_id', $user_id );
        if (!empty($author_agent_id) && (get_post_status( $author_agent_id ) == 'publish') ) {
            $agent_position = esc_html__( 'Property Agent', 'essential-real-estate' );
            $agent_type = esc_html__( 'Agent', 'essential-real-estate' );
            $agent_link = get_the_permalink($author_agent_id);
        } else {
            $agent_position = esc_html__( 'Property Seller', 'essential-real-estate' );
            $agent_type = esc_html__( 'Seller', 'essential-real-estate' );
            $agent_link = '#';
        }

        $email = $user_info->user_email;
        $author_picture_id = get_the_author_meta( ERE_METABOX_PREFIX . 'author_picture_id', $user_id );
        $avatar_src = ere_image_resize_id($author_picture_id, $avatar_width, $avatar_height, true);


        $agent_facebook_url   = get_the_author_meta( ERE_METABOX_PREFIX . 'author_facebook_url', $user_id );
        $agent_twitter_url    = get_the_author_meta( ERE_METABOX_PREFIX . 'author_twitter_url', $user_id );
        $agent_linkedin_url   = get_the_author_meta( ERE_METABOX_PREFIX . 'author_linkedin_url', $user_id );
        $agent_pinterest_url  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_pinterest_url', $user_id );
        $agent_instagram_url  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_instagram_url', $user_id );
        $agent_skype          = get_the_author_meta( ERE_METABOX_PREFIX . 'author_skype', $user_id );
        $agent_youtube_url    = get_the_author_meta( ERE_METABOX_PREFIX . 'author_youtube_url', $user_id );
        $agent_vimeo_url      = get_the_author_meta( ERE_METABOX_PREFIX . 'author_vimeo_url', $user_id );

        $agent_mobile_number  = get_the_author_meta( ERE_METABOX_PREFIX . 'author_mobile_number', $user_id );
        $agent_office_address = get_the_author_meta( ERE_METABOX_PREFIX . 'author_office_address', $user_id );
        $agent_website_url    = get_the_author_meta( 'user_url', $user_id );

    } elseif ( $agent_display_option == 'other_info' ) {
        $agent_name = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_other_contact_name' , true);

        $email = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_other_contact_mail' , true);
        $agent_mobile_number = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_other_contact_phone' , true);
        $agent_description = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_other_contact_description' , true);


    } elseif ( $agent_display_option == 'agent_info' && ! empty( $agent_id ) ) {
        $agent_name = get_the_title( $agent_id );
        $agent_link = get_the_permalink( $agent_id );
        $email = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_email', true);
        $avatar_id = get_post_thumbnail_id($agent_id);
        $avatar_src = ere_image_resize_id($avatar_id, $avatar_width, $avatar_height, true);
        $agent_position = esc_html__( 'Property Agent', 'essential-real-estate' );
        $agent_type = esc_html__( 'Agent', 'essential-real-estate' );

        $agent_facebook_url = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_facebook_url', true);
        $agent_twitter_url = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_twitter_url', true);
        $agent_linkedin_url =  get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_linkedin_url', true);
        $agent_pinterest_url = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_pinterest_url', true);
        $agent_instagram_url = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_instagram_url', true);
        $agent_skype = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_skype', true);
        $agent_youtube_url = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_youtube_url', true);
        $agent_vimeo_url =  get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_vimeo_url', true);

        $agent_mobile_number = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_mobile_number', true);
        $agent_office_address = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_office_address', true);
        $agent_website_url = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_website_url', true);
    }

    if (empty($agent_link)) {
        $agent_link = '#';
    }

    $is_login= true;
    $hide_contact_information_if_not_login = ere_get_option( 'hide_contact_information_if_not_login', 0 );
    if (filter_var($hide_contact_information_if_not_login,FILTER_VALIDATE_BOOLEAN)) {
        $is_login = is_user_logged_in();
    }

    return array(
        'name' => $agent_name,
        'link' => $agent_link,
        'display_type' => $agent_display_option,
        'email' => $email,
        'avatar' => $avatar_src,
        'position' => $agent_position,
        'type' => $agent_type,
        'facebook' => $agent_facebook_url,
        'twitter' => $agent_twitter_url,
        'linkedin' => $agent_linkedin_url,
        'pinterest' => $agent_pinterest_url,
        'instagram' => $agent_instagram_url,
        'skype' => $agent_skype,
        'youtube' => $agent_youtube_url,
        'vimeo' => $agent_vimeo_url,
        'mobile' => $agent_mobile_number,
        'office' => $agent_office_address,
        'website' => $agent_website_url,
        'no_avatar_src' => $no_avatar_src,
        'is_login' => $is_login,
        'desc' => $agent_description,
        'user_id' => $user_id,
        'agent_id' => $agent_id
    );
}

function ere_get_loop_property_image_size_default()
{
    return apply_filters('ere_loop_property_image_size_default', '330x180');
}

function ere_get_sc_property_gallery_image_size_default()
{
    return apply_filters('ere_sc_property_gallery_image_size_default', '290x270');
}

function ere_get_sc_property_slider_image_size_default()
{
    return apply_filters('ere_sc_property_slider_image_size_default', '1200x600');
}

function ere_get_sc_property_slider_thumb_image_size_default()
{
    return apply_filters('ere_sc_property_slider_thumb_image_size_default', '170x90');
}

function ere_get_single_property_gallery_image_size()
{
    return apply_filters('ere_single_property_gallery_image_size', '870x420');
}

function ere_get_single_property_gallery_thumb_image_size()
{
    return apply_filters('ere_single_property_gallery_thumb_image_size', '250x130');
}

function ere_property_get_rating($propertyId) {
    $data = get_post_meta($propertyId, ERE_METABOX_PREFIX . 'property_rating', true);
    if (!is_array($data)) {
        $data = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        );
    }
    return $data;
}

function ere_property_get_list_review($propertyId,$userId)
{
    global $wpdb;
    return $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->comments as cm
                                       LEFT JOIN $wpdb->commentmeta as mt ON cm.comment_ID = mt.comment_id
                                       WHERE cm.comment_post_ID = %d
                                       AND (cm.comment_approved = 1 OR cm.user_id = %d)  
                                       AND mt.meta_key = 'property_rating'
                                       ORDER BY cm.comment_ID DESC",
        $propertyId,
        $userId) );
}

function ere_property_get_review_by_user_id($propertyId, $userId) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare("SELECT cm.comment_ID, cm.comment_content, mt.meta_value as rate FROM $wpdb->comments as cm 
                                             INNER JOIN $wpdb->commentmeta as mt ON cm.comment_ID = mt.comment_id 
                                             WHERE 
                                                cm.comment_post_ID = %d 
                                                AND cm.user_id = %d
                                                AND mt.meta_key = 'property_rating'
                                             ORDER BY cm.comment_ID DESC",
        $propertyId,
        $userId));
}

function ere_property_get_price_data($propertyId) {
    $price            = get_post_meta( $propertyId, ERE_METABOX_PREFIX . 'property_price', true );
    $price_short      = get_post_meta( $propertyId, ERE_METABOX_PREFIX . 'property_price_short', true );
    $price_unit       = get_post_meta( $propertyId, ERE_METABOX_PREFIX . 'property_price_unit', true );
    $price_prefix     = get_post_meta( $propertyId, ERE_METABOX_PREFIX . 'property_price_prefix', true );
    $price_postfix    = get_post_meta( $propertyId, ERE_METABOX_PREFIX . 'property_price_postfix', true );
    $empty_price_text = ere_get_option( 'empty_price_text' );
    return array(
        'price'            => $price,
        'price_short'      => $price_short,
        'price_unit'       => $price_unit,
        'price_prefix'     => $price_prefix,
        'price_postfix'    => $price_postfix,
        'empty_price_text' => $empty_price_text
    );
}

function ere_property_get_status($propertyId) {
    $property_item_status = get_the_terms( $propertyId, 'property-status' );
    if ( $property_item_status === false || is_a( $property_item_status, 'WP_Error' ) ) {
        return false;
    }
    return $property_item_status;
}
function ere_property_get_address_data($propertyId = '') {
    if (empty($propertyId)) {
        $propertyId = get_the_ID();
    }
    $property_address   = get_post_meta($propertyId,ERE_METABOX_PREFIX . 'property_address', TRUE);
    if (empty($property_address)) {
        return false;
    }

    $position = ere_property_get_map_position($propertyId);
    if ($position && !empty($position['address'])) {
        $property_address = $position['address'];
    }
    $google_map_address_url = "http://maps.google.com/?q=" . $property_address;
    return array(
        'property_address'       => $property_address,
        'google_map_address_url' => $google_map_address_url,
    );
}

function ere_get_single_property_address_data() {
    $meta = array();

    $property_address = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_address', true );
    if ( ! empty( $property_address ) ) {
        $meta['address'] = array(
            'priority' => 10,
            'label'    => esc_html__( 'Address', 'essential-real-estate' ),
            'content'  => $property_address
        );
    }

    $property_country = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_country', true );
    if ( ! empty( $property_country ) ) {
        $property_country = ere_get_country_by_code( $property_country );
        $meta['country']  = array(
            'priority' => 20,
            'label'    => esc_html__( 'Country', 'essential-real-estate' ),
            'content'  => $property_country
        );
    }

    $property_state = get_the_term_list( get_the_ID(), 'property-state', '', ', ', '' );
    if ( ! empty( $property_state ) ) {
        $meta['state'] = array(
            'priority' => 30,
            'label'    => esc_html__( 'Province/State', 'essential-real-estate' ),
            'content'  => $property_state
        );
    }


    $property_city = get_the_term_list( get_the_ID(), 'property-city', '', ', ', '' );
    if ( ! empty( $property_city ) ) {
        $meta['city'] = array(
            'priority' => 40,
            'label'    => esc_html__( 'City/Town', 'essential-real-estate' ),
            'content'  => $property_city
        );
    }

    $property_neighborhood = get_the_term_list( get_the_ID(), 'property-neighborhood', '', ', ', '' );
    if ( ! empty( $property_neighborhood ) ) {
        $meta['neighborhood'] = array(
            'priority' => 50,
            'label'    => esc_html__( 'Neighborhood', 'essential-real-estate' ),
            'content'  => $property_neighborhood
        );
    }

    $property_zip = get_post_meta( get_the_ID(), ERE_METABOX_PREFIX . 'property_zip', true );
    if ( ! empty( $property_zip ) ) {
        $meta['zip'] = array(
            'priority' => 50,
            'label'    => esc_html__( 'Postal code/ZIP', 'essential-real-estate' ),
            'content'  => $property_zip
        );
    }


    $meta = apply_filters( 'ere_single_property_address', $meta );

    uasort( $meta, 'ere_sort_by_order_callback' );

    $meta = array_map( 'ere_content_callback', $meta );

    return array_filter( $meta, 'ere_filter_content_callback' );
}

function ere_property_get_map_position($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_location = get_post_meta($property_id,ERE_METABOX_PREFIX . 'property_location',TRUE);
    if (empty($property_location)) {
        return false;
    }
    list( $lat, $lng ) =  isset($property_location['location']) && !empty($property_location['location']) ? explode( ',', $property_location['location'] ) : array('', '');
    if (empty($lng) || empty($lat)) {
        return false;
    }

    $address = isset($property_location['address']) ? $property_location['address'] : '';

    return array(
        'lat' => floatval($lat) ,
        'lng' => floatval($lng),
        'address' => $address
    );

}

function ere_property_get_map_marker( $id ) {
    $categories     = get_the_terms( $id, 'property-type' );
    $first_category = $categories ? $categories[0] : false;
    $marker         = false;
    if ( $first_category ) {
        $marker_image = get_term_meta( $first_category->term_id, 'property_type_icon', true );
        if ( is_array( $marker_image ) && isset( $marker_image['url'] ) && ! empty( $marker_image['url'] ) ) {
            $marker_html = sprintf( '<img src="%s" />', esc_url( $marker_image['url'] ) );
            $marker = array(
                'type' => 'image',
                'html' => $marker_html
            );
        }
    }
    return $marker;
}

function ere_property_get_location_data($property_id) {
    $property = get_post($property_id);
    if (!is_a($property,'WP_Post')) {
        return false;
    }
    $position = ere_property_get_map_position($property->ID);
    if ($position === false) {
        return  false;
    }
    ob_start();
    ere_template_loop_property_price($property_id);
    $price = ob_get_clean();

    ob_start();
    ere_template_loop_property_image( array(
        'property_id'       => $property_id,
        'image_size' => '100x100',
    ));
    $property_image = ob_get_clean();

    $address_data = ere_property_get_address_data();
    $address = '';
    if ($address_data !== false) {
        $address = $address_data['property_address'];
    }


    return array(
        'position' => $position,
        'marker' => ere_property_get_map_marker($property_id),
        'popup' => array(
            'title' => get_the_title($property_id),
            'url' => get_the_permalink($property_id),
            'thumb' => $property_image,
            'price' => $price,
            'address' => $address,
        )
    );
}

function ere_property_get_nearby_places_data($property_id) {
    $position = ere_property_get_map_position($property_id);
    if ($position === false) {
        return false;
    }
    $nearby_places_radius = ere_get_option('nearby_places_radius');
    $nearby_places_rank_by = ere_get_option('nearby_places_rank_by');
    $nearby_places_distance_in = ere_get_option('nearby_places_distance_in');
    $nearby_places_field = ere_get_option('nearby_places_field');
    $fields = array();
    $types = array();
    if (is_array($nearby_places_field)) {
        foreach ($nearby_places_field as $k => $v) {
            $type = isset($v['nearby_places_select_field_type']) ? $v['nearby_places_select_field_type'] : '';
            $label = isset($v['nearby_places_field_label']) ? $v['nearby_places_field_label'] : '';
            $icon = isset($v['nearby_places_field_icon']) && isset($v['nearby_places_field_icon']['url']) ? $v['nearby_places_field_icon']['url'] : '';
            if (in_array($type,array('establishment','food','health','place_of_worship'))) {
                continue;
            }
            $fields[$type] = array(
              'icon' => $icon,
              'label' => $label
            );
            $types[] = $type;
        }
    }
    if (empty($nearby_places_radius)) {
        $nearby_places_radius = '5000';
    }

    if (empty($fields)) {
        return false;
    }

    $separator = ere_get_price_decimal_separator();
    $map_height = ere_get_option('set_map_height');
    if (empty($map_height)) {
        $map_height = '475';
    }

    return apply_filters('ere_property_nearby_places_data',array(
        'radius' => $nearby_places_radius,
        'rankPreference' => $nearby_places_rank_by,
        'unit' => $nearby_places_distance_in,
        'fields' => $fields,
        'types' => $types,
        'position' => $position,
        'separator' => $separator,
        'map_height' => $map_height,
        'i18n' => array(
            'no_result' => esc_html__( 'No result!', 'essential-real-estate' )
        )
    ));
}

function ere_property_get_walk_score_data($property_id) {

    $api_key = ere_get_option('walk_score_api_key', '');
    if (empty($api_key)) {
        return false;
    }

    $position = ere_property_get_map_position($property_id);
    if ($position === false) {
        return false;
    }

    $url_request = sprintf("http://api.walkscore.com/score?format=json&transit=1&bike=1&address=%s&lat=%s&lon=%s&wsapikey=%s",
        urlencode($position['address']),
        $position['lat'],
        $position['lng'],
        $api_key);
    $request = wp_remote_get($url_request);

    if( is_wp_error( $request ) ) {
        return false;
    }

    $body = wp_remote_retrieve_body( $request );

    $data = json_decode( $body );

    if( empty( $data ) ) {
        return false;
    }

    if ($data->status !== 1) {
        return false;
    }

    $items = array();
    if (!empty($data->walkscore)) {
        $items['walk'] = array(
            'title' => esc_html__('Walk Score', 'essential-real-estate'),
            'score' => $data->walkscore,
            'desc' => $data->description ?? '',
            'url' => $data->ws_link ?? ''
        );
    }

    if (isset($data->transit) && !empty($data->transit->score)) {
        $items['transit'] = array(
            'title' => esc_html__('Transit Score', 'essential-real-estate'),
            'score' => $data->transit->score,
            'desc' => $data->transit->description ?? '',
            'url' => $data->ws_link ?? ''
        );
    }

    if (isset($data->bike) && !empty($data->bike->score)) {
        $items['bike'] = array(
            'title' => esc_html__('Bike Score', 'essential-real-estate'),
            'score' => $data->bike->score,
            'desc' => $data->bike->description ?? '',
            'url' => $data->ws_link ?? ''
        );
    }


    return apply_filters('ere_property_walk_score_data',array(
        'logo' =>  $data->logo_url ?? '',
        'items' => $items
    ));
}

function ere_property_get_total_views($property_id) {
    return  ERE_Property::getInstance()->get_total_views($property_id);
}

function ere_property_get_total_by_user($agent_id, $user_id) {
    return ERE_Property::getInstance()->get_total_properties_by_user( $agent_id, $user_id );
}

function ere_my_property_get_action($property_id) {
    $actions = array(
        'edit' => array(
            'label' => __('Edit', 'essential-real-estate'),
            'tooltip' => __('Edit property', 'essential-real-estate'),
            'nonce' => false,
            'confirm' => ''
        ),
        'mark_featured' => array(
            'label' => __('Mark featured', 'essential-real-estate'),
            'tooltip' => __('Make this a Featured Property', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to mark this property as Featured?', 'essential-real-estate')
        ),
        'allow_edit' => array(
            'label' => __('Allow Editing', 'essential-real-estate'),
            'tooltip' => __('This property listing belongs to an expired Package therefore if you wish to edit it, it will be charged as a new listing from your current Package.', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to allow editing this property listing?', 'essential-real-estate')
        ),
        'remove_featured' => array(
            'label' => __('Remove featured', 'essential-real-estate'),
            'tooltip' => __('Remove Featured of Property', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to remove featured of property?', 'essential-real-estate')
        ),
        'relist_per_package' => array(
            'label' => __('Reactivate Listing', 'essential-real-estate'),
            'tooltip' => __('Reactivate Listing', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to reactivate this property?', 'essential-real-estate')
        ),
        'relist_per_listing' => array(
            'label' => __('Resend this Listing for Approval', 'essential-real-estate'),
            'tooltip' => __('Resend this Listing for Approval', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to resend this property for approval?', 'essential-real-estate')
        ),
        'show' => array(
            'label' => __('Show', 'essential-real-estate'),
            'tooltip' => __('Show Property', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to show this property?', 'essential-real-estate')
        ),
        'delete' => array(
            'label' => __('Delete', 'essential-real-estate'),
            'tooltip' => __('Delete Property', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to delete this property?', 'essential-real-estate')
        ),
        'hidden' => array(
            'label' => __('Hide', 'essential-real-estate'),
            'tooltip' => __('Hide Property', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to hide this property?', 'essential-real-estate')
        ),
        'payment_listing' => array(
            'label' => __('Pay Now', 'essential-real-estate'),
            'tooltip' => __('Pay for this property listing', 'essential-real-estate'),
            'nonce' => true,
            'confirm' => esc_html__('Are you sure you want to pay for this listing?', 'essential-real-estate')
        )
    );
    $actions_key = array();
    $post_status = get_post_status($property_id);
    $paid_submission_type = ere_get_option('paid_submission_type', 'no');
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;
    $prop_featured = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_featured', true);
    $check_package = ERE_Profile::getInstance()->user_package_available($user_id);
    $payment_status = get_post_meta($property_id, ERE_METABOX_PREFIX . 'payment_status', true);
    $price_per_listing = ere_get_option('price_per_listing', 0);
    switch ($post_status) {
        case 'publish':
            if ($paid_submission_type === 'per_package') {
                $current_package_key = get_the_author_meta(ERE_METABOX_PREFIX . 'package_key', $user_id);
                $property_package_key = get_post_meta($property_id, ERE_METABOX_PREFIX . 'package_key', true);
                if (!empty($property_package_key) && ($current_package_key == $property_package_key)) {
                    if (($check_package != -1) && ($check_package != 0)) {
                        $actions_key[] = 'edit';
                        $package_num_featured_listings = get_the_author_meta(ERE_METABOX_PREFIX . 'package_number_featured', $user_id);
                        if (($package_num_featured_listings > 0) && ($prop_featured != 1)) {
                            $actions_key[] = 'mark_featured';
                        }
                    }
                }

                if (($current_package_key != $property_package_key) && ($check_package == 1)) {
                    $actions_key[] = 'allow_edit';
                }
            } else {
                if (($paid_submission_type === 'per_listing') && ($prop_featured != 1) ) {
                    $actions_key[] = 'mark_featured';
                }
                $actions_key[] = 'edit';
            }

            if ($prop_featured == 1) {
                $actions_key[] = 'remove_featured';
            }
            $actions_key[] = 'hidden';
            break;
        case 'expired':
            if ($paid_submission_type === 'per_package') {
                if ($check_package == 1) {
                    $actions_key[] = 'relist_per_package';
                }
            }

            if (($paid_submission_type === 'per_listing') && (($payment_status === 'paid') || ($price_per_listing <= 0))  ) {
                $actions_key[] = 'relist_per_listing';
            }
            break;
        case 'pending':
            $actions_key[] = 'edit';
            break;
        case 'hidden':
            $actions_key[] = 'show';
            break;
    }

    $actions_key[] = 'delete';

    if (($paid_submission_type == 'per_listing') && ($payment_status != 'paid') && ($post_status != 'hidden')) {
        if ($price_per_listing > 0) {
            $actions_key[] = 'payment_listing';
        }
    }

    foreach ($actions as $k => $v) {
        if (!in_array($k,$actions_key)) {
            unset($actions[$k]);
        }
    }
    $actions = apply_filters('ere_my_properties_actions', $actions, get_post($property_id));
    return $actions;
}

function ere_get_my_property_image_size()
{
    return apply_filters('ere_my_property_image_size', '150x150');
}

/**
 * Check current user is ere_customer role
 *
 * @return bool
 */
function ere_is_cap_customer() {
    return current_user_can('ere_customer') || current_user_can('administrator');
}
