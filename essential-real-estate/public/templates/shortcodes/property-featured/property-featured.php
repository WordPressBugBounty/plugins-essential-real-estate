<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Shortcode attributes
 * @var $atts
 */
$layout_style = $property_type = $property_status = $property_feature = $property_cities = $property_state =
$property_neighborhood = $property_label = $color_scheme = $item_amount = $include_heading =
$heading_sub_title = $heading_title = $heading_text_align = $property_city = $el_class = $image_size1=$image_size2=$image_size3=$image_size4='';
extract(shortcode_atts(array(
	'layout_style' => 'property-list-two-columns',
	'property_type' => '',
	'property_status' => '',
	'property_feature' => '',
	'property_cities' => '',
	'property_state' => '',
	'property_neighborhood' => '',
	'property_label' => '',
	'color_scheme' => 'color-dark',
	'item_amount' => '6',
	'image_size1'        => '240x180',
	'image_size2'        => '835x320',
	'image_size3'        => '570x320',
	'image_size4'        => '945x605',
	'include_heading' => '',
	'heading_sub_title' => '',
	'heading_title' => '',
	'heading_text_align' => '',
	'property_city' => '',
	'el_class' => ''
), $atts));

$wrapper_styles = array();
$property_item_class = array();
$property_content_class = array('property-content-wrap');
if (empty($property_cities)) {
	$property_ids = array();
	$args1 = array(
		'posts_per_page' => -1,
		'post_type' => 'property',
		'orderby'   => array(
			'menu_order'=>'ASC',
			'date' =>'DESC',
		),
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => ERE_METABOX_PREFIX . 'property_featured',
				'value' => true,
				'compare' => '=',
			)
		)
	);
	$data = new WP_Query($args1);
	if ($data->have_posts()) :
		while ($data->have_posts()): $data->the_post();
			$property_ids[] = get_the_ID();
		endwhile;
	endif;
	wp_reset_postdata();

	$property_city_all = wp_get_object_terms($property_ids, 'property-city');
	$property_cities = array();
	if (is_array($property_city_all)) {
		foreach ($property_city_all as $property_ct) {
			$property_cities[] = $property_ct->slug;
		}
		$property_cities = join(',', $property_cities);
	}
}
if ($layout_style == 'property-cities-filter') {
	if (!empty($property_cities) && empty($property_city)) {
		$property_city = explode(',', $property_cities)[0];
	}
}
$wrapper_classes = array(
	'ere-property-featured clearfix',
	$layout_style,
	$color_scheme,
	$el_class
);

if ($layout_style == 'property-list-two-columns') {
	$property_content_class[] = 'row';
	$property_item_class[] = 'mg-bottom-30';
	$property_content_class[] = 'columns-2';
	$property_item_class[] = 'ere-item-wrap';
	$property_item_class[] = 'mg-bottom-30';
	$wrapper_classes[] = 'ere-property property-list';
}

$_atts =  array(
    'item_amount' => ($item_amount > 0) ? $item_amount : -1,
    'featured' => true
);
if (!empty($property_city)) {
    $_atts['city'] = explode(',', $property_city);
} elseif (!empty($property_cities)) {
    $_atts['city'] = explode(',', $property_cities);
}



if (!empty($property_type)) {
    $_atts['type'] = explode(',', $property_type);
}
if (!empty($property_status)) {
    $_atts['status'] = explode(',', $property_status);
}
if (!empty($property_feature)) {
    $_atts['features'] = explode(',', $property_feature);
}
if (!empty($property_state)) {
    $_atts['state'] = explode(',', $property_state);
}
if (!empty($property_neighborhood)) {
    $_atts['neighborhood'] = explode(',', $property_neighborhood);
}

if (!empty($property_label)) {
    $_atts['label'] = explode(',', $property_label);
}
$args = ere_get_property_query_args($_atts);
$args = apply_filters('ere_shortcodes_property_featured_query_args',$args);
$data = new WP_Query($args);
$total_post = $data->found_posts;
ere_get_template('shortcodes/property-featured/layout/' . $layout_style . '.php',
    array(
        'layout_style' => $layout_style,
        'data' => $data,
        'property_type' => $property_type,
        'property_status' => $property_status,
        'property_feature' => $property_feature,
        'property_cities' => $property_cities,
        'property_state' => $property_state,
        'property_neighborhood' => $property_neighborhood,
        'property_label' => $property_label,
        'color_scheme' => $color_scheme,
        'item_amount' => $item_amount,
        'image_size1' => $image_size1,
        'image_size2' => $image_size2,
        'image_size3' => $image_size3,
        'image_size4' => $image_size4,
        'include_heading' => $include_heading,
        'heading_sub_title' => $heading_sub_title,
        'heading_title' => $heading_title,
        'heading_text_align' => $heading_text_align,
        'property_city' => $property_city,
        'el_class' => $el_class,
    ));
wp_reset_postdata();


