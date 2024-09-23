<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<div class="ere__loop-my-property-meta">
    <?php
    /**
     * Hook: ere_loop_my_property_meta.
     *
     * @hooked ere_template_loop_my_property_meta_view - 5
     * @hooked ere_template_loop_my_property_meta_date - 10
     * @hooked ere_template_loop_my_property_meta_expire_date - 15
     */
    do_action('ere_loop_my_property_meta');
    ?>
</div>
