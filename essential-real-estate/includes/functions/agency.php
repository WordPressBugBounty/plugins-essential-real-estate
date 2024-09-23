<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

function ere_agency_get_sort_by() {
    return apply_filters('ere_agency_sort_by',array(
        'default' => esc_html__('Default Order','essential-real-estate'),
        'a_name' => esc_html__('Name (A to Z)','essential-real-estate'),
        'd_name' => esc_html__('Name (Z to A)','essential-real-estate'),
        'a_date' => esc_html__('Date (Old to New)','essential-real-estate'),
        'd_date' => esc_html__('Date (New to Old)','essential-real-estate')
    ));
}

function ere_agency_get_social_data($agency_id) {
    $data = array();
    $vimeo = get_term_meta( $agency_id, 'agency_vimeo_url', true );
    $facebook = get_term_meta( $agency_id, 'agency_facebook_url', true );
    $twitter = get_term_meta( $agency_id, 'agency_twitter_url', true );
    $linkedin = get_term_meta( $agency_id, 'agency_linkedin_url', true );
    $pinterest = get_term_meta( $agency_id, 'agency_pinterest_url', true );
    $instagram = get_term_meta( $agency_id, 'agency_instagram_url', true );
    $skype = get_term_meta( $agency_id, 'agency_skype', true );
    $youtube = get_term_meta( $agency_id, 'agency_youtube_url', true );

    if (!empty($facebook)) {
        $data['facebook'] = array(
            'priority' => 10,
            'label'    => esc_html__( 'Facebook', 'essential-real-estate' ),
            'icon' => 'fa fa-facebook',
            'link' => $facebook,
        );
    }

    if (!empty($twitter)) {
        $data['twitter'] = array(
            'priority' => 20,
            'label'    => esc_html__( 'Twitter', 'essential-real-estate' ),
            'icon' => 'fa fa-twitter',
            'link' => $twitter,
        );
    }

    if (!empty($skype)) {
        $data['skype'] = array(
            'priority' => 30,
            'label'    => esc_html__( 'Skype', 'essential-real-estate' ),
            'icon' => 'fa fa-skype',
            'link' => $skype,
        );
    }

    if (!empty($linkedin)) {
        $data['linkedin'] = array(
            'priority' => 40,
            'label'    => esc_html__( 'Linkedin', 'essential-real-estate' ),
            'icon' => 'fa fa-linkedin',
            'link' => $linkedin,
        );
    }

    if (!empty($pinterest)) {
        $data['pinterest'] = array(
            'priority' => 50,
            'label'    => esc_html__( 'Pinterest', 'essential-real-estate' ),
            'icon' => 'fa fa-pinterest',
            'link' => $pinterest,
        );
    }

    if (!empty($instagram)) {
        $data['instagram'] = array(
            'priority' => 60,
            'label'    => esc_html__( 'Instagram', 'essential-real-estate' ),
            'icon' => 'fa fa-instagram',
            'link' => $instagram,
        );
    }

    if (!empty($youtube)) {
        $data['youtube'] = array(
            'priority' => 70,
            'label'    => esc_html__( 'Youtube', 'essential-real-estate' ),
            'icon' => 'fa fa-youtube-play',
            'link' => $youtube,
        );
    }

    if (!empty($vimeo)) {
        $data['vimeo'] = array(
            'priority' => 80,
            'label'    => esc_html__( 'Vimeo', 'essential-real-estate' ),
            'icon' => 'fa fa-vimeo',
            'link' => $vimeo,
        );
    }

    $data = apply_filters( 'ere_agency_social_data', $data );
    uasort( $data, 'ere_sort_by_order_callback' );
    return $data;
}

function ere_agency_get_contact_data_single($agency_id) {
    $data = ere_agency_get_contact_data($agency_id);
    if (isset($data['licenses'])) {
        unset($data['licenses']);
    }
    $data = apply_filters( 'ere_agency_contact_data_single', $data );
    uasort( $data, 'ere_sort_by_order_callback' );
    return $data;
}

