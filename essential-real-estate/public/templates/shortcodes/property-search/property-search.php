<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $atts
 */
$search_styles = $show_status_tab = $keyword_enable = $title_enable = $address_enable = $city_enable = $type_enable = $status_enable = $rooms_enable = $bedrooms_enable =
$bathrooms_enable =  $price_enable = $price_is_slider= $area_enable = $area_is_slider= $land_area_enable = $land_area_is_slider = $map_search_enable = $advanced_search_enable =
$country_enable = $state_enable =$neighborhood_enable = $label_enable = $garage_enable =
$property_identity_enable=$other_features_enable = $color_scheme = $el_class = $request_city='';
extract(shortcode_atts(array(
    'search_styles' => 'style-default',
    'show_status_tab' => 'true',
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
    'price_is_slider'=>'',
    'area_enable' => '',
    'area_is_slider'=>'',
    'land_area_enable' => '',
    'land_area_is_slider'=>'',
    'label_enable' => '',
    'garage_enable' => '',
    'property_identity_enable' => '',
    'other_features_enable' => '',
    'map_search_enable' => '',
    'color_scheme' => 'color-light',
    'el_class' => '',
), $atts));


if ($search_styles == 'style-mini-line') {
	$show_status_tab = false;
}

$status_default = $show_status_tab == 'true' ?  ere_get_property_status_default_value() : '';

$wrapper_classes = array(
    'ere-search-properties',
    'clearfix',
    $search_styles,
    $color_scheme,
    $el_class
);


if ($search_styles === 'style-vertical' || $search_styles === 'style-absolute') {
    $map_search_enable='true';
}
if ($map_search_enable=='true'){
    $wrapper_classes[] = 'ere-search-properties-map';
}
if($show_status_tab=='true' && $search_styles!='style-mini-line')
{
    $wrapper_classes[] = 'ere-show-status-tab';
}
if ($search_styles === 'style-vertical') {
    $class_col_half_map = 'col-lg-6';
    $wrapper_classes[] = 'row';
    $wrapper_classes[] = 'no-gutters';
} else {
    $class_col_half_map = '';
}

