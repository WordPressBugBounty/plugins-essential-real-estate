<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
$wrapper_classes = array(
    'compare-property',
    'ere__loop-property_action-item'
);
$wrapper_class = join(' ', $wrapper_classes);
?>
<a class="<?php echo esc_attr($wrapper_class)?>" href="javascript:void(0)"
   data-property-id="<?php echo esc_attr($property_id) ?>" data-toggle="tooltip"
   title="<?php esc_attr_e('Compare', 'essential-real-estate') ?>">
    <i class="fa fa-plus"></i>
</a>
