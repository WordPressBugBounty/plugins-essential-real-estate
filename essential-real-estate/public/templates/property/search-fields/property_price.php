<?php
/**
 * @var $css_class_field
 * @var $css_class_half_field
 * @var $price_is_slider
 * @var $show_status_tab
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
if (!isset($show_status_tab)) {
    $show_status_tab = true;
}
$status_default= filter_var($show_status_tab, FILTER_VALIDATE_BOOLEAN) ? ere_get_property_status_default_value() : '';
$request_status = isset($_GET['status']) ? ere_clean(wp_unslash($_GET['status']))  : $status_default;
$request_min_price = isset($_GET['min-price']) ? ere_clean(wp_unslash($_GET['min-price']))  : '';
$request_max_price = isset($_GET['max-price']) ? ere_clean(wp_unslash($_GET['max-price']))  : '';
?>
<?php if (filter_var($price_is_slider, FILTER_VALIDATE_BOOLEAN)): ?>
    <?php
    $range_price = ere_get_property_price_slider($request_status);
    $min_price = $range_price['min-price'];
    $max_price = $range_price['max-price'];
    $min_price_change = ($request_min_price === '') ? $min_price : $request_min_price;
    $max_price_change = ($request_max_price === '') ? $max_price : $request_max_price;
    ?>
    <div class="ere-sliderbar-price-wrap <?php echo esc_attr($css_class_field); ?> form-group">
        <div class="ere-sliderbar-price ere-sliderbar-filter"
             data-min-default="<?php echo esc_attr( $min_price ) ?>"
             data-max-default="<?php echo esc_attr( $max_price ); ?>"
             data-min="<?php echo esc_attr( $min_price_change ) ?>"
             data-max="<?php echo esc_attr( $max_price_change ); ?>">
            <div class="title-slider-filter">
                <?php echo esc_html__( 'Price', 'essential-real-estate' ) ?> [<span
                        class="min-value"><?php echo wp_kses_post( ere_get_format_money( $min_price_change ) ) ?></span>
                - <span
                        class="max-value"><?php echo wp_kses_post( ere_get_format_money( $max_price_change ) ) ?></span>]
                <input type="hidden" name="min-price" class="min-input-request"
                       value="<?php echo esc_attr( $min_price_change ) ?>">
                <input type="hidden" name="max-price" class="max-input-request"
                       value="<?php echo esc_attr( $max_price_change ) ?>">
            </div>
            <div class="sidebar-filter">
            </div>
        </div>
    </div>
<?php else: ?>
    <?php
    $range_price_dropdown = ere_get_property_price_dropdown($request_status);
    $property_price_dropdown_min = $range_price_dropdown['min-price'];
    $property_price_dropdown_max = $range_price_dropdown['max-price'];
    ?>
    <div class="<?php echo esc_attr($css_class_half_field); ?> form-group">
        <select name="min-price" title="<?php echo esc_attr__('Min Price', 'essential-real-estate') ?>" class="search-field form-control" data-default-value="">
            <option value="">
                <?php echo esc_html__('Min Price', 'essential-real-estate') ?>
            </option>
            <?php
            $property_price_array = explode(',', $property_price_dropdown_min);
            ?>
            <?php if (is_array($property_price_array) && !empty($property_price_array) ): ?>
                <?php foreach ($property_price_array as $n) : ?>
                    <option <?php selected($request_min_price,$n) ?> value="<?php echo esc_attr($n)?>"><?php echo ere_get_format_money_search_field($n) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>

        </select>
    </div>
    <div class="<?php echo esc_attr($css_class_half_field); ?> form-group">
        <select name="max-price" title="<?php echo esc_attr__('Max Price', 'essential-real-estate') ?>" class="search-field form-control" data-default-value="">
            <option value="">
                <?php echo esc_html__('Max Price', 'essential-real-estate') ?>
            </option>
            <?php
            $property_price_array = explode(',', $property_price_dropdown_max);
            ?>
            <?php if (is_array($property_price_array) && !empty($property_price_array) ): ?>
                <?php foreach ($property_price_array as $n) : ?>
                    <option <?php selected($request_max_price,$n) ?> value="<?php echo esc_attr($n)?>"><?php echo ere_get_format_money_search_field($n) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
<?php endif; ?>