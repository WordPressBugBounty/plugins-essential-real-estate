<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<div class="ere__loop-property-action property-action">
    <?php
    /**
     * ere_property_action hook.
     *
     * @hooked ere_template_loop_property_action_view_gallery - 5
     * @hooked ere_template_loop_property_action_favorite - 10
     * @hooked ere_template_loop_property_action_compare - 15
     */
    do_action( 'ere_loop_property_action', $property_id ); ?>
</div>