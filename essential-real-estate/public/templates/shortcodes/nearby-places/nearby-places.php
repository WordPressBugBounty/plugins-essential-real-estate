<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * Shortcode attributes
 * @var $atts
 */
$lat = $lng = $rank_by = $radius = $distance_in = $map_height = $el_class = '';
extract(shortcode_atts(array(
    'lat' => '',
    'lng' => '',
    'rank_by' => '',
    'radius' => '',
    'distance_in' => '',
    'map_height' => 475,
    'el_class' => ''
), $atts));
if (empty($lat) || empty($lng)) {
    return;
}
$wrapper_classes = array(
    'ere__nearby-places',
    'row',
    $el_class
);
$wrapper_class = join(' ', apply_filters('ere_shortcodes_nearby_places_wrapper_classes',$wrapper_classes,$atts));
$position = array(
    'lat' => floatval($lat) ,
    'lng' => floatval($lng),
);
$location =  array(
    'position' => $position
);
$options = array(
    'cluster_marker_enable' => false
);


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
if (empty($radius)) {
    $radius = '5000';
}

if (empty($fields)) {
    return;
}

$separator = ere_get_price_decimal_separator();
if (empty($map_height)) {
    $map_height = '475';
}
$data = array(
    'radius' => $radius,
    'rankPreference' => $rank_by,
    'unit' => $distance_in,
    'fields' => $fields,
    'types' => $types,
    'position' => $position,
    'separator' => $separator,
    'map_height' => $map_height,
    'i18n' => array(
        'no_result' => esc_html__( 'No result!', 'essential-real-estate' )
    )
);
$id = uniqid('ere__nearby_places_');
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere__nbp-map col-md-7">
        <div style="--ere-map-height: <?php echo esc_attr($map_height)?>px" data-location="<?php echo esc_attr(wp_json_encode($location)) ?>" data-options="<?php echo esc_attr(wp_json_encode($options))?>" id="<?php echo esc_attr($id)?>" data-nearby-options="<?php echo esc_attr(wp_json_encode($data))?>" class="ere__map-canvas"></div>
    </div>
    <div class="ere__nbp-content col-md-5">
        <div class="ere__nbp-content-inner"></div>
    </div>
</div>
