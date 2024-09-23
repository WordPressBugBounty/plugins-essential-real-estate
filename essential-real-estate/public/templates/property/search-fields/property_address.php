<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 * @var $request_address
 */
$request_address = isset($_GET['address']) ? ere_clean(wp_unslash($_GET['address'] )) : '';
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <input type="text" class="ere-location form-control search-field" data-default-value=""
           value="<?php echo esc_attr($request_address); ?>"
           name="address"
           placeholder="<?php esc_attr_e('Address', 'essential-real-estate') ?>">
</div>