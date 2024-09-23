<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 * @var $image_size
 * @var $extra_classes
 */

$wrapper_classes = array(
    'property-image'
);

if (!empty($extra_classes)) {
    if (is_array($extra_classes)) {
        $wrapper_classes = wp_parse_args($extra_classes, $wrapper_classes);
    }

    if (is_string($extra_classes)) {
        $wrapper_classes[] = $extra_classes;
    }
}
$wrapper_class = join(' ', apply_filters('ere_loop_property_thumbnail_wrapper_classes', $wrapper_classes, $property_id));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
    <?php
    ere_template_loop_property_image(array(
        'image_size' => $image_size,
        'property_id' => $property_id
    ));
    /**
     * Hook: ere_after_loop_property_thumbnail.
     *
     * @hooked ere_template_loop_property_action - 5
     * @hooked ere_template_loop_property_featured_label - 10
     * @hooked ere_template_loop_property_term_status - 15
     * @hooked ere_template_loop_property_link - 20
     */
    do_action('ere_after_loop_property_thumbnail');
    ?>
</div>

