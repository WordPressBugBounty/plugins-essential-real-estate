<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$wrapper_classes = array(
    'ere__single-property-header-price-location'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_header_price_location_wrapper_classes',$wrapper_classes));

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php
    /**
     * Hook: ere_single_property_header_price_location.
     *
     * @hooked ere_template_single_property_price - 5
     * @hooked ere_template_single_property_status - 10
     * @hooked ere_template_single_property_location - 15
     */
    do_action('ere_single_property_header_price_location');
    ?>
</div>