<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<div class="ere__loop-property-info property-info layout-2 ere__single-property-info">
    <div class="property-info-inner">
        <?php
        /**
         * Hook: ere_single_property_info.
         *
         * @hooked ere_template_loop_property_identity - 5
         * @hooked ere_template_loop_property_size - 10
         * @hooked ere_template_loop_property_bedrooms - 15
         * @hooked ere_template_loop_property_bathrooms - 20
         */
        do_action('ere_single_property_info',$property_id);
        ?>
    </div>
</div>
