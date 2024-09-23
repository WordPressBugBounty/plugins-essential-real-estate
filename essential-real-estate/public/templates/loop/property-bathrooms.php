<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_bathrooms
 */
?>
<div class="ere__loop-property-info-item property-bathrooms" data-toggle="tooltip" title="<?php  /* translators: %s: Number of property bathrooms. */ echo esc_attr(sprintf( _n( '%s Bathroom', '%s Bathrooms', $property_bathrooms, 'essential-real-estate' ), $property_bathrooms )); ?>">
    <i class="fa fa-bath"></i>
    <div class="ere__lpi-content">
        <span class="ere__lpi-value"><?php echo esc_html( $property_bathrooms ) ?></span>
        <span class="ere__lpi-label"><?php echo esc_html(_n( 'Bathroom', 'Bathrooms', $property_bathrooms, 'essential-real-estate' )) ?></span>
    </div>
</div>