function ere_agency_get_contact_data($agency_id) {
    $data = array();

    $email = get_term_meta( $agency_id, 'agency_email', true );
    $mobile_number = get_term_meta( $agency_id, 'agency_mobile_number', true );
    $fax_number = get_term_meta( $agency_id, 'agency_fax_number', true );
    $licenses = get_term_meta( $agency_id, 'agency_licenses', true );
    $office_number = get_term_meta( $agency_id, 'agency_office_number', true );
    $website_url = get_term_meta( $agency_id, 'agency_website_url', true );

    if (!empty($office_number)) {
        $data['office_number'] = array(
            'priority' => 10,
            'label'    => esc_html__( 'Phone', 'essential-real-estate' ),
            'icon' => 'fa fa-phone',
            'value' => $office_number,
        );
    }

    if (!empty($mobile_number)) {
        $data['mobile_number'] = array(
            'priority' => 20,
            'label'    => esc_html__( 'Mobile', 'essential-real-estate' ),
            'icon' => 'fa fa-mobile-phone',
            'value' => $mobile_number,
        );
    }

    if (!empty($fax_number)) {
        $data['fax_number'] = array(
            'priority' => 30,
            'label'    => esc_html__( 'Fax', 'essential-real-estate' ),
            'icon' => 'fa fa-print',
            'value' => $fax_number,
        );
    }

    if (!empty($email)) {
        $data['email'] = array(
            'priority' => 40,
            'label'    => esc_html__( 'Email', 'essential-real-estate' ),
            'icon' => 'fa fa-envelope',
            'value' => $email,
        );
    }

    if (!empty($website_url)) {
        $data['website'] = array(
            'priority' => 50,
            'label'    => esc_html__( 'Website', 'essential-real-estate' ),
            'icon' => 'fa fa-external-link-square',
            'value' => $website_url,
        );
    }

    if (!empty($licenses)) {
        $data['licenses'] = array(
            'priority' => 60,
            'label'    => esc_html__( 'Licenses', 'essential-real-estate' ),
            'icon' => 'fa fa-balance-scale',
            'value' => $licenses,
        );
    }

    $data = apply_filters( 'ere_agency_contact_data', $data );
    uasort( $data, 'ere_sort_by_order_callback' );
    return $data;
}

function ere_agency_get_meta_data($agency_id) {
    $data = array();

    $total_property = ere_agency_get_total_property($agency_id);
    $data['properties'] = array(
        'priority' => 10,
        'label'    => esc_html__( 'Properties', 'essential-real-estate' ),
        'value' => $total_property,
    );

    $total_agent = ere_agency_get_total_agent($agency_id);
    $data['agents'] = array(
        'priority' => 20,
        'label'    => esc_html__( 'Agents', 'essential-real-estate' ),
        'value' => $total_agent,
    );

    $licenses = get_term_meta( $agency_id, 'agency_licenses', true );
    if (!empty($licenses)) {
        $data['licenses'] = array(
            'priority' => 30,
            'label'    => esc_html__( 'Licenses', 'essential-real-estate' ),
            'value' => $licenses,
        );
    }


    $data = apply_filters( 'ere_agency_meta_data', $data );
    uasort( $data, 'ere_sort_by_order_callback' );
    return $data;
}

function ere_agency_get_agent_ids($agency_id) {
    $args         = array(
        'post_type'   => 'agent',
        'post_status' => 'publish',
        'numberposts' => -1,
        'tax_query'   => array(
            array(
                'taxonomy' => 'agency',
                'terms'    => $agency_id,
            )
        )
    );
    $posts = get_posts($args);
    $agent_ids = array();
    $agent_user_ids = array();

    foreach ($posts as $post) {
        $agent_ids[] = $post->ID;
        $agent_user_id = get_post_meta( $post->ID, ERE_METABOX_PREFIX . 'agent_user_id', true );
        if ( ! empty( $agent_user_id ) ) {
            $agent_user_ids[] = $agent_user_id;
        }
    }
    return array(
        'agent_ids' => $agent_ids,
        'agent_user_ids' => $agent_user_ids
    );
}
function ere_agency_get_total_property($agency_id) {
    $data = ere_agency_get_agent_ids($agency_id);
    $agent_ids = $data['agent_ids'];
    $agent_user_ids = $data['agent_user_ids'];
    return ere_property_get_total_by_user($agent_ids,$agent_user_ids);
}

function ere_agency_get_total_agent($agency_id) {
    $total = 0;
    $agency = get_term($agency_id,'agency');
    if (is_a($agency,'WP_Term')) {
        $total = $agency->count;
    }
    return $total;
}

function ere_agency_get_tabs($agency_id) {

    $tabs = array();

    $tabs['overview'] = array(
        'title'    => esc_html__( 'Overview', 'essential-real-estate' ),
        'priority' => 10,
        'callback' => 'ere_template_single_agency_overview',
        'agency_id' => $agency_id
    );

    $tabs['property'] = array(
        'title'    => esc_html__( 'Properties', 'essential-real-estate' ),
        'priority' => 20,
        'callback' => 'ere_template_single_agency_property',
        'agency_id' => $agency_id
    );

    $tabs['location'] = array(
        'title'    => esc_html__( 'Location', 'essential-real-estate' ),
        'priority' => 30,
        'callback' => 'ere_template_single_agency_location',
        'agency_id' => $agency_id
    );

    /*

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
    );*/

    $tabs = apply_filters( 'ere_agency_tabs', $tabs , $agency_id);

    uasort( $tabs, 'ere_sort_by_order_callback' );

    $tabs = array_map( 'ere_content_callback', $tabs );

    return array_filter( $tabs, 'ere_filter_content_callback' );
}

function ere_agency_get_map_position($agency_id) {
    $location = get_term_meta( $agency_id, 'agency_map_address', true );
    if (empty($location)) {
        return false;
    }
    list( $lat, $lng ) =  isset($location['location']) && !empty($location['location']) ? explode( ',', $location['location'] ) : array('', '');
    if (empty($lng) || empty($lat)) {
        return false;
    }
    return array(
        'lat' => floatval($lat) ,
        'lng' => floatval($lng),
    );

}