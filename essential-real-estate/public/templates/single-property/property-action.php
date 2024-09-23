<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
$wrapper_classes = array(
  'ere__single-property-action'
);

$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php
    /**
     * ere_single_property_action hook.
     *
     * @hooked ere_template_single_property_action_social_share - 5
     * @hooked ere_template_loop_property_action_favorite - 10
     * @hooked ere_template_loop_property_action_compare - 15
     * @hooked ere_template_single_property_action_print - 20
     */
    do_action('ere_single_property_action',$property_id);
    ?>
</div>