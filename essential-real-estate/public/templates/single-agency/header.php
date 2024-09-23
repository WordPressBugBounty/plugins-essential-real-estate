<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $agency
 */
$wrapper_classes = array(
  'ere__single-agency-element',
  'ere__single-agency-header',
);

$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php
    /**
     * Hook: ere_before_single_agency_summary.
     *
     * @hooked ere_template_single_agency_image - 5
     */
    do_action('ere_before_single_agency_summary',$agency);
    ?>
    <div class="ere__summary">
        <?php
        /**
         * Hook: ere_single_agency_summary.
         *
         * @hooked ere_template_single_agency_title - 5
         * @hooked ere_template_single_agency_address - 10
         * @hooked ere_template_single_agency_meta - 15
         * @hooked ere_template_single_agency_contact_info -20
         * @hooked ere_template_single_agency_social - 25
         */
        do_action('ere_single_agency_summary',$agency);
        ?>
    </div>
    <?php
    /**
     * Hook: ere_after_single_agency_summary.
     *
     * @hooked ere_template_single_agency_contact_form - 5
     */
    do_action('ere_after_single_agency_summary',$agency);
    ?>
</div>

