<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @see ere_template_agent_reviews
 */
add_action('ere_single_agent_summary','ere_template_agent_reviews',15);

/**
 * @see ere_template_archive_agent_heading
 * @see ere_template_archive_agent_action
 */
add_action('ere_before_archive_agent','ere_template_archive_agent_heading',5);
add_action('ere_before_archive_agent','ere_template_archive_agent_action',10);

/**
 * @see ere_template_archive_agent_action_search
 * @see ere_template_archive_agent_action_orderby
 * @see ere_template_archive_agent_action_switch_layout
 */
add_action('ere_archive_agent_actions','ere_template_archive_agent_action_search',5);
add_action('ere_archive_agent_actions','ere_template_archive_agent_action_orderby',10);
add_action('ere_archive_agent_actions','ere_template_archive_agent_action_switch_layout',15);



