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

$owl_options = apply_filters('ere_sc_property_featured_layout_property_single_carousel_owl_options',array(
    'dots' => true,
    'nav' => false,
    'items' => 1
));

$wrapper_class = join(' ', apply_filters('ere_sc_property_featured_layout_property_single_carousel_wrapper_classes',$wrapper_classes));
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
    <?php if ($data->have_posts()): ?>
        <div class="property-content-wrap">
            <div class="property-content-inner">
                <div class="property-content owl-carousel ere__owl-carousel" data-plugin-options="<?php echo esc_attr(wp_json_encode($owl_options)) ?>">
                    <?php while ($data->have_posts()): ?>
                        <?php $data->the_post(); ?>
                        <div class="property-item">
                            <div class="property-inner">
                                <div class="property-image">
                                    <?php ere_template_loop_property_image(array(
                                        'image_size' => $image_size3,
                                        'image_size_default' => '570x320'
                                    )); ?>
                                </div>
                                <div class="property-item-content">
                                    <?php
                                    /**
                                     * Hook: ere_sc_property_featured_layout_property_single_carousel_loop_property_heading.
                                     *
                                     * @hooked ere_template_loop_property_title - 5
                                     */
                                    do_action('ere_before_sc_property_featured_layout_property_single_carousel_loop_property_heading');
                                    ?>

                                    <div class="property-heading-inner">
                                        <?php
                                        /**
                                         * Hook: ere_sc_property_featured_layout_property_single_carousel_loop_property_heading.
                                         *
                                         * @hooked ere_template_loop_property_price - 5
                                         * @hooked ere_template_loop_property_status - 10

                                         */
                                        do_action('ere_sc_property_featured_layout_property_single_carousel_loop_property_heading');
                                        ?>
                                    </div>

                                    <?php
                                    /**
                                     * Hook: ere_after_sc_property_featured_layout_property_single_carousel_loop_property_heading.
                                     *
                                     * @hooked ere_template_loop_property_location - 5
                                     * @hooked ere_template_loop_property_excerpt - 10
                                     * @hooked ere_template_single_property_info - 15
                                     */
                                    do_action('ere_after_sc_property_featured_layout_property_single_carousel_loop_property_heading');
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php ere_get_template('loop/content-none.php'); ?>
    <?php endif; ?>
</div>
