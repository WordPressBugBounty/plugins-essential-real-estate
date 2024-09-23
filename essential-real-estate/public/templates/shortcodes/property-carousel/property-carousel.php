<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Shortcode attributes
 * @var $atts
 */
$property_type = $property_status = $property_feature = $property_city = $property_state = $property_neighborhood =
$property_label = $property_featured = $item_amount = $columns_gap=$image_size = $color_scheme = $include_heading = $heading_sub_title = $heading_title = $el_class = '';
extract(shortcode_atts(array(
    'property_type' => '',
    'property_status' => '',
    'property_feature' => '',
    'property_city' => '',
    'property_state' => '',
    'property_neighborhood' => '',
    'property_label' => '',
    'property_featured' => '',
    'item_amount' => '6',
    'columns_gap' => 'col-gap-0',
    'image_size' => ere_get_loop_property_image_size_default(),
    'color_scheme' => 'color-dark',
    'include_heading' => '',
    'heading_sub_title' => '',
    'heading_title' => '',
    'el_class' => ''
), $atts));

$property_item_class = array('property-item');
$property_content_class = array('property-content');

$wrapper_classes = array(
	'ere-property-carousel',
	'ere-property',
	'property-carousel',
	'owl-nav-inline',
    $color_scheme,
	$el_class
);

if ($columns_gap == 'col-gap-30') {
    $col_gap = 30;
} elseif ($columns_gap == 'col-gap-20') {
    $col_gap = 20;
} elseif ($columns_gap == 'col-gap-10') {
    $col_gap = 10;
} else {
    $col_gap = 0;
}
$property_content_class[] = 'owl-carousel ere__owl-carousel';

$owl_attributes = array(
	'dots' => false,
	'nav' => true,
	'responsive' => array(
		'0' => array(
			'items' => 1,
			'margin' => $col_gap
		),
		'768' => array(
			'items' => 2,
			'margin' => $col_gap
		),
		'1200' => array(
			'items' => 3,
			'margin' => $col_gap
		),
		'1820' => array(
			'items' => 4,
			'margin' => $col_gap
		),
	)
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
$args = apply_filters('ere_shortcodes_property_carousel_query_args',$args);
$data = new WP_Query($args);
$total_post = $data->found_posts;
?>
<div class="ere-property-wrap">
    <div class="<?php echo esc_attr(join(' ', $wrapper_classes))  ?>">
        <div class="navigation-wrap">
            <?php
                if ($include_heading) {
                    ere_template_heading(array(
                        'heading_title' => $heading_title,
                        'heading_sub_title' => $heading_sub_title,
                        'color_scheme' => $color_scheme
                    ));
                }
            ?>
        </div>
        <div class="<?php echo esc_attr(join(' ', $property_content_class)) ?>" data-callback="owl_callback" data-plugin-options="<?php echo esc_attr(wp_json_encode($owl_attributes)) ?>">
           <?php  if ($data->have_posts())  {
                while ($data->have_posts()) {
                    $data->the_post();
                    ere_get_template('content-property.php', array(
                        'custom_property_image_size' => $image_size,
                        'property_item_class' => $property_item_class,
                    ));
                }
           } else {
               ere_get_template('loop/content-none.php');
           } ?>
        </div>
        <?php wp_reset_postdata(); ?>
    </div>
</div>

