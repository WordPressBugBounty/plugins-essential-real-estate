<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 */
$request_country = isset($_GET['country']) ? ere_clean(wp_unslash($_GET['country']))  : '';
$countries = ere_get_selected_countries();
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <select name="country" class="ere-property-country-ajax search-field form-control" title="<?php esc_attr_e('Countries', 'essential-real-estate'); ?>" data-selected="<?php echo esc_attr($request_country); ?>" data-default-value="">
	    <option <?php selected('',$request_country) ?> value=""><?php echo esc_html__('All Countries', 'essential-real-estate') ?></option>
	    <?php foreach ($countries as $k => $v): ?>
		    <option <?php selected($k,$request_country) ?> value="<?php echo esc_attr($k)?>"><?php echo esc_html($v)?></option>
	    <?php endforeach; ?>
    </select>
</div>