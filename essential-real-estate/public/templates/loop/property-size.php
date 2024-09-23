<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
/**
 * @var $property_size
 * @var $measurement_units
 */
?>
<div class="ere__loop-property-info-item property-area" data-toggle="tooltip" title="<?php esc_attr_e( 'Size', 'essential-real-estate' ); ?>">
    <i class="fa fa-arrows"></i>
    <div class="ere__lpi-content">
        <span class="ere__lpi-value"><?php echo wp_kses_post( sprintf( '%s %s', ere_get_format_number( $property_size ), $measurement_units ) ); ?></span>
        <span class="ere__lpi-label"><?php echo esc_html__('Size', 'essential-real-estate')?></span>
    </div>
</div>

