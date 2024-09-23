<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 01/11/16
 * Time: 5:11 PM
 */
/**
 * @var $atts
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$layout = $column = $address_enable = $keyword_enable = $title_enable = $city_enable = $type_enable = $status_enable = $rooms_enable = $bedrooms_enable =
$bathrooms_enable = $price_enable = $price_is_slider = $area_enable = $area_is_slider = $land_area_enable = $land_area_is_slider = $country_enable = $state_enable = $neighborhood_enable = $label_enable = $garage_enable =
$property_identity_enable = $other_features_enable = $color_scheme = $el_class = $request_city = '';
extract(shortcode_atts(array(
    'layout' => 'tab',
    'column' => '3',
    'status_enable' => 'true',
    'type_enable' => 'true',
    'keyword_enable' => 'true',
    'title_enable' => 'true',
    'address_enable' => 'true',
    'country_enable' => '',
    'state_enable' => '',
    'city_enable' => '',
    'neighborhood_enable' => '',
    'rooms_enable' => '',
    'bedrooms_enable' => '',
    'bathrooms_enable' => '',
    'price_enable' => 'true',
    'price_is_slider' => '',
    'area_enable' => '',
    'area_is_slider' => '',
    'land_area_enable' => '',
    'land_area_is_slider' => '',
    'label_enable' => '',
    'garage_enable' => '',
    'property_identity_enable' => '',
    'other_features_enable' => '',
    'color_scheme' => 'color-light',
    'el_class' => ''
), $atts));

$wrapper_classes = array(
    'ere-property-advanced-search',
    'clearfix',
    $layout,
    $color_scheme,
    $el_class,
);
$enable_filter_location = ere_get_option('enable_filter_location', 0);
$options = array(
	'ajax_url' => esc_url(ERE_AJAX_URL),
	'price_is_slider' => esc_attr($price_is_slider) ,
	'enable_filter_location'=> esc_attr($enable_filter_location)
);
//$css_class_field = 'col-md-4 col-sm-6 col-xs-12';
$css_class_field = 'col-lg-4 col-md-6 col-12';
//$css_class_half_field = 'col-md-2 col-sm-3 col-xs-12';
$css_class_half_field = 'col-lg-2 col-md-3 col-12';
if ($column == '1') {
    //$css_class_field = 'col-md-12 col-sm-12 col-xs-12';
    $css_class_field = 'col-lg-12 col-md-12 col-12';
    //$css_class_half_field = 'col-md-6 col-sm-6 col-xs-12';
    $css_class_half_field = 'col-lg-6 col-md-6 col-12';
} elseif ($column == '2') {
    //$css_class_field = 'col-md-6 col-sm-6 col-xs-12';
    $css_class_field = 'col-lg-6 col-md-6 col-12';
    //$css_class_half_field = 'col-md-3 col-sm-3 col-xs-12';
    $css_class_half_field = 'col-lg-3 col-md-3 col-12';
} elseif ($column == '3') {
    //$css_class_field = 'col-md-4 col-sm-6 col-xs-12';
    $css_class_field = 'col-lg-4 col-md-6 col-12';
    //$css_class_half_field = 'col-md-2 col-sm-3 col-xs-12';
    $css_class_half_field = 'col-lg-2 col-md-3 col-12';
} elseif ($column == '4') {
    //$css_class_field = 'col-md-3 col-sm-6 col-xs-12';
    $css_class_field = 'col-lg-3 col-md-6 col-12';
    //$css_class_half_field = 'col-md-3 col-sm-3 col-xs-12';
    $css_class_half_field = 'col-lg-3 col-md-3 col-12';
}
$css_class_field = apply_filters('ere_property_advanced_search_css_class_field',$css_class_field,$column);
$css_class_half_field = apply_filters('ere_property_advanced_search_css_class_half_field',$css_class_half_field,$column);
$show_status_tab = $status_enable == 'true' && $layout == 'tab';
$wrapper_class = join(' ', $wrapper_classes);
?>
<div data-options="<?php echo esc_attr(wp_json_encode($options)); ?>" class="<?php echo esc_attr($wrapper_class) ?>">
    <?php ere_template_property_search_form($atts,$css_class_field,$css_class_half_field,$show_status_tab); ?>
</div>