$enable_filter_location = ere_get_option('enable_filter_location', 0);
$options = array();
if ($map_search_enable=='true'){
    $googlemap_zoom_level = ere_get_option('googlemap_zoom_level', '12');
    $pin_cluster_enable = ere_get_option('googlemap_pin_cluster', '1');
    $google_map_style = ere_get_option('googlemap_style', '');
    $google_map_needed = 'true';
    $map_cluster_icon_url = ERE_PLUGIN_URL . 'public/assets/images/map-cluster-icon.png';
    $default_cluster=ere_get_option('cluster_icon','');
    if($default_cluster!='')
    {
        if(is_array($default_cluster)&& $default_cluster['url']!='')
        {
            $map_cluster_icon_url=$default_cluster['url'];
        }
    }
	$options = array(
		'ajax_url' => ERE_AJAX_URL,
		'not_found' => esc_html__("We didn't find any results, you can retry with other keyword.", 'essential-real-estate'),
		'googlemap_default_zoom' => esc_attr($googlemap_zoom_level),
		'clusterIcon' => esc_url($map_cluster_icon_url) ,
		'google_map_needed' => $google_map_needed,
		'google_map_style' => esc_attr($google_map_style) ,
		'pin_cluster_enable' => esc_attr($pin_cluster_enable),
		'price_is_slider'=> esc_attr($price_is_slider),
		'enable_filter_location'=> esc_attr($enable_filter_location)
	);
}else{
	$options = array(
		'ajax_url' => ERE_AJAX_URL,
		'price_is_slider'=> esc_attr($price_is_slider),
		'enable_filter_location'=> esc_attr($enable_filter_location)
	);
}
$geo_location = ere_get_option('geo_location');
/* Class col style for form*/
switch ($search_styles) {
    case 'style-mini-line':
        $css_class_field = 'col-xl-3 col-lg-6 col-md-6 col-12';
        $css_class_half_field = 'col-xl-3 col-lg-3 col-md-3 col-12';
        $show_status_tab='false';
        break;
    case 'style-default-small':
        $css_class_field = 'col-lg-4 col-md-6 col-12';
        $css_class_half_field = 'col-lg-2 col-md-3 col-12';
        break;
    case 'style-absolute':
        $css_class_field = 'col-lg-12 col-md-12 col-12';
        $css_class_half_field = 'col-lg-6 col-md-6 col-12';
        break;
    case 'style-vertical':
        $css_class_field = 'col-lg-6 col-md-6 col-12';
        $css_class_half_field = 'col-lg-3 col-md-3 col-12';
        break;
    default:
        $css_class_field = 'col-lg-4 col-md-6 col-12';
        $css_class_half_field = 'col-lg-2 col-md-3 col-12';
        break;
}
$css_class_field = apply_filters('ere_property_search_css_class_field',$css_class_field,$search_styles);
$css_class_half_field = apply_filters('ere_property_search_css_class_half_field',$css_class_half_field,$search_styles);
$wrapper_class = join(' ', $wrapper_classes);
?>
<div data-options="<?php echo esc_attr(wp_json_encode($options)); ?>" class="<?php echo esc_attr($wrapper_class) ?>">
    <?php if ($map_search_enable=='true') {
        ere_template_property_map_search($class_col_half_map);
    } ?>
    <?php if($search_styles === 'style-vertical'):?>
    <div class="col-scroll-vertical col-lg-6">
        <?php endif;?>
        <?php ere_template_property_search_form($atts,$css_class_field,$css_class_half_field,filter_var($show_status_tab, FILTER_VALIDATE_BOOLEAN)); ?>
        <?php if ($search_styles === 'style-vertical'): ?>
            <div class="property-result-wrap">
                <div class="list-property-result-ajax">
                    <?php
                    $_atts = [];
                    if (filter_var( $status_enable, FILTER_VALIDATE_BOOLEAN ) && !empty($status_default)) {
                        $_atts['status'] = $status_default;
                    }
                    if (filter_var( $price_is_slider, FILTER_VALIDATE_BOOLEAN ) && filter_var($price_enable, FILTER_VALIDATE_BOOLEAN)) {
                        $range_price = ere_get_property_price_slider($status_default);
                        $_atts['min-price'] = $range_price['min-price'];
                        $_atts['max-price'] = $range_price['max-price'];
                    }

                    if (filter_var( $area_is_slider, FILTER_VALIDATE_BOOLEAN ) && filter_var($area_enable, FILTER_VALIDATE_BOOLEAN)) {
                        $min_area = ere_get_option('property_size_slider_min', 0);
                        $max_area = ere_get_option('property_size_slider_max', 1000);
                        $_atts['min-area'] = $min_area;
                        $_atts['max-area'] = $max_area;
                    }

                    if (filter_var( $land_area_is_slider, FILTER_VALIDATE_BOOLEAN ) && filter_var($land_area_enable, FILTER_VALIDATE_BOOLEAN)) {
                        $min_land_area = ere_get_option('property_land_slider_min',0);
                        $max_land_area = ere_get_option('property_land_slider_max',1000);
                        $_atts['min-land-area'] = $min_land_area;
                        $_atts['max-land-area'] = $max_land_area;

                    }
                    $query_args = ere_get_property_query_args($_atts);
                    $query_args = apply_filters('ere_shortcodes_property_search_query_args',$query_args);
                    $data_vertical = new WP_Query($query_args);
                    $total_post = $data_vertical->found_posts;
                    $custom_property_image_size = ere_get_loop_property_image_size_default();
                    $property_item_class = array('property-item');
                    ?>
                    <div class="title-result">
                        <h2 class="uppercase">
                            <span class="number-result"><?php echo esc_html($total_post) ?></span>
                            <span class="text-result">
	                            <?php echo esc_html__('Properties','essential-real-estate'); ?>
                            </span>
                            <span class="text-no-result"><?php esc_html_e(' No property found', 'essential-real-estate') ?></span>
                        </h2>
                    </div>
                    <div class="ere-property property-carousel">
                        <?php
                        $owl_attributes = array(
                            'items' => 2,
                            'margin' => 30,
                            'nav' => true,
                            'responsive' => array(
	                            '0' => array(
		                            'items' => 1
	                            ),
	                            '600' => array(
		                            'items' => 2
	                            ),
	                            '992' => array(
		                            'items' => 1
	                            ),
	                            '1200' => array(
		                            'items' => 2
	                            )
                            )
                        );

                        ?>
                        <div class="owl-carousel ere__owl-carousel owl-nav-top-right" data-plugin-options="<?php echo esc_attr(wp_json_encode($owl_attributes)) ?>">
                            <?php if ($data_vertical->have_posts()) :
                                $index = 0;
                                while ($data_vertical->have_posts()): $data_vertical->the_post();?>
                                    <?php ere_get_template('content-property.php', array(
                                        'custom_property_image_size' => $custom_property_image_size,
                                        'property_item_class' => $property_item_class,
                                    )); ?>
                                <?php endwhile;
                            else: ?>
                                <?php ere_get_template('loop/content-none.php'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php wp_reset_postdata();?>
        <?php endif; ?>
        <?php if($search_styles === 'style-vertical'):?>
    </div>
<?php endif;?>
</div>