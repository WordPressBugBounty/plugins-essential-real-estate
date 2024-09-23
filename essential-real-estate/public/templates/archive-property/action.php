<?php
/**
 * @var $taxonomy_name
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$current_url = sanitize_url($_SERVER['REQUEST_URI']);
?>
<div class="archive-property-action ere__archive-actions ere__archive-property-actions">
    <?php
    /**
     * Hook: ere_archive_property_actions.
     *
     * @hooked ere_template_archive_property_action_status - 5
     * @hooked ere_template_archive_property_action_orderby - 10
     * @hooked ere_template_archive_property_action_switch_layout - 15
     */
    do_action('ere_archive_property_actions');
    ?>
</div>
