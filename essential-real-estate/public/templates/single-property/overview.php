<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $data array
 */
$wrapper_classes = array(
    'single-property-element',
    'property-overview',
    'ere__single-property-element',
    'ere__single-property-overview'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_overview_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__( 'Overview', 'essential-real-estate' ); ?></h2>
    </div>
    <div class="ere-property-element">
        <ul class="ere__list-2-col ere__list-bg-gray">
            <?php foreach ($data as $k => $v): ?>
                <li>
                    <strong><?php echo wp_kses_post($v['title'])?></strong>
                    <?php echo wp_kses_post($v['content'])?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


