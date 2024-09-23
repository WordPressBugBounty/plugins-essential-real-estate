<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $atts
 * @var $enable_saved_search
 * @var $parameters
 * @var $search_query
 */
$data_target='#ere_save_search_modal';
if (!is_user_logged_in()){
    $data_target='#ere_signin_modal';
}
?>
<div class="ere_property-advanced-search-form-wrap">
    <?php echo ere_do_shortcode( 'ere_property_advanced_search', $atts ); ?>
    <?php if (filter_var($enable_saved_search, FILTER_VALIDATE_BOOLEAN)): ?>
        <div class="advanced-saved-searches">
            <button type="button" class="btn btn-primary btn-xs btn-save-search" data-toggle="modal" data-target="<?php echo esc_attr($data_target); ?>">
                <?php esc_html_e( 'Save Search', 'essential-real-estate' ) ?></button>
        </div>
        <?php ere_get_template('global/save-search-modal.php',array('parameters'=>$parameters,'search_query'=>$search_query)); ?>
    <?php endif; ?>
</div>
