<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
function ere_agent_get_review_by_user_id($agentId, $userId) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare("SELECT cm.comment_ID, cm.comment_content, mt.meta_value as rate FROM $wpdb->comments as cm 
                                             INNER JOIN $wpdb->commentmeta as mt ON cm.comment_ID = mt.comment_id 
                                             WHERE 
                                                cm.comment_post_ID = %d 
                                                AND cm.user_id = %d
                                                AND mt.meta_key = 'agent_rating'
                                             ORDER BY cm.comment_ID DESC",
        $agentId,
        $userId));
}

function ere_agent_get_list_review($agentId,$userId)
{
    global $wpdb;
    return $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->comments as cm
                                       LEFT JOIN $wpdb->commentmeta as mt ON cm.comment_ID = mt.comment_id
                                       WHERE cm.comment_post_ID = %d
                                       AND (cm.comment_approved = 1 OR cm.user_id = %d)  
                                       AND mt.meta_key = 'agent_rating'
                                       ORDER BY cm.comment_ID DESC",
        $agentId,
        $userId) );
}

function ere_agent_get_rating($agentId) {
    $data = get_post_meta($agentId, ERE_METABOX_PREFIX . 'agent_rating', true);
    if (!is_array($data)) {
        $data = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        );
    }
    return $data;
}

function ere_agent_get_sort_by() {
    return apply_filters('ere_agent_sort_by',array(
        'default' => esc_html__('Default Order','essential-real-estate'),
        'a_name' => esc_html__('Name (A to Z)','essential-real-estate'),
        'd_name' => esc_html__('Name (Z to A)','essential-real-estate'),
        'a_date' => esc_html__('Date (Old to New)','essential-real-estate'),
        'd_date' => esc_html__('Date (New to Old)','essential-real-estate')
    ));
}



