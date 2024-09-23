<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_identity
 */
?>
<div class="ere__loop-property-info-item property-identity" data-toggle="tooltip" title="<?php esc_attr_e( 'Property ID', 'essential-real-estate' ); ?>">
    <i class="fa fa-barcode"></i>
    <div class="ere__lpi-content">
        <span class="ere__lpi-value"><?php echo esc_html($property_identity); ?></span>
        <span class="ere__lpi-label"><?php echo esc_html__('Property ID', 'essential-real-estate')?></span>
    </div>
</div>
