<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $map_id
 * @var $extend_class
 */
$wrapper_classes = array(
    'ere-map-search',
    'clearfix'
);
if (!empty($extend_class)) {
    if (is_array($extend_class)) {
        $wrapper_classes = wp_parse_args($extend_class,$wrapper_classes);
    } else {
        $wrapper_classes[] = $extend_class;
    }
}
$wrapper_class = implode(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="search-map-inner clearfix">
        <div id="<?php echo esc_attr($map_id)?>" class="ere-map-result">
        </div>
        <div id="ere-map-loading">
            <div class="block-center">
                <div class="block-center-inner">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
        <?php wp_nonce_field('ere_search_map_ajax_nonce', 'ere_security_search_map'); ?>
    </div>
</div>
