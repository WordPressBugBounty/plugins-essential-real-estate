<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $layout_style
 * @var $data
 * @var $property_type
 * @var $property_status
 * @var $property_feature
 * @var $property_cities
 * @var $property_state
 * @var $property_neighborhood
 * @var $property_label
 * @var $color_scheme
 * @var $item_amount
 * @var $image_size1
 * @var $image_size2
 * @var $image_size3
 * @var $image_size4
 * @var $include_heading
 * @var $heading_sub_title
 * @var $heading_title
 * @var $heading_text_align
 * @var $property_city
 * @var $el_class
 */
$wrapper_classes = array(
    'ere-property-featured',
    'ere-property',
    'clearfix',
    $layout_style,
    $color_scheme,
    $el_class
);

$filter_classes = array(
    'property-filter-content',
    'property-filter-carousel'
);

$filter_id = wp_rand();

$filter_attributes = array(
    'data-layout_style' => $layout_style,
    'data-property_type' => $property_type,
    'data-property_status' => $property_status,
    'data-property_feature' => $property_feature,
    'data-property_cities' => $property_cities,
    'data-property_state' => $property_state,
    'data-property_neighborhood' => $property_neighborhood,
    'data-property_label' => $property_label,
    'data-color_scheme' => $color_scheme,
    'data-item_amount' => $item_amount,
    'data-image_size' => $image_size2,
    'data-include_heading' => $include_heading,
    'data-heading_sub_title' => $heading_sub_title,
    'data-heading_title' => $heading_title,
    'data-heading_text_align' => $heading_text_align,
    'data-property_city' => $property_city,
    'data-el_class' => $el_class,
    'data-item' => '.property-item',
    'data-filter-type' => 'carousel',
    'data-filter_id' => $filter_id
);


$owl_attributes = array(
    'dots' => true,
    'nav' => false,
    'items' => 1,
    'autoHeight' => true,
    'autoplay' => false,
    'autoplayTimeout' => 1000
);

$property_content_attributes = array(
    'data-type' => 'carousel',
    'data-filter-content' => 'filter',
    'data-plugin-options' => $owl_attributes,
    'data-layout' => 'filter',
    'data-filter_id' => $filter_id
);

$property_city_arr = explode(',', $property_cities);
$filter_class = join(' ', $filter_classes);
$wrapper_class = join(' ', apply_filters('ere_sc_property_featured_layout_property_cities_filter_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php if ($include_heading) {
        ere_template_heading(array(
            'heading_title' => $heading_title,
            'heading_sub_title' => $heading_sub_title,
            'heading_text_align' => $heading_text_align,
            'color_scheme' => $color_scheme
        ));
    }?>
    <div class="property-content-wrap row no-gutters">
        <div class="filter-wrap col-lg-3" data-admin-url="<?php echo esc_url( wp_nonce_url( ERE_AJAX_URL, 'ere_property_featured_fillter_city_ajax_action', 'ere_property_featured_fillter_city_ajax_nonce' ) ); ?>">
            <div class="<?php echo esc_attr($filter_class)?>" <?php ere_render_html_attr($filter_attributes); ?>>
                <?php foreach ($property_city_arr as $k => $v): ?>
                    <?php
                        $city = get_term_by('slug', $v, 'property-city', 'OBJECT');
                        if (!is_a($city,'WP_Term')) {
                            continue;
                        }
                        $a_classes = array('portfolio-filter-category');
                        if ($k == 0) {
                            $a_classes[] = 'active-filter';
                        }
                        $a_class = join(' ', $a_classes);
                    ?>
                    <a class="<?php echo esc_attr($a_class)?>" data-filter=".<?php echo esc_attr($city->slug)?>" href="#"><?php echo esc_html($city->name)?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="property-content-inner col-lg-9">
            <?php if ($data->have_posts()): ?>
                <div class="property-content owl-carousel ere__owl-carousel" <?php ere_render_html_attr($property_content_attributes); ?>>
                    <?php while ($data->have_posts()): ?>
                    <?php $data->the_post(); ?>
                        <div class="property-item">
                            <div class="property-inner">
                                <div class="property-image">
                                    <?php ere_template_loop_property_image(array(
                                        'image_size' => $image_size2,
                                        'image_size_default' => '835x320'
                                    )); ?>
                                </div>
                                <div class="property-item-content">
                                    <div class="property-heading-inner">
                                        <?php
                                        /**
                                         * Hook: ere_sc_property_featured_layout_property_cities_filter_loop_property_heading.
                                         *
                                         * @hooked ere_template_loop_property_title - 5
                                         * @hooked ere_template_loop_property_price - 10

                                         */
                                        do_action('ere_sc_property_featured_layout_property_cities_filter_loop_property_heading');
                                        ?>
                                    </div>
                                    <?php
                                    /**
                                     * Hook: ere_after_sc_property_featured_layout_property_cities_filter_loop_property_heading.
                                     *
                                     * @hooked ere_template_single_property_info - 5
                                     */
                                    do_action('ere_after_sc_property_featured_layout_property_cities_filter_loop_property_heading');
                                    ?>

                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <?php ere_get_template('loop/content-none.php'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
