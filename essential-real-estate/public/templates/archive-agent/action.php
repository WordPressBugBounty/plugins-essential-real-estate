<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="archive-agent-action ere__archive-actions ere__archive-agent-actions">
    <?php
    /**
     * Hook: ere_archive_agent_actions.
     *
     * @hooked ere_template_archive_agent_action_search - 5
     * @hooked ere_template_archive_agent_action_orderby - 10
     * @hooked ere_template_archive_agent_action_switch_layout - 15
     */
    do_action('ere_archive_agent_actions');
    ?>
</div>

