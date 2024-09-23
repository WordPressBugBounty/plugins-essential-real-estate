<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $badge
 * @var $extra_classes
 */
$wrapper_classes = array('ere__loop-property-badge');
if (isset($class) && !empty($class)) {
    $wrapper_classes[] = $class;
}

if (!empty($extra_classes)) {
    if (is_array($extra_classes)) {
        $wrapper_classes = wp_parse_args($extra_classes, $wrapper_classes);
    }

    if (is_string($extra_classes)) {
        $wrapper_classes[] = $extra_classes;
    }
}

$wrapper_class = implode(' ', apply_filters('ere_loop_property_badge',$wrapper_classes,$extra_classes) );
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php foreach ( $badge as $k => $v ): ?>
        <?php echo wp_kses_post($v['content'] ) ?>
    <?php endforeach; ?>
</div>
