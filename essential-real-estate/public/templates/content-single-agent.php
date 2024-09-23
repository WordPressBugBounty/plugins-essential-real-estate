<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
?>
<div id="agent-<?php the_ID(); ?>" <?php post_class('ere-agent-single-wrap ere-agent-single'); ?>>
	<?php
	/**
	 * ere_single_agent_before_summary hook.
	 */
	do_action( 'ere_single_agent_before_summary' );
	?>
	<?php
	/**
	 * ere_single_agent_summary hook.
	 *
	 * @hooked single_agent_info - 5
	 * @hooked comments_template - 10
	 * @hooked single_agent_reviews - 10
	 * @hooked single_agent_property - 20
	 * @hooked single_agent_other - 30
	 */
	do_action( 'ere_single_agent_summary' ); ?>
	<?php
	/**
	 * ere_single_agent_after_summary hook.
	 */
	do_action( 'ere_single_agent_after_summary' );
	?>
</div>