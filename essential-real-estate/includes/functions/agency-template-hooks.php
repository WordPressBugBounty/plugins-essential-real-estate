<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

/**
 * @see ere_template_archive_agency_action_search
 * @see ere_template_archive_agency_action_orderby
 */
add_action('ere_archive_agency_actions','ere_template_archive_agency_action_search',5);
add_action('ere_archive_agency_actions','ere_template_archive_agency_action_orderby',10);

/**
 * @see ere_template_loop_agency_image
 */
add_action('ere_before_loop_agency_content','ere_template_loop_agency_image',10);

/**
 * @see ere_template_loop_agency_title
 * @see ere_template_loop_agency_address
 * @see ere_template_loop_agency_social
 */
add_action('ere_loop_agency_heading','ere_template_loop_agency_title_address_start',4);
add_action('ere_loop_agency_heading','ere_template_loop_agency_title',5);
add_action('ere_loop_agency_heading','ere_template_loop_agency_address',10);
add_action('ere_loop_agency_heading','ere_template_loop_agency_title_address_end',11);
add_action('ere_loop_agency_heading','ere_template_loop_agency_social',15);

/**
 * @see ere_template_loop_agency_desc
 * @see ere_template_loop_agency_meta
 */
add_action('ere_after_loop_agency_heading','ere_template_loop_agency_desc',5);
add_action('ere_after_loop_agency_heading','ere_template_loop_agency_meta',10);

/**
 * @see ere_template_single_agency_header
 */
add_action('ere_taxonomy_agency_summary','ere_template_single_agency_header',5);

/**
 * @see ere_template_single_agency_tabs
 * @see ere_template_single_agency_agent
 */
add_action('ere_taxonomy_agency_after_summary','ere_template_single_agency_tabs',5);
add_action('ere_taxonomy_agency_after_summary','ere_template_single_agency_agent',10);


/**
 * @see ere_template_single_agency_title
 * @see ere_template_single_agency_address
 * @see ere_template_single_agency_meta
 * @see ere_template_single_agency_contact_info
 * @see ere_template_single_agency_social
 */
add_action('ere_single_agency_summary','ere_template_single_agency_title',5);
add_action('ere_single_agency_summary','ere_template_single_agency_address',10);
add_action('ere_single_agency_summary','ere_template_single_agency_meta',15);
add_action('ere_single_agency_summary','ere_template_single_agency_contact_info',20);
add_action('ere_single_agency_summary','ere_template_single_agency_social',25);

/**
 * @see ere_template_single_agency_image
 */
add_action('ere_before_single_agency_summary','ere_template_single_agency_image',5);

/**
 * @see ere_template_single_agency_contact_form
 */
add_action('ere_after_single_agency_summary','ere_template_single_agency_contact_form',5);




