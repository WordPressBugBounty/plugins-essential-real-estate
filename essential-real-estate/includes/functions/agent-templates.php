<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
function ere_template_agent_reviews() {
    $enable_comments_reviews_agent = ere_get_option( 'enable_comments_reviews_agent', 0 );
    if ($enable_comments_reviews_agent == 2) {
        $rating = 0;
        $total_reviews = 0;
        $total_stars = 0;
        $my_rating = 0;
        $my_comment = '';
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        $agent_id = get_the_ID();
        $rating_data = ere_agent_get_rating($agent_id);

        $comments = ere_agent_get_list_review($agent_id, $user_id);
        if ( $comments !== null ) {
            foreach ( $comments as $comment ) {
                if ( $comment->comment_approved == 1 ) {
                    $total_reviews++;
                    $total_stars += $comment->meta_value;
                }
            }
            if ( $total_reviews > 0 ) {
                $rating = ( $total_stars / $total_reviews );
            }
        }


        $my_review = ere_agent_get_review_by_user_id($agent_id,$user_id);
        if ($my_review !== null) {
            $my_comment = $my_review->comment_content;
            $my_rating = $my_review->rate;
        }

        ere_get_template('global/reviews.php',array(
            'extra_class' => 'single-agent-element ere__single-agent-element',
            'rating' => $rating,
            'total_reviews' => $total_reviews,
            'rating_data' => $rating_data,
            'type' => 'agent',
            'comments' => $comments,
            'my_rating' => $my_rating,
            'my_comment' => $my_comment
        ));
    }
}

function ere_template_archive_agent_heading($total_post = 0) {
    ere_get_template( 'archive-agent/heading.php', array( 'total_post' => $total_post ) );
}

function ere_template_archive_agent_action() {
    ere_get_template( 'archive-agent/action.php');
}

function ere_template_archive_agent_action_search() {
    ere_get_template('archive-agent/actions/search.php');
}


function ere_template_archive_agent_action_orderby() {
    $sort_by_list = ere_agent_get_sort_by();
    ere_get_template('archive-property/actions/orderby.php',array('sort_by_list' => $sort_by_list));
}

function ere_template_archive_agent_action_switch_layout() {
    ere_get_template('archive-property/actions/switch-layout.php',array('type' => 'agent'));
}


function ere_template_single_agent_contact_form() {
    $agent_id = get_the_ID();
    $email = get_post_meta($agent_id,ERE_METABOX_PREFIX . 'agent_email',true);
    if (empty($email)) {
        return;
    }
    $enable_captcha= ere_enable_captcha('contact_agent');

    ere_get_template('global/contact-form.php',array('email' =>  $email, 'enable_captcha' => $enable_captcha));
}



