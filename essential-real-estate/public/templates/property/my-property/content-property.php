<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$image_size = ere_get_my_property_image_size();
?>
<div class="ere__property-item">
    <div class="ere__property-item-inner">
        <div class="ere__property-image">
            <?php ere_template_loop_property_image(array(
                'image_size' => $image_size
            ));
            /**
             * Hook: ere_after_loop_my_property_thumbnail.
             *
             * @hooked ere_template_loop_my_property_featured - 5
             * @hooked ere_template_loop_my_property_status - 10
             */
            do_action('ere_after_loop_my_property_thumbnail');
            ?>
        </div>
        <div class="ere__property-content">
            <?php
            /**
             * Hook: ere_loop_my_property_content.
             *
             * @hooked ere_template_loop_my_property_title - 5
             * @hooked ere_template_loop_my_property_meta - 10
             * @hooked ere_template_loop_my_property_action - 15
             */
            do_action('ere_loop_my_property_content');
            ?>
        </div>
    </div>
</div>
