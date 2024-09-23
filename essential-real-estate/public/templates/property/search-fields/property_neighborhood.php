<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 */
$request_neighborhood = isset($_GET['neighborhood']) ? ere_clean(wp_unslash($_GET['neighborhood']))  : '';
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <select name="neighborhood" class="ere-property-neighborhood-ajax search-field form-control" title="<?php esc_attr_e('Property Neighborhoods', 'essential-real-estate'); ?>" data-selected="<?php echo esc_attr($request_neighborhood); ?>" data-default-value="">
        <?php ere_get_taxonomy_slug('property-neighborhood', $request_neighborhood); ?>
        <option value="" <?php selected('', $request_neighborhood); ?>>
            <?php esc_html_e('All Neighborhoods', 'essential-real-estate'); ?>
        </option>
    </select>
</div>