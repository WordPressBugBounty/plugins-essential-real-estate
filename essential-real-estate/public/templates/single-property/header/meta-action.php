<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$wrapper_classes = array(
    'ere__single-property-header-meta-action'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_header_meta_action_wrapper_classes',$wrapper_classes));

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php
    /**
     * Hook: ere_single_property_header_price_location.
     *
     * @hooked ere_template_single_property_info - 5
     * @hooked ere_template_single_property_action - 10
     */
    do_action('ere_single_property_header_meta_action');
    ?>
</div>