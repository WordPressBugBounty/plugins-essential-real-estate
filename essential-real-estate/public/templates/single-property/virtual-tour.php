<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_image_360
 * @var $property_virtual_tour
 * @var $property_virtual_tour_type
 */
$wrapper_classes = array(
    'single-property-element',
    'property-virtual-tour',
    'ere__single-property-element',
    'ere__single-property-virtual-tour'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_virtual_tour_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__( 'Virtual tour', 'essential-real-estate' ); ?></h2>
    </div>
    <div class="ere-property-element">
        <?php if (!empty($property_image_360) && $property_virtual_tour_type == '0') : ?>
            <iframe width="100%" height="600" scrolling="no" allowfullscreen
                    src="<?php echo esc_url(ERE_PLUGIN_URL . "public/assets/packages/vr-view/index.html?image=" . $property_image_360) ; ?>"></iframe>
        <?php  elseif (!empty($property_virtual_tour) && $property_virtual_tour_type == '1'): ?>
            <?php echo(!empty($property_virtual_tour) ? do_shortcode($property_virtual_tour) : '') ?>
        <?php endif; ?>
    </div>
</div>

