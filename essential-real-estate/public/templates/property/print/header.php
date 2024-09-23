<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<div class="ere__print-property-header">
    <div class="ere__pph-content-left">
        <?php
        /**
         * ere_print_property_header_left hook
         *
         * @hooked ere_template_single_property_title - 5
         * @hooked ere_template_single_property_location - 10
         * @hooked ere_template_single_property_price - 15
         */
        do_action('ere_print_property_header_left');
        ?>
    </div>
    <div class="ere__pph-content-right">
        <?php
        /**
         * ere_print_property_header_right hook
         *
         * @hooked ere_template_print_property_qr_image - 5
         */
        do_action('ere_print_property_header_right');
        ?>
    </div>
</div>
