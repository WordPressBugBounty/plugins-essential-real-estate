<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 */
$request_type = isset($_GET['type']) ? ere_clean(wp_unslash($_GET['type']))  : '';
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <select name="type" title="<?php esc_attr_e('Property Types', 'essential-real-estate') ?>"
            class="search-field form-control" data-default-value="">
        <?php ere_get_taxonomy_slug('property-type', $request_type); ?>
        <option
            value="" <?php selected('',$request_type)?>>
            <?php esc_html_e('All Types', 'essential-real-estate') ?>
        </option>
    </select>
</div>