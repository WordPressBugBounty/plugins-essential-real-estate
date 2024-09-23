<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

function ere_template_loop_property_price( $property_id = '') {
    if (is_array($property_id)) {
        $args          = wp_parse_args( $property_id, array(
            'property_id' => get_the_ID(),
        ));
        $property_id = $args['property_id'];
    } elseif (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $data = ere_property_get_price_data($property_id);
	ere_get_template( 'loop/property-price.php', apply_filters('ere_template_loop_property_price_args',$data));
}

function ere_template_single_property_price($property_id = '' ) {
    if (is_array($property_id)) {
        $args          = wp_parse_args( $property_id, array(
            'property_id' => get_the_ID(),
        ));
        $property_id = $args['property_id'];
    } elseif (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $data = ere_property_get_price_data($property_id);
    $data['extra_class'] = 'ere__single-property-price';
    ere_get_template( 'loop/property-price.php', apply_filters('ere_template_single_property_price_args',$data));
}

function ere_template_loop_property_title($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}
	ere_get_template('loop/property-title.php',array('property_id' => $property_id));
}

function ere_template_loop_property_location($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}
    $data = ere_property_get_address_data($property_id);
    if ($data === false) {
        return;
    }

	ere_get_template( 'loop/property-location.php',$data);
}

function ere_template_single_property_location($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $data = ere_property_get_address_data($property_id);
    if ($data === false) {
        return;
    }

    $data['extra_class'] = 'ere__single-property-location';
    ere_get_template( 'loop/property-location.php',$data);
}


function ere_template_single_property_gallery($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_gallery = ere_get_property_gallery_image($args['property_id']);
    if ($property_gallery === false || count($property_gallery) === 0) {
        return;
    }
    ere_get_template( 'single-property/gallery.php',array(
        'property_gallery' => $property_gallery
    ) );
}

function ere_template_single_property_description() {
    ere_get_template( 'single-property/description.php' );
}

function ere_template_single_property_address() {
    $data = ere_get_single_property_address_data();
    if (empty($data)) {
        return;
    }
    $google_map_address_url  = '';
    $location  = ere_property_get_address_data();
    if ($location !== false) {
        $google_map_address_url = $location['google_map_address_url'];
    }
    ere_get_template( 'single-property/address.php',array(
        'data' => $data,
        'google_map_address_url' => $google_map_address_url
    ) );
}

function ere_template_single_property_map($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_map_directions = ere_get_option( 'enable_map_directions', 1 );
    if (filter_var($enable_map_directions, FILTER_VALIDATE_BOOLEAN) === false) {
        return;
    }

    $position = ere_property_get_map_position($property_id);
    if ($position === false) {
        return;
    }

    ere_get_template( 'single-property/map.php',array('property_id' => $property_id));

}

function ere_template_single_property_floor($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}
	$property_floor_enable = boolval(get_post_meta($property_id,ERE_METABOX_PREFIX . 'floors_enable', TRUE));
	if ($property_floor_enable === FALSE) {
		return;
	}
	$property_floors       = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'floors', true );
	if (!is_array($property_floors) && count($property_floors) == 0) {
		return;
	}

	ere_get_template( 'single-property/floors.php', array( 'property_floors' => $property_floors ) );
}

function ere_template_single_property_attachments($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_attachments = get_post_meta($property_id, ERE_METABOX_PREFIX . 'property_attachments', true);
    if (empty($property_attachments)) {
        return;
    }
    $property_attachments = explode('|', $property_attachments);
    $property_attachments = array_unique($property_attachments);
    if (empty($property_attachments)) {
        return;
    }

    $attachments = array();
    foreach ($property_attachments as $attach_id) {
        $attach_url = wp_get_attachment_url($attach_id);
        if ($attach_url === false) {
            continue;
        }

        $file_type = wp_check_filetype($attach_url);
        $file_type = isset($file_type['ext']) ? $file_type['ext'] : '';
        if (empty($file_type)) {
            continue;
        }

        $thumb = ERE_PLUGIN_URL . 'public/assets/images/attachment/attach-' . $file_type . '.png';
        $file_name = basename($attach_url);

        $attachments[] = array(
          'url' => $attach_url,
          'thumb' => $thumb,
          'name' => $file_name
        );
    }

    if (count($attachments) === 0) {
        return;
    }



    ere_get_template( 'single-property/attachments.php',array(
        'attachments' =>  $attachments) );
}

