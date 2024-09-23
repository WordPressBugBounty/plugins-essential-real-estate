<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 */
$request_property_identity = isset($_GET['property_identity']) ? ere_clean(wp_unslash($_GET['property_identity']))  : '';
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <input type="text" class="ere-property-identity form-control search-field" data-default-value=""
           value="<?php echo esc_attr($request_property_identity); ?>"
           name="property_identity"
           placeholder="<?php esc_attr_e('Property ID', 'essential-real-estate') ?>">
</div>