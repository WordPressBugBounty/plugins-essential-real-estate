<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $data
 * @var $image_size
 */
$wrapper_classes = array(
    'property-content',
);
$wrapper_class = join(' ', $wrapper_classes);
$property_ids = array();
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php if ($data->have_posts()): ?>
        <div class="property-content-slider owl-carousel">
            <?php while ($data->have_posts()): ?>
                <?php
                $data->the_post();
                $property_ids[] = get_the_ID();
                ?>
            <div class="property-item">
                <div class="property-inner">
                    <div class="property-image">
                        <?php ere_template_loop_property_image(array(
                            'image_size' => $image_size,
                            'image_size_default' => ere_get_sc_property_slider_image_size_default()
                        )); ?>
                    </div>
                    <div class="property-item-content">
                        <div class="property-heading">
                            <?php
                            /**
                             * Hook: ere_sc_property_gallery_layout_pagination_image_loop_property_heading.
                             *
                             * @hooked ere_template_loop_property_location - 5
                             * @hooked ere_template_loop_property_title - 10
                             * @hooked ere_template_loop_property_price - 15
                             */
                            do_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading');
                            ?>
                        </div>
                        <?php
                        /**
                         * Hook: ere_after_sc_property_gallery_layout_pagination_image_loop_property_content.
                         *
                         * @hooked ere_template_loop_property_info_layout_2 - 5
                         */
                        do_action('ere_after_sc_property_gallery_layout_pagination_image_loop_property_content');
                        ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="property-slider-image-wrap">
            <div class="property-image-slider owl-carousel">
                <?php $thumb_image_size = ere_get_sc_property_slider_thumb_image_size_default(); ?>
                <?php foreach ($property_ids as $property_id): ?>
                    <div class="property-image">
                        <?php ere_template_loop_property_image(array(
                            'property_id' => $property_id,
                            'image_size' => $thumb_image_size,
                            'image_size_default' => $thumb_image_size
                        )); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <?php ere_get_template('loop/content-none.php'); ?>
    <?php endif; ?>
</div>
