<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $status
 */
?>
<div class="ere__loop-my-property-badge ere__status ere__status-<?php echo esc_attr($status)?>">
    <?php
    switch ($status) {
        case 'publish':
            echo esc_html__('Published', 'essential-real-estate');
            break;
        case 'expired':
            echo esc_html__('Expired', 'essential-real-estate');
            break;
        case 'pending':
            echo esc_html__('Pending', 'essential-real-estate');
            break;
        case 'hidden':
            echo esc_html__('Hidden', 'essential-real-estate');
            break;
        default:
            echo esc_html($status);
    }?>
</div>
