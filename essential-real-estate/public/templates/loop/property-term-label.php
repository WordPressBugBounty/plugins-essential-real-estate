<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_term_label WP_Term[]
 */
?>
<?php foreach ($property_term_label as $item): ?>
    <?php
        $label_color = get_term_meta( $item->term_id, 'property_label_color', true );
        $label_attributes = array();
        if (!empty($label_color)) {
            $label_attributes['style'] = sprintf('--ere-loop-property-badge-bg-color:%s', esc_attr($label_color));
        }
        $label_classes = array(
            'ere__loop-property-badge-item',
            'ere__term-label',
            $item->slug
        );
        $label_class = join(' ', $label_classes);
        $label_attributes['class'] = $label_class;
    ?>
    <span <?php ere_render_html_attr($label_attributes); ?>>
        <span class="ere__lpbi-inner">
            <?php echo esc_html($item->name)?>
        </span>
    </span>
<?php endforeach; ?>
