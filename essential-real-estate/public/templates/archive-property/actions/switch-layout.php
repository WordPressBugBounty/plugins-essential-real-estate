<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $type
 */
$type = $type ?? 'property';
?>
<div class="ere__apa-item ere__apa-switch-layout">
    <div class="view-as" data-admin-url="<?php echo esc_url(ERE_AJAX_URL); ?>">
                    <span data-view-as="<?php echo esc_attr($type)?>-list" class="view-as-list" title="<?php esc_attr_e( 'View as List', 'essential-real-estate' ) ?>">
                        <i class="fa fa-list-ul"></i>
                    </span>
        <span data-view-as="<?php echo esc_attr($type)?>-grid" class="view-as-grid" title="<?php esc_attr_e( 'View as Grid', 'essential-real-estate' ) ?>">
                        <i class="fa fa-th-large"></i>
                    </span>
    </div>
</div>
