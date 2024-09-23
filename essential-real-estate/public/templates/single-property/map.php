<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */

$wrapper_classes = array(
    'single-property-element',
    'ere__single-property-element',
    'ere__single-property-map'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_map_wrapper_classes',$wrapper_classes));
$location = ere_property_get_location_data($property_id);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php esc_html_e('Get Directions', 'essential-real-estate'); ?></h2>
    </div>
    <div class="ere-property-element">
        <div id="ere__single_property_map" class="ere__map-canvas" data-location="<?php echo esc_attr(wp_json_encode($location)) ?>"></div>
        <div class="ere__single-property-map-directions">
            <input type="text" class="form-control ere__spmd-input" placeholder="<?php esc_attr_e('Enter a location', 'essential-real-estate'); ?>">
            <button type="button" class="btn btn-primary ere__spmd-btn"><i class="fa fa-search"></i></button>
            <span style="display: none" class="ere__spmd-total"><span><?php echo esc_html__('Distance:','essential-real-estate')?></span> <span class="ere__spmd-number"></span></span>
        </div>
    </div>
</div>

