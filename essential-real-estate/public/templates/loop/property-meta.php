<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<div class="property-element-inline">
    <?php
    /**
     * Hook: ere_loop_property_meta.
     *
     * @hooked ere_template_loop_property_type - 5
     * @hooked ere_template_loop_property_agent - 10
     * @hooked ere_template_loop_property_date - 15
     */
    do_action('ere_loop_property_meta',$property_id);
    ?>
</div>
