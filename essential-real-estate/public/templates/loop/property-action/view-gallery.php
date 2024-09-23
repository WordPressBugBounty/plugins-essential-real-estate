<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 * @var $total_image
 */
$wrapper_classes = array(
    'property-view-gallery',
    'ere__loop-property_action-item'
);
$wrapper_class = join(' ', $wrapper_classes);
?>
<a data-toggle="tooltip"
   title="<?php /* translators: %s: Number of photos. */ echo esc_attr(sprintf(__('(%s) Photos', 'essential-real-estate'), $total_image)); ?>"
   data-property-id="<?php echo esc_attr($property_id); ?>"
   href="javascript:void(0)" class="<?php echo esc_attr($wrapper_class)?>">
    <i class="fa fa-camera"></i>
</a>
