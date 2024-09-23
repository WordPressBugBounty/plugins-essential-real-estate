<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $atts
 */
$show_status_tab = $keyword_enable = $title_enable = $address_enable = $city_enable = $type_enable = $status_enable = $rooms_enable = $bedrooms_enable =
$bathrooms_enable = $price_enable = $price_is_slider = $area_enable = $area_is_slider = $land_area_enable = $land_area_is_slider = $map_search_enable = $advanced_search_enable =
$country_enable = $state_enable = $neighborhood_enable = $label_enable = $garage_enable =
$property_identity_enable = $other_features_enable = $color_scheme = $el_class = $request_city = $item_amount = $marker_image_size = $show_advanced_search_btn = '';
extract( shortcode_atts( array(
	'show_status_tab'          => 'true',
	'status_enable'            => 'true',
	'type_enable'              => 'true',
	'keyword_enable'           => 'true',
	'title_enable'             => 'true',
	'address_enable'           => 'true',
	'country_enable'           => '',
	'state_enable'             => '',
	'city_enable'              => '',
	'neighborhood_enable'      => '',
	'rooms_enable'             => '',
	'bedrooms_enable'          => '',
	'bathrooms_enable'         => '',
	'price_enable'             => 'true',
	'price_is_slider'          => '',
	'area_enable'              => '',
	'area_is_slider'           => '',
	'land_area_enable'         => '',
	'land_area_is_slider'      => '',
	'label_enable'             => '',
	'garage_enable'            => '',
	'property_identity_enable' => '',
	'other_features_enable'    => '',
	'show_advanced_search_btn' => 'true',
	'item_amount'              => '18',
	'marker_image_size'        => '100x100',
	'el_class'                 => '',
), $atts ) );

$status_default            = $show_status_tab == 'true' ? ere_get_property_status_default_value() : '';
$request_paged             = isset( $_GET['paged'] ) ? absint(ere_clean(wp_unslash( $_GET['paged'] ))  ) : 1;
$wrapper_classes    = array(
    'ere-search-map-properties',
    'clearfix',
	'color-light',
    'row',
    'no-gutters',
	$el_class,
);

$ere_search           = new ERE_Search();
$googlemap_zoom_level = ere_get_option( 'googlemap_zoom_level', '12' );
$pin_cluster_enable   = ere_get_option( 'googlemap_pin_cluster', '1' );
$google_map_style     = ere_get_option( 'googlemap_style', '' );
$google_map_needed    = 'true';
$map_cluster_icon_url = ERE_PLUGIN_URL . 'public/assets/images/map-cluster-icon.png';
$default_cluster      = ere_get_option( 'cluster_icon', '' );
if ( $default_cluster != '' ) {
	if ( is_array( $default_cluster ) && $default_cluster['url'] != '' ) {
		$map_cluster_icon_url = $default_cluster['url'];
	}
}
/* Class col style for form*/
$css_class_field      = apply_filters('ere_property_search_map_css_class_field','col-lg-4 col-md-4 col-12') ;
$css_class_half_field = apply_filters('ere_property_search_map_css_class_half_field','col-lg-2 col-md-3 col-12') ;
$enable_filter_location = ere_get_option('enable_filter_location', 0);
$options = array(
	'ajax_url'               => ERE_AJAX_URL,
	'not_found'              => esc_html__( "We didn't find any results, you can retry with other keyword.", 'essential-real-estate' ),
	'googlemap_default_zoom' => esc_attr($googlemap_zoom_level) ,
	'clusterIcon'            => esc_url($map_cluster_icon_url),
	'google_map_needed'      => $google_map_needed,
	'google_map_style'       => esc_attr($google_map_style),
	'pin_cluster_enable'     => esc_attr($pin_cluster_enable),
	'price_is_slider'        => esc_attr($price_is_slider),
	'item_amount'            => esc_attr($item_amount) ,
	'marker_image_size'      => esc_attr($marker_image_size) ,
	'enable_filter_location' => esc_attr($enable_filter_location)
);

$property_col_class = apply_filters('ere_sc_property_search_map_property_col_class','columns-3 columns-md-3 columns-sm-2 columns-xs-1 columns-mb-1');

?>
<div data-options="<?php echo esc_attr(wp_json_encode($options)); ?>" class="<?php echo esc_attr(join( ' ', $wrapper_classes ))  ?>">
    <?php ere_template_property_map_search('col-xl-5'); ?>
	<div class="col-scroll-vertical col-xl-7">
		<div class="col-scroll-vertical-inner">
            <?php ere_template_property_search_form($atts,$css_class_field,$css_class_half_field,filter_var($show_status_tab,FILTER_VALIDATE_BOOLEAN)) ?>
			<div class="property-result-wrap">
				<div class="list-property-result-ajax ">
					<?php
                    $_atts =  [
                        'item_amount' => ( $item_amount > 0 ) ? $item_amount : - 1
                    ];
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
                    $query_args = apply_filters('ere_shortcodes_property_search_map_query_args',$query_args);
                    $data_vertical              = new WP_Query( $query_args );
					$total_post                 = $data_vertical->found_posts;
					$custom_property_image_size = '370x220';
					$property_item_class        = array( 'property-item ere-item-wrap mg-bottom-20' );
					?>
					<div class="title-result">
						<h2 class="uppercase">
							<span class="number-result"><?php echo esc_html( $total_post ) ?></span>
							<span class="text-result">
                                <?php echo esc_html__('Properties','essential-real-estate'); ?>
                            </span>
							<span class="text-no-result">
	                            <?php esc_html_e( ' No property found', 'essential-real-estate' ) ?>
                            </span>
						</h2>
					</div>
					<div class="ere-property clearfix property-grid property-vertical-map-listing col-gap-20 <?php echo esc_attr($property_col_class)?>">
						<?php if ( $data_vertical->have_posts() ) :
							while ( $data_vertical->have_posts() ): $data_vertical->the_post(); ?>
								<?php ere_get_template( 'content-property.php', array(
									'custom_property_image_size' => $custom_property_image_size,
									'property_item_class'        => $property_item_class,
								) ); ?>
							<?php endwhile;
						endif; ?>
					</div>
					<div class="property-search-map-paging-wrap">
						<?php $max_num_pages = $data_vertical->max_num_pages;
						set_query_var( 'paged', $request_paged );
						ere_get_template( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) );
						?>
					</div>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</div>