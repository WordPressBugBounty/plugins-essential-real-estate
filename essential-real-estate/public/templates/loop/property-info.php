<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 * @var $layout
 */
?>
<div class="ere__loop-property-info property-info <?php echo esc_attr($layout)?>">
    <div class="property-info-inner">
        <?php
        /**
         * Hook: ere_loop_property_info.
         *
         * @hooked ere_template_loop_property_size - 5
         * @hooked ere_template_loop_property_bedrooms - 10
         * @hooked ere_template_loop_property_bathrooms - 15
         */
        do_action('ere_loop_property_info',$property_id);
        ?>
    </div>
</div>
