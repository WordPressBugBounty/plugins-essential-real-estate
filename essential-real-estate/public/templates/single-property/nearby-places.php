<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $property_id
 * @var $data
 */
$wrapper_classes = array(
    'single-property-element',
    'property-nearby-places',
    'ere__single-property-element',
    'ere__single-property-nearby-places'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_nearby_places_wrapper_classes',$wrapper_classes));

$options = array(
    'cluster_marker_enable' => false
);

$location = ere_property_get_location_data($property_id);

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php esc_html_e('Nearby Places', 'essential-real-estate'); ?></h2>
    </div>
    <div class="ere-property-element">
        <div class="ere__single-property-nearby-places-inner">
            <div class="ere__nearby-places row">
                <div class="ere__nbp-map col-md-5">
                    <div style="--ere-map-height: <?php echo esc_attr($data['map_height'])?>px" data-location="<?php echo esc_attr(wp_json_encode($location)) ?>" data-options="<?php echo esc_attr(wp_json_encode($options))?>" id="ere__single_property_nearby_places" data-nearby-options="<?php echo esc_attr(wp_json_encode($data))?>" class="ere__map-canvas"></div>
                </div>
                <div class="ere__nbp-content col-md-7">
                    <div class="ere__nbp-content-inner"></div>
                </div>
            </div>

        </div>
    </div>
</div>
