<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
$wrapper_classes = array(
    'ere__property-print',
    'ere__loop-property_action-item'
);
$wrapper_class = join(' ', $wrapper_classes);

$wrapper_class = join(' ', $wrapper_classes);
?>
<a class="<?php echo esc_attr($wrapper_class)?>" href="javascript:void(0)" id="property-print"
   data-ajax-url="<?php echo esc_url(ERE_AJAX_URL) ; ?>" data-toggle="tooltip"
   data-original-title="<?php esc_attr_e( 'Print', 'essential-real-estate' ); ?>"
   data-property-id="<?php echo esc_attr( $property_id ); ?>"><i class="fa fa-print"></i></a>

