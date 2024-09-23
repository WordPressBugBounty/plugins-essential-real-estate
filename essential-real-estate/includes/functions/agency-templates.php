<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

function ere_template_archive_agency_action_search() {
    ere_get_template('shortcodes/agency/actions/search.php');
}

function ere_template_archive_agency_action_orderby() {
    $sort_by_list = ere_agency_get_sort_by();
    ere_get_template('archive-property/actions/orderby.php',array('sort_by_list' => $sort_by_list));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_loop_agency_image($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $logo = get_term_meta( $agency->term_id, 'agency_logo', true );
    if (empty($logo) || !is_array($logo) || empty($logo['url'])) {
        return;
    }
    $image = $logo['url'];
    ere_get_template('shortcodes/agency/loop/image.php',array('agency' => $agency, 'image' => $image));
}

function ere_template_loop_agency_title_address_start() {
    echo '<div class="ere__loop-agency-title_address">';
}

function ere_template_loop_agency_title_address_end() {
    echo '</div>';
}


/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_loop_agency_title($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    ere_get_template('shortcodes/agency/loop/title.php',array('agency' => $agency));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_loop_agency_address($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $address = get_term_meta( $agency->term_id, 'agency_address', true );
    if (empty($address)) {
        return;
    }
    ere_get_template('shortcodes/agency/loop/address.php',array('address' => $address));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_loop_agency_social($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $data = ere_agency_get_social_data($agency->term_id);
    if (empty($data)) {
        return;
    }
    ere_get_template('shortcodes/agency/loop/social.php',array('data' => $data));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_loop_agency_desc($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $desc = $agency->description;
    if (empty($desc)) {
        return;
    }
    ere_get_template('shortcodes/agency/loop/desc.php',array('desc' => $desc));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_loop_agency_meta($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $data = ere_agency_get_contact_data($agency->term_id);
    if (empty($data)) {
        return;
    }
    ere_get_template('shortcodes/agency/loop/meta.php',array('data' => $data));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_single_agency_header($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    ere_get_template('single-agency/header.php',array('agency' => $agency));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_single_agency_title($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $name = $agency->name;
    ere_get_template('single-agency/elements/title.php',array('title' => $name));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_single_agency_address($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $address = get_term_meta( $agency->term_id, 'agency_address', true );
    if (empty($address)) {
        return;
    }
    ere_get_template('single-agency/elements/address.php',array('address' => $address));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_single_agency_meta($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $data = ere_agency_get_meta_data($agency->term_id);
    if (empty($data)) {
        return;
    }
    ere_get_template('single-agency/elements/meta.php',array('data' => $data));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_single_agency_contact_info($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }

    $data = ere_agency_get_contact_data_single($agency->term_id);
    if (empty($data)) {
        return;
    }
    ere_get_template('single-agency/elements/contact.php',array('data' => $data));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function ere_template_single_agency_social($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $data = ere_agency_get_social_data($agency->term_id);
    if (empty($data)) {
        return;
    }
    ere_get_template('single-agency/elements/social.php',array('data' => $data));
}

/**
 * @param $agency WP_Term
 * @return void
 */
function  ere_template_single_agency_image($agency)
{
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $logo = get_term_meta( $agency->term_id, 'agency_logo', true );
    if (empty($logo) || !is_array($logo) || empty($logo['url'])) {
        return;
    }
    $image = $logo['url'];
    ere_get_template('single-agency/elements/image.php',array('agency' => $agency, 'image' => $image));
}

function ere_template_single_agency_contact_form($agency) {
    $email         = get_term_meta( $agency->term_id, 'agency_email', true );
    if (empty($email)) {
        return;
    }
    $enable_captcha= ere_enable_captcha( 'contact_agency' ) ;
    ere_get_template('global/contact-form.php',array('email' =>  $email, 'enable_captcha' => $enable_captcha,'extend_class' => 'ere__single-agency-contact-form'));
}

/**
 * @param $agency
 * @return void
 */
function ere_template_single_agency_tabs($agency) {
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $tabs = ere_agency_get_tabs($agency->term_id);
    $wrapper_classes = array(
        'ere__single-agency-element',
        'ere__single-agency-tabs',
    );
    $wrapper_class = join(' ', $wrapper_classes);
    ere_get_template('global/tabs.php',array('tabs' => $tabs,'extend_class' => $wrapper_class));
}

function ere_template_single_agency_overview($agency) {
    $agency_id = '';
    if (is_array($agency)) {
        $args          = wp_parse_args( $agency, array(
            'agency_id' => '',
        ) );
        $agency_id = $args['agency_id'];
    } elseif (is_a($agency,'WP_Term')) {
        $agency_id = $agency->term_id;
    }

    if (empty($agency_id)) {
        return;
    }

    $desc     = get_term_meta( $agency_id, 'agency_des', true );
    if (empty($desc)) {
        return;
    }
    $desc     = wpautop( $desc );
    ere_get_template('single-agency/tabs/overview.php', array('desc' => $desc));
}

function ere_template_single_agency_property($agency) {
    $agency_id = '';
    if (is_array($agency)) {
        $args          = wp_parse_args( $agency, array(
            'agency_id' => '',
        ) );
        $agency_id = $args['agency_id'];
    } elseif (is_a($agency,'WP_Term')) {
        $agency_id = $agency->term_id;
    }

    $enable_property_of_agency = ere_get_option( 'enable_property_of_agency', '1' );
    if (!filter_var($enable_property_of_agency,FILTER_VALIDATE_BOOLEAN)) {
        return;
    }
    ere_get_template('single-agency/tabs/property.php',array('agency_id' => $agency_id));
}

function ere_template_single_agency_location($agency) {
    $agency_id = '';
    if (is_array($agency)) {
        $args          = wp_parse_args( $agency, array(
            'agency_id' => '',
        ) );
        $agency_id = $args['agency_id'];
    } elseif (is_a($agency,'WP_Term')) {
        $agency_id = $agency->term_id;
    }

    $position =  ere_agency_get_map_position($agency_id);
    if ($position === false) {
        return;
    }

    $location = array(
        'position' => $position,
        'marker_type' => 'simple'
    );
    ere_get_template('single-agency/tabs/map.php',array('location' => $location));
}

function ere_template_single_agency_agent($agency)
{
    if (!is_a($agency,'WP_Term')) {
        return;
    }
    $enable_agents_of_agency = ere_get_option( 'enable_agents_of_agency', '1' );
    if (filter_var($enable_agents_of_agency,FILTER_VALIDATE_BOOLEAN) === false) {
        return;
    }
    ere_get_template('single-agency/agent.php',array('agency' =>  $agency));
}
