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
  'owl-carousel',
  'ere__owl-carousel',
);
$nav_id = uniqid('ere__owl-nav-container-');
$owl_attributes = apply_filters('ere_sc_property_slider_navigation_owl_options',array(
    'items' => 1,
    'dots' => false,
    'nav' => true,
    'navContainer' => ".{$nav_id}",
    'autoHeight' => true,
    'autoplay' => false,
    'autoplayTimeout' => 5000
)) ;
$wrapper_class = join(' ', $wrapper_classes);

?>
<div class="<?php echo esc_attr($wrapper_class)?>" data-callback="owl_callback" data-plugin-options="<?php echo esc_attr(wp_json_encode($owl_attributes))?>">
    <?php if ($data->have_posts()): ?>
        <?php while ($data->have_posts()): ?>
            <?php $data->the_post(); ?>
            <div class="property-item">
                <div class="property-inner">
                    <div class="property-image">
                        <?php ere_template_loop_property_image(array(
                            'image_size' => $image_size,
                            'image_size_default' => ere_get_sc_property_slider_image_size_default()
                        )); ?>
                    </div>
                    <div class="property-item-content">
                        <div class="container">
                            <div class="property-item-content-inner owl-nav-inline">
                                <div class="owl-nav <?php echo esc_attr($nav_id)?>">
                                </div>
                                <div class="property-heading">
                                    <?php
                                    /**
                                     * Hook: ere_before_sc_property_slider_layout_navigation_middle_loop_property_heading.
                                     *
                                     * @hooked ere_template_loop_property_title - 5
                                     */
                                    do_action('ere_before_sc_property_slider_layout_navigation_middle_loop_property_heading');
                                    ?>
                                    <div class="property-heading-inner">
                                        <?php
                                        /**
                                         * Hook: ere_sc_property_slider_layout_navigation_middle_loop_property_heading.
                                         *
                                         * @hooked ere_template_loop_property_price - 10
                                         * @hooked ere_template_loop_property_term_status - 15
                                         * @hooked ere_template_loop_property_location - 20
                                         */
                                        do_action('ere_sc_property_slider_layout_navigation_middle_loop_property_heading');
                                        ?>
                                    </div>
                                    <?php do_action('ere_after_sc_property_slider_layout_navigation_middle_loop_property_heading'); ?>

                                </div>
                                <?php
                                /**
                                 * Hook: ere_after_sc_property_slider_layout_navigation_middle_loop_property_content.
                                 *
                                 * @hooked ere_template_loop_property_info_layout_2 - 5
                                 */
                                do_action('ere_after_sc_property_slider_layout_navigation_middle_loop_property_content');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <?php ere_get_template('loop/content-none.php'); ?>
    <?php endif; ?>
</div>
