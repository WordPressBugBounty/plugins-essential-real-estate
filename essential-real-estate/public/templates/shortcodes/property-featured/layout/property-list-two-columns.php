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
    'property-list',
    'clearfix',
    $layout_style,
    $color_scheme,
    $el_class
);

$property_list_classes = array(
    'property-content-wrap',
    'row',
    'columns-2'
);

$property_item_classes = array(
    'ere-item-wrap',
    'mg-bottom-30'
);

$wrapper_class = join(' ', apply_filters('ere_sc_property_featured_layout_property_list_two_columns_wrapper_classes',$wrapper_classes));
$property_list_class = join(' ', apply_filters('ere_sc_property_featured_layout_property_list_two_columns_property_list_classes',$property_list_classes));
$property_item_class = join(' ', apply_filters('ere_sc_property_featured_layout_property_list_two_columns_property_item_classes',$property_item_classes));
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
        <div class="<?php echo esc_attr($property_list_class)?>">
            <?php while ($data->have_posts()): ?>
            <?php $data->the_post(); ?>
            <div class="<?php echo esc_attr($property_item_class)?>">
                <div class="property-inner">
                    <?php ere_template_loop_property_thumbnail(array(
                        'image_size' => $image_size1
                    )); ?>
                    <div class="property-item-content">
                        <?php
                        /**
                         * Hook: ere_sc_property_featured_layout_property_list_two_columns_loop_property_content.
                         *
                         * @hooked ere_template_loop_property_title - 5
                         * @hooked ere_template_loop_property_price - 10
                         * @hooked ere_template_loop_property_location - 15
                         * @hooked ere_template_loop_property_excerpt - 20
                         * @hooked ere_template_loop_property_link_detail - 25
                         */
                        do_action('ere_sc_property_featured_layout_property_list_two_columns_loop_property_content');
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