function ere_template_single_property_features($property_id = '') {
	if (empty($property_id)) {
		$property_id = get_the_ID();
	}

    $tabs = ere_get_single_property_features_tabs($property_id);

    if ( empty( $tabs ) ) {
        return;
    }
    $wrapper_classes = array(
        'single-property-element',
        'property-info-tabs',
        'property-tab'
    );
    $wrapper_class = join(' ', $wrapper_classes);
    ere_get_template( 'global/tabs.php', array('tabs' => $tabs,'extend_class' => $wrapper_class) );
}

function ere_template_single_property_overview($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $data = ere_get_single_property_overview($args['property_id']);
    if (empty($data)) {
        return;
    }
    ere_get_template('single-property/overview.php', array('data' => $data));
}

function ere_template_single_property_feature($args = array())
{
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $features = ere_get_property_features($args);

    if (($features === false ) || empty($features)) {
        return;
    }

    ere_get_template('single-property/feature.php',array('features' => $features));
}

function ere_template_single_property_video($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $video = ere_get_property_video($args);
    if ($video === false) {
        return;
    }
    ere_get_template('single-property/video.php',$video);
}

function ere_template_single_property_virtual_tour($args = array()) {
    $args          = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $virtual_tour =  ere_get_property_virtual_tour($args);
    if ($virtual_tour === false) {
        return;
    }
    ere_get_template('single-property/virtual-tour.php',$virtual_tour);
}

function ere_template_single_property_identity($args = array() ) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_identity = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_identity', true );
    if ( empty( $property_identity ) ) {
        $property_identity = get_the_ID();
    }

    ere_get_template('single-property/data/identity.php', array( 'property_identity' => $property_identity ));


}

function ere_template_single_property_type($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_type = get_the_term_list( $args['property_id'], 'property-type', '', ', ', '' );
    if ( $property_type === false || is_a( $property_type, 'WP_Error' ) ) {
        return;
    }
    ere_get_template( 'single-property/data/type.php', array( 'property_type' => $property_type ) );

}

function ere_template_single_property_data_status($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_status = get_the_term_list( $args['property_id'], 'property-status', '', ', ', '' );
    if ( $property_status === false || is_a( $property_status, 'WP_Error' ) ) {
        return;
    }

    ere_get_template( 'single-property/data/status.php', array( 'property_status' => $property_status ) );
}

function ere_template_single_property_rooms($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_rooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_rooms', true );
    if ( $property_rooms === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/rooms.php', array(
        'rooms' => $property_rooms
    ) );
}

