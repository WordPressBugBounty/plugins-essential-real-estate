<?php
/**
 * @var $custom_property_image_size
 * @var $property_item_class
 * @var $property_image_class
 * @var $property_item_content_class
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if (!isset($property_image_class)) {
    $property_image_class = array();
}
$property_featured  = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_featured' , true);
if ( $property_featured ) {
	$property_item_class[] = 'ere-property-is-featured';
}

if ( ! isset( $property_item_content_class ) ) {
	$property_item_content_class = array();
}
$property_item_content_class[] = 'property-item-content';
?>
<div class="<?php echo esc_attr( join( ' ', $property_item_class ) ); ?>">
	<div class="property-inner">
        <?php ere_template_loop_property_thumbnail(array(
                'extra_classes' => $property_image_class,
                'image_size' => $custom_property_image_size
        )); ?>
		<div class="<?php echo esc_attr( join( ' ', $property_item_content_class ) ); ?>">
			<div class="property-heading">
                <?php
                    /**
                     * Hook: ere_loop_property_heading.
                     *
                     * @hooked ere_template_loop_property_title - 5
                     * @hooked ere_template_loop_property_price - 10
                     */
                    do_action('ere_loop_property_heading');
                ?>
			</div>
            <?php
            /**
             * Hook: ere_after_loop_property_heading.
             *
             * @hooked ere_template_loop_property_location - 5
             * @hooked ere_template_loop_property_meta - 10
             * @hooked ere_template_loop_property_excerpt - 15
             * @hooked ere_template_loop_property_info - 20
             */
            do_action('ere_after_loop_property_heading');
            ?>

		</div>
	</div>
</div>