<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$wrapper_classes = array(
    'ere__single-property-element',
    'single-property-element',
    'property-info-header',
    'property-info-action',
    'ere__single-property-header-info'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_header_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">

    <div class="ere__single-property-header-info-inner">
        <?php
        /**
         * Hook: ere_single_property_header_info.
         *
         * @hooked ere_template_single_property_title - 5
         * @hooked ere_template_single_property_header_price_location - 10
         */
        do_action('ere_single_property_header_info');
        ?>
    </div>
    <?php
    /**
     * Hook: ere_after_single_property_header_info.
     *
     * @hooked ere_template_single_property_header_meta_action - 5
     */
    do_action('ere_after_single_property_header_info');
    ?>
</div>