function ere_template_single_property_bedrooms($args = array()){
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_bedrooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_bedrooms', true );
    if ( $property_bedrooms === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/bedrooms.php', array( 'property_bedrooms' => $property_bedrooms ) );
}

function ere_template_single_property_bathrooms($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_bathrooms = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_bathrooms', true );
    if ( $property_bathrooms === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/bathrooms.php', array( 'property_bathrooms' => $property_bathrooms ) );
}

function ere_template_single_property_year($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_year = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_year', true );
    if ( $property_year === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/year.php', array( 'property_year' => $property_year ) );
}

function ere_template_single_property_size($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_size = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_size', true );
    if ( $property_size === '' ) {
        return;
    }
    $measurement_units = ere_get_measurement_units();
    ere_get_template( 'single-property/data/size.php', array(
        'property_size'     => $property_size,
        'measurement_units' => $measurement_units
    ) );
}

function ere_template_single_property_land_size($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );
    $property_land = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_land', true );
    if ( $property_land === '' ) {
        return;
    }
    $measurement_units_land_area = ere_get_measurement_units_land_area();
    ere_get_template( 'single-property/data/land-size.php', array(
        'property_land'               => $property_land,
        'measurement_units_land_area' => $measurement_units_land_area
    ) );
}

function ere_template_single_property_label($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_label = get_the_term_list( $args['property_id'], 'property-label', '', ', ', '' );
    if ( $property_label === false || is_a( $property_label, 'WP_Error' ) ) {
        return;
    }
    ere_get_template( 'single-property/data/label.php', array( 'property_label' => $property_label ) );
}
function ere_template_single_property_garage($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $property_garage = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_garage', true );
    if ( $property_garage === '' ) {
        return;
    }
    ere_get_template( 'single-property/data/garage.php', array( 'property_garage' => $property_garage ) );
}

function ere_template_single_property_garage_size($args = array()) {
    $args = wp_parse_args( $args, array(
        'property_id' => get_the_ID(),
    ) );

    $garage_size = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_garage_size', true );
    if ( $garage_size === '' ) {
        return;
    }
    $measurement_units = ere_get_measurement_units();
    ere_get_template( 'single-property/data/garage-size.php', array(
        'garage_size'       => $garage_size,
        'measurement_units' => $measurement_units
    ) );
}

function ere_template_single_property_info($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    ere_get_template( 'single-property/property-info.php', array(
        'property_id'       => $property_id
    ));
}



function ere_template_property_search_form($atts = array(),$css_class_field = '', $css_class_half_field = '', $show_status_tab = true) {
    $args = array(
        'atts' => $atts,
        'show_status_tab'        => $show_status_tab,
        'css_class_field'      => $css_class_field,
        'css_class_half_field' => $css_class_half_field,
    );
    ere_get_template('property/search-form.php', $args);
}

function ere_template_property_map_search($extend_class) {
    $map_id = 'ere_result_map-'.wp_rand();
    ere_get_template('property/search-map.php',array(
        'extend_class' => $extend_class,
        'map_id' => $map_id
    ));
}

function ere_template_loop_property_action($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-action.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_action_view_gallery($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_gallery = ere_get_property_gallery_image($property_id);
    $total_image = 0;
    if ($property_gallery) {
        $total_image = count($property_gallery);
    }
    ere_get_template( 'loop/property-action/view-gallery.php', array(
        'property_id'       => $property_id,
        'total_image' => $total_image
    ));

}

function ere_template_loop_property_action_favorite($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_favorite_property = ere_get_option( 'enable_favorite_property', '1' );
    if (!filter_var($enable_favorite_property, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    global $current_user;
    wp_get_current_user();
    $key = false;
    $user_id = $current_user->ID;
    $my_favorites = get_user_meta($user_id, ERE_METABOX_PREFIX . 'favorites_property', true);
    if (!empty($my_favorites)) {
        $key = array_search($property_id, $my_favorites);
    }
    $icon_favorite = apply_filters('ere_icon_favorite','fa fa-star') ;
    $icon_not_favorite = apply_filters('ere_icon_not_favorite','fa fa-star-o');

    if ($key !== false) {
        $icon_class = $icon_favorite;
        $title = esc_attr__('It is my favorite', 'essential-real-estate');
    } else {
        $icon_class = $icon_not_favorite;
        $title = esc_attr__('Add to Favorite', 'essential-real-estate');
    }


    ere_get_template( 'loop/property-action/favorite.php', array(
        'property_id'       => $property_id,
        'icon_class' => $icon_class,
        'title' => $title,
        'icon_favorite' => $icon_favorite,
        'icon_not_favorite' => $icon_not_favorite
    ));
}

function ere_template_loop_property_action_compare($property_id) {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_compare_properties =  ere_get_option( 'enable_compare_properties', '1' );
    if (!filter_var($enable_compare_properties, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    ere_get_template( 'loop/property-action/compare.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_thumbnail($args = array())
{
    $args = wp_parse_args($args,array(
        'property_id'       => get_the_ID(),
        'image_size' => '',
        'extra_classes' => ''
    ));

    ere_get_template('loop/property-thumbnail.php', array(
        'property_id' => $args['property_id'],
        'image_size' => $args['image_size'],
        'extra_classes' => $args['extra_classes']
    ));
}

function ere_template_loop_property_image($args = array()) {
    $image_size = ere_get_option( 'archive_property_image_size', ere_get_loop_property_image_size_default() );
    $args = wp_parse_args($args,array(
        'property_id'       => get_the_ID(),
        'image_size' => $image_size,
        'image_size_default' => ere_get_loop_property_image_size_default()
    ));
    ere_get_template('loop/property-image.php',array(
        'property_id'       => $args['property_id'],
        'image_size' => $args['image_size'],
        'image_size_default' => $args['image_size_default']
    ));

}


function ere_template_loop_property_featured_label($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }

    $property_badge = ere_get_loop_property_featured_label($args['property_id']);
    if ( empty( $property_badge ) ) {
        return;
    }

    ere_get_template('loop/property-badge.php', array(
        'badge' => $property_badge,
        'extra_classes' => 'ere__lpb-featured-label'
    ));

}

function ere_template_loop_property_term_status($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }

    $property_item_status = get_the_terms( $args['property_id'], 'property-status' );
    if ( $property_item_status === false || is_a( $property_item_status, 'WP_Error' ) ) {
        return;
    }

    ere_get_template('loop/property-term-status.php', array(
        'property_item_status' => $property_item_status
    ));
}

function ere_template_loop_property_status($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }

    $property_item_status = ere_property_get_status($args['property_id']);
    if ($property_item_status === false) {
        return;
    }

    ere_get_template('loop/property-status.php', array(
        'property_item_status' => $property_item_status
    ));
}

function ere_template_single_property_status($args = array())
{
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }

    $property_item_status = ere_property_get_status($args['property_id']);
    if ($property_item_status === false) {
        return;
    }

    ere_get_template('loop/property-status.php', array(
        'property_item_status' => $property_item_status,
        'extra_class' => 'ere__single-property-status'
    ));
}

function ere_template_loop_property_featured($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }
    $property_featured = get_post_meta( $args['property_id'], ERE_METABOX_PREFIX . 'property_featured', true );
    if ( !filter_var($property_featured, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }
    ere_get_template('loop/property-featured.php');
}

function ere_template_loop_property_term_label($args = array()) {
    if (is_array($args)) {
        $args = wp_parse_args($args,array(
            'property_id'       => get_the_ID(),
        ));
    } else {
        $args = wp_parse_args($args,array(
            'property_id'       => $args,
        ));
    }
    $property_term_label = get_the_terms( $args['property_id'], 'property-label' );
    if ( $property_term_label === false || is_a( $property_term_label, 'WP_Error' ) ) {
        return;
    }

    ere_get_template('loop/property-term-label.php', array(
        'property_term_label' => $property_term_label
    ));

}

function ere_template_loop_property_link($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-link.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_link_detail($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-link-detail.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_excerpt($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $excerpt            = get_the_excerpt($property_id);
    if (empty($excerpt)) {
        return;
    }
    ere_get_template( 'loop/property-excerpt.php', array(
        'excerpt'       => $excerpt,
    ));
}

function ere_template_loop_property_meta($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    ere_get_template( 'loop/property-meta.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_info($property_id = '', $layout = 'layout-1') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    ere_get_template( 'loop/property-info.php', array(
        'property_id'       => $property_id,
        'layout' => $layout
    ));
}

function ere_template_loop_property_info_layout_2($property_id = '') {
    ere_template_loop_property_info($property_id,'layout-2');
}

function ere_template_heading($args = array()) {
    $args = wp_parse_args($args, array(
            'heading_text_align' => '',
            'heading_title' => '',
            'heading_sub_title' => '',
            'color_scheme' => '',
            'extra_classes' => array()
        ));
    if (empty($args['heading_title']) && empty($args['heading_sub_title'])) {
        return;
    }
    ere_get_template('global/heading.php', $args);
}

function ere_template_loop_property_type($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-type.php', array(
        'property_id'       => $property_id,
    ));

}

function ere_template_loop_property_agent($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $agent_info = ere_get_agent_info_of_property($property_id);
    if ($agent_info === false) {
        return;
    }
    ere_get_template( 'loop/property-agent.php',$agent_info);

}

function ere_template_loop_property_date($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'loop/property-date.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_loop_property_size($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_size = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_size', true );
    if ( $property_size === '' ) {
        return;
    }
    $measurement_units = ere_get_measurement_units();
    ere_get_template( 'loop/property-size.php', array(
        'property_size'     => $property_size,
        'measurement_units' => $measurement_units
    ) );
}

function ere_template_loop_property_identity($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_identity = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_identity', true );
    if ( empty( $property_identity ) ) {
        $property_identity = get_the_ID();
    }
    ere_get_template( 'loop/property-identity.php', array(
        'property_identity'     => $property_identity
    ) );
}

function ere_template_loop_property_bedrooms($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_bedrooms = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_bedrooms', true );
    if ( $property_bedrooms === '' ) {
        return;
    }
    ere_get_template( 'loop/property-bedrooms.php', array( 'property_bedrooms' => $property_bedrooms ) );
}

function ere_template_loop_property_bathrooms($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_bathrooms = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_bathrooms', true );
    if ( $property_bathrooms === '' ) {
        return;
    }
    ere_get_template( 'loop/property-bathrooms.php', array( 'property_bathrooms' => $property_bathrooms ) );
}

function ere_template_loop_property_garages($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_garage = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_garage', true );
    if ( $property_garage === '' ) {
        return;
    }
    ere_get_template( 'loop/property-garage.php', array( 'property_garage' => $property_garage ) );
}

function ere_template_archive_property_action() {
    ere_get_template('archive-property/action.php');
}

function ere_template_archive_property_heading($total_post = 0, $taxonomy_title = '', $agent_id = 0, $author_id = 0 ) {
    ere_get_template( 'archive-property/heading.php', array(
        'total_post'     => $total_post,
        'taxonomy_title' => $taxonomy_title,
        'agent_id'       => $agent_id,
        'author_id'      => $author_id
    ) );
}

function ere_template_archive_property_action_status() {
    if (!(is_post_type_archive('property') || is_page('properties')) && !is_tax(get_object_taxonomies('property'))) {
        return;
    }
    ere_get_template('archive-property/actions/status.php');
}

function ere_template_archive_property_action_switch_layout() {
    ere_get_template('archive-property/actions/switch-layout.php');
}

function ere_template_archive_property_action_orderby() {
    $sort_by_list = ere_get_property_sort_by();
    ere_get_template('archive-property/actions/orderby.php',array('sort_by_list' => $sort_by_list));
}

function ere_template_property_advanced_search_form($parameters,$search_query) {
    $enable_advanced_search_form = ere_get_option( 'enable_advanced_search_form', '1' );
    if (!filter_var($enable_advanced_search_form, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }

    $enable_advanced_search_status_tab = ere_get_option( 'enable_advanced_search_status_tab', '1' );
    $property_price_field_layout = ere_get_option( 'advanced_search_price_field_layout', '0' );
    $property_size_field_layout  = ere_get_option( 'advanced_search_size_field_layout', '0' );
    $property_land_field_layout  = ere_get_option( 'advanced_search_land_field_layout', '0' );
    $shortcode_attr = array(
        'layout'                   =>  "tab",
        'column'                   => 3,
        'color_scheme'             => "color-dark",
        'status_enable'            => "true",
        'type_enable'              => "true",
        'keyword_enable'           => "true",
        'title_enable'             => "true",
        'address_enable'           => "true",
        'country_enable'           => "true",
        'state_enable'             => "true",
        'city_enable'              => "true",
        'neighborhood_enable'      => "true",
        'rooms_enable'             => "true",
        'bedrooms_enable'          => "true",
        'bathrooms_enable'         => "true",
        'price_enable'             => "true",
        'price_is_slider'          => ( $property_price_field_layout == '1' ) ? 'true' : 'false',
        'area_enable'              => "true",
        'area_is_slider'           => ( $property_size_field_layout == '1' ) ? 'true' : 'false',
        'land_area_enable'         => "true",
        'land_area_is_slider'      => ( $property_land_field_layout == '1' ) ? 'true' : 'false',
        'label_enable'             => "true",
        'garage_enable'            => "true",
        'property_identity_enable' => "true",
        'other_features_enable'    => "true",
    );
    $additional_fields      = ere_get_search_additional_fields();
    foreach ( $additional_fields as $k => $v ) {
        $shortcode_attr["{$k}_enable"] = "true";
    }
    $enable_saved_search = ere_get_option('enable_saved_search', 1);
    if (!filter_var($enable_advanced_search_status_tab, FILTER_VALIDATE_BOOLEAN)) {
        $shortcode_attr['layout'] = '';
    }
    ere_get_template('property/advanced-search-form.php', array(
        'atts' => $shortcode_attr,
        'enable_saved_search' => $enable_saved_search,
        'parameters' => $parameters,
        'search_query' => $search_query
    ));
}

function ere_template_single_property_reviews(){
    $enable_comments_reviews_property = ere_get_option( 'enable_comments_reviews_property', 1 );
    if ( $enable_comments_reviews_property == 2 ) {
        $rating = 0;
        $total_reviews = 0;
        $total_stars = 0;
        $my_rating = 0;
        $my_comment = '';
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $property_id = get_the_ID();
        $rating_data = ere_property_get_rating($property_id);

        $comments = ere_property_get_list_review($property_id, $user_id);
        if ( $comments !== null ) {
            foreach ( $comments as $comment ) {
                if ( $comment->comment_approved == 1 ) {
                    $total_reviews++;
                    $total_stars += $comment->meta_value;
                }
            }
            if ( $total_reviews > 0 ) {
                $rating = ( $total_stars / $total_reviews );
            }
        }


        $my_review = ere_property_get_review_by_user_id($property_id,$user_id);
        if ($my_review !== null) {
            $my_comment = $my_review->comment_content;
            $my_rating = $my_review->rate;
        }


        $wrapper_classes  = array(
            'single-property-element',
            'ere__single-property-element',
            'ere__single-property-review'
        );

        $wrapper_class =  join(' ', apply_filters('ere_single_property_review_wrapper_classes',$wrapper_classes));

        ere_get_template('global/reviews.php',array(
            'extra_class' => $wrapper_class,
            'rating' => $rating,
            'total_reviews' => $total_reviews,
            'rating_data' => $rating_data,
            'type' => 'property',
            'comments' => $comments,
            'my_rating' => $my_rating,
            'my_comment' => $my_comment
        ));
    }
}

function ere_template_single_property_header()
{
    ere_get_template( 'single-property/header.php' );
}

function ere_template_single_property_title() {
    ere_get_template('single-property/title.php');
}

function ere_template_single_property_header_price_location() {
    ere_get_template('single-property/header/price-location.php');
}

function ere_template_single_property_header_meta_action() {
    ere_get_template('single-property/header/meta-action.php');
}

function ere_template_single_property_action($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template( 'single-property/property-action.php', array(
        'property_id'       => $property_id,
    ));
}

function ere_template_single_property_action_social_share() {
    $enable_social_share = ere_get_option('enable_social_share', '1');
    if (filter_var($enable_social_share,FILTER_VALIDATE_BOOLEAN) === false ) {
        return;
    }

    ere_get_template('global/social-share.php', array(
        'extra_class' => 'ere__single-property-social-share ere__loop-property_action-item'
    ));
}

function ere_template_single_property_action_print($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_print_property = ere_get_option('enable_print_property','1');
    if (filter_var($enable_print_property,FILTER_VALIDATE_BOOLEAN) === false) {
        return;
    }

    ere_get_template( 'single-property/action/print.php', array(
        'property_id'       => $property_id,
    ));


}

function ere_template_single_property_nearby_places($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $enable_nearby_places = ere_get_option( 'enable_nearby_places', 1 );
    if (filter_var($enable_nearby_places, FILTER_VALIDATE_BOOLEAN) === false) {
        return;
    }

    $data = ere_property_get_nearby_places_data($property_id);
    if ($data === false) {
        return;
    }
    ere_get_template( 'single-property/nearby-places.php', array( 'property_id' => $property_id, 'data' => $data ) );
}

function ere_template_single_property_walk_score($property_id = '')
{
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $enable_walk_score = ere_get_option( 'enable_walk_score', 0 );
    if (filter_var($enable_walk_score, FILTER_VALIDATE_BOOLEAN) === false) {
        return;
    }
    $data = ere_property_get_walk_score_data($property_id);
    ere_get_template( 'single-property/walk-score.php', array( 'property_id' => $property_id,'data' => $data) );
}

function ere_template_single_property_contact_agent($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $property_form_sections = ere_get_option( 'property_form_sections', ere_get_property_form_section_config_default() );
    if (!in_array( 'contact', $property_form_sections )) {
        return;
    }

    $agent_display_option = get_post_meta($property_id,ERE_METABOX_PREFIX . 'agent_display_option', true);
    if ($agent_display_option === 'no') {
        return;
    }
    $agent_info = ere_get_agent_contact_info_of_property($property_id);
    if ($agent_info['is_login']) {
        ere_get_template( 'single-property/contact-agent.php', $agent_info);
    } else {
        ere_get_template( 'single-property/contact-agent-not-login.php');
    }
}

function ere_template_single_property_footer($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $enable_create_date = ere_get_option('enable_create_date', 1);
    $enable_views_count = ere_get_option('enable_views_count', 1);

    $enable_create_date = filter_var($enable_create_date,FILTER_VALIDATE_BOOLEAN);
    $enable_views_count = filter_var($enable_views_count,FILTER_VALIDATE_BOOLEAN);

    if (!$enable_create_date && !$enable_views_count) {
        return;
    }
    $total_views = 0;
    if ($enable_views_count) {
        $total_views = ere_property_get_total_views($property_id);
    }
    ere_get_template( 'single-property/footer.php', array(
        'property_id' => $property_id,
        'enable_create_date' => $enable_create_date,
        'enable_views_count' => $enable_views_count,
        'total_views' => $total_views
    ) );
}

function ere_template_print_property_logo()
{
    ere_get_template('property/print/logo.php');
}
function ere_template_print_property_header()
{
    ere_get_template('property/print/header.php');
}

function ere_template_print_property_qr_image()
{
    ere_get_template('property/print/qr-image.php',array('property_id' => get_the_ID()));
}

function ere_template_print_property_image() {
    if (!has_post_thumbnail()) {
        return;
    }
    ?>
        <div class="ere__print-property-image">
            <?php
            $image_size = '1160x500';
            ere_template_loop_property_image(array(
                'property_id'       => get_the_ID(),
                'image_size' => $image_size,
                'image_size_default' => $image_size
            ));
            ?>
        </div>
    <?php
}

function ere_template_print_property_floor($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_floor_enable = boolval(get_post_meta($property_id,ERE_METABOX_PREFIX . 'floors_enable', TRUE));
    if ($property_floor_enable === FALSE) {
        return;
    }
    $property_floors       = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'floors', true );
    if (!is_array($property_floors) && count($property_floors) == 0) {
        return;
    }

    ere_get_template( 'property/print/floors.php', array( 'property_floors' => $property_floors ) );
}

function ere_template_print_property_contact_agent($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $agent_display_option = get_post_meta($property_id,ERE_METABOX_PREFIX . 'agent_display_option', true);
    if ($agent_display_option === 'no') {
        return;
    }
    $agent_info = ere_get_agent_contact_info_of_property($property_id);
    if (!$agent_info['is_login']) {
        return;
    }
    ere_get_template( 'property/print/contact-agent.php', $agent_info);
}


function ere_template_my_property_search()
{
    ere_get_template('property/my-property/search.php');
}

function ere_template_my_property_filter() {
    ere_get_template('property/my-property/filter.php');
}


function ere_template_loop_my_property_title($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    ere_get_template('property/my-property/loop/title.php',array('property_id' => $property_id));
}

function ere_template_loop_my_property_meta() {
    ere_get_template('property/my-property/loop/meta.php');
}
function ere_template_loop_my_property_action($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $actions = ere_my_property_get_action($property_id);
    ere_get_template('property/my-property/loop/action.php',array('property_id' => $property_id,'actions' => $actions));
}

function ere_template_loop_my_property_meta_view($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $total_views = ERE_Property::getInstance()->get_total_views($property_id);
    ere_get_template('property/my-property/loop/meta/view.php',array('total_views' => $total_views));
}

function ere_template_loop_my_property_meta_date() {
    ere_get_template('property/my-property/loop/meta/date.php');
}

function ere_template_loop_my_property_meta_expire_date($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $paid_submission_type = ere_get_option('paid_submission_type', 'no');
    if ($paid_submission_type != 'per_listing') {
        return;
    }
    $listing_expire = ere_get_option('per_listing_expire_days');
    if ($listing_expire != 1) {
        return;
    }
    ere_get_template('property/my-property/loop/meta/expire-date.php',array('property_id' => $property_id));
}


function ere_template_loop_my_property_featured($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $property_featured = get_post_meta( $property_id, ERE_METABOX_PREFIX . 'property_featured', true );
    if ( !filter_var($property_featured, FILTER_VALIDATE_BOOLEAN)) {
        return;
    }
    ere_get_template('property/my-property/loop/featured.php');
}

function ere_template_loop_my_property_status($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }

    $status = get_post_status($property_id);

    ere_get_template('property/my-property/loop/status.php',array('status' => $status));
}

function ere_template_loop_my_property_meta_location($property_id = '') {
    if (empty($property_id)) {
        $property_id = get_the_ID();
    }
    $data = ere_property_get_address_data($property_id);
    if ($data === false) {
        return;
    }

    ere_get_template('property/my-property/loop/meta/location.php',$data);
}