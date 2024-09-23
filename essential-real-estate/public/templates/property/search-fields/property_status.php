<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 */
$request_status = isset($_GET['status']) ? ere_clean(wp_unslash($_GET['status']))  : '';
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <select name="status" title="<?php esc_attr_e('Property Status', 'essential-real-estate') ?>"
            class="search-field form-control" data-default-value="">
        <?php ere_get_property_status_search_slug($request_status); ?>
	    <option value="" <?php selected('',$request_status) ?>>
		    <?php esc_html_e('All Status', 'essential-real-estate') ?>
	    </option>
    </select>
</div>