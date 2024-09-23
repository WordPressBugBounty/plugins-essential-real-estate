<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $max_num_pages
 * @var $the_query WP_Query
 */
if (!is_user_logged_in()) {
    ere_get_template('global/access-denied.php', array('type' => 'not_login'));
    return;
}
$allow_submit = ere_allow_submit();
if (!$allow_submit) {
    ere_get_template('global/access-denied.php', array('type' => 'not_permission'));
    return;
}
$request_new_id = isset($_GET['new_id']) ? ere_clean(wp_unslash($_GET['new_id'])) : '';
if (!empty($request_new_id)) {
    ere_get_template('property/property-submitted.php', array('property' => get_post($request_new_id), 'action' => 'new'));
}
$request_edit_id = isset($_GET['edit_id']) ? ere_clean(wp_unslash($_GET['edit_id']))  : '';
if (!empty($request_edit_id)) {
    ere_get_template('property/property-submitted.php', array('property' => get_post($request_edit_id), 'action' => 'edit'));
}
?>
<div class="row ere-user-dashboard">
    <div class="col-lg-3 ere-dashboard-sidebar">
        <?php ere_get_template('global/dashboard-menu.php', array('cur_menu' => 'my_properties')); ?>
    </div>
    <div class="col-lg-9 ere-dashboard-content">
        <div class="card ere-card ere-my-properties">
            <div class="card-header"><h5 class="card-title m-0"><?php echo esc_html__('My Properties', 'essential-real-estate'); ?></h5></div>
            <div class="card-body">
                <div class="ere__my-property-toolbar">
                    <?php
                    /**
                     * Hook: ere_my_property_toolbar.
                     *
                     * @hooked ere_template_my_property_search - 5
                     */
                    do_action('ere_my_property_toolbar');
                    ?>
                </div>
                <div class="ere__my-property-list ere-property">
                    <?php
                        if ($the_query->have_posts()) {
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                ere_get_template('property/my-property/content-property.php');
                            }
                        } else {
                            ere_get_template('loop/content-none.php');
                        }
                    ?>
                </div>
                <?php ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages)); ?>
            </div>
        </div>
    </div>
</div>
