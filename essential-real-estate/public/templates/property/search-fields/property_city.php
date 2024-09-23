<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 * @var $request_keyword_title
 */
$request_city = isset($_GET['city']) ? ere_clean(wp_unslash($_GET['city']))  : '';
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <select name="city" class="ere-property-city-ajax search-field form-control" title="<?php esc_attr_e('Cities', 'essential-real-estate'); ?>" data-selected="<?php echo esc_attr($request_city); ?>" data-default-value="">
        <?php ere_get_taxonomy_slug('property-city', $request_city); ?>
        <option value="" <?php selected('', $request_city); ?>>
            <?php echo esc_html__('All Cities', 'essential-real-estate'); ?>
        </option>
    </select>
</div>