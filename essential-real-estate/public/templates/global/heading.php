<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
/**
 * @var $heading_sub_title
 * @var $heading_title
 * @var $heading_text_align
 * @var $color_scheme
 * @var $extra_classes
 */
$heading_classes = array(
    'ere-heading',
);

if (!empty($color_scheme)) {
    $heading_classes[] = $color_scheme;
}

if (!empty($heading_text_align)) {
    $heading_classes[] = $heading_text_align;
}

if (!empty($extra_classes)) {
    if (is_array($extra_classes)) {
        $heading_classes = wp_parse_args($extra_classes,$heading_classes);
    }

    if (is_string($extra_classes)) {
        $heading_classes[] = $extra_classes;
    }
}

if (!empty($heading_sub_title)) {
    $heading_classes[] = 'ere-heading-sub';
}

$heading_class = join(' ', $heading_classes);
?>
<div class="<?php echo esc_attr($heading_class)?>">
    <?php if (!empty($heading_title)): ?>
        <h2><?php echo wp_kses_post($heading_title)?></h2>
    <?php endif; ?>
    <?php if (!empty($heading_sub_title)): ?>
        <p><?php echo wp_kses_post($heading_sub_title)?></p>
    <?php endif; ?>
</div>
