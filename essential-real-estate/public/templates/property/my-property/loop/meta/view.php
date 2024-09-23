<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $total_views
 */
$wrapper_classes = array(
    'ere__loop-my-property-meta-item',
    'ere__loop-property-meta-view'
);

$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <i class="fa fa-eye"></i><span><?php /* translators: %s: Number of total views. */ echo wp_kses_post(sprintf(_n('%s view', '%s views', $total_views, 'essential-real-estate'), ere_get_format_number($total_views)));?></span>
</div>
