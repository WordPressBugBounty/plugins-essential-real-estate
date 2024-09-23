<?php
/**
 * Shortcode attributes
 * @var $atts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$layout_style = $property_type = $property_status = $property_feature = $property_city = $property_state = $property_neighborhood =
$property_label = $property_featured = $item_amount = $image_size = $el_class = '';
extract( shortcode_atts( array(
	'layout_style' => 'navigation-middle',
	'property_type' => '',
	'property_status' => '',
	'property_feature' => '',
	'property_city' => '',
	'property_state' => '',
	'property_neighborhood' => '',
	'property_label' => '',
    'property_featured' => '',
	'item_amount'       => '6',
	'image_size'        => ere_get_sc_property_slider_image_size_default(),
	'el_class'          => ''
), $atts ) );
$wrapper_classes = array(
	'ere-property-slider',
    'ere-property',
    'clearfix',
	$layout_style,
	$el_class
);

$_atts =  array(
    'item_amount' => ($item_amount > 0) ? $item_amount : -1,
    'featured' => $property_featured
);

if (!empty($property_type)) {
    $_atts['type'] = explode(',', $property_type);
}

if (!empty($property_status)) {
    $_atts['status'] = explode(',', $property_status);
}

if (!empty($property_feature)) {
    $_atts['features'] = explode(',', $property_feature);
}
if (!empty($property_city)) {
    $_atts['city'] = explode(',', $property_city);
}

if (!empty($property_state)) {
    $_atts['state'] = explode(',', $property_state);
}
if (!empty($property_neighborhood)) {
    $_atts['neighborhood'] = explode(',', $property_neighborhood);
}

if (!empty($property_label)) {
    $_atts['label'] = explode(',', $property_label);
}

$args = ere_get_property_query_args($_atts);
$args = apply_filters('ere_shortcodes_property_slider_query_args',$args);
$data = new WP_Query( $args );
$total_post = $data->found_posts;
?>
<div class="ere-property-wrap">
	<div class="<?php echo esc_attr(join( ' ', $wrapper_classes ))  ?>">
        <?php ere_get_template("shortcodes/property-slider/layout/{$layout_style}.php",array(
                'data' => $data,
                'image_size' => $image_size
        )); ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>

