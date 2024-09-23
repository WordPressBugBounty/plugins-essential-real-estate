<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
?>
<div id="property-<?php the_ID(); ?>" <?php post_class('ere-property-wrap single-property-area content-single-property ere__single-property'); ?>>
	<?php
	/**
	 * ere_single_property_before_summary hook.
	 */
	do_action( 'ere_single_property_before_summary' );
	?>
	<?php
	/**
	* ere_single_property_summary hook.
	*
	* @hooked ere_template_single_property_header - 5
	* @hooked ere_template_single_property_gallery - 10
	* @hooked ere_template_single_property_description - 15
	* @hooked ere_template_single_property_address - 20
	* @hooked ere_template_single_property_features - 25
	* @hooked ere_template_single_property_floor - 30
	* @hooked ere_template_single_property_attachments - 35
	* @hooked ere_template_single_property_map - 40
	* @hooked ere_template_single_property_nearby_places - 45
	* @hooked ere_template_single_property_walk_score - 50
	* @hooked ere_template_single_property_contact_agent - 55
	* @hooked ere_template_single_property_footer - 90
	* @hooked ere_template_single_property_reviews - 95
	*/
	do_action( 'ere_single_property_summary' ); ?>
	<?php
	/**
	 * ere_single_property_after_summary hook.
	 *
	 * * @hooked comments_template - 90
	 */
	do_action( 'ere_single_property_after_summary' );
	?>
</div>