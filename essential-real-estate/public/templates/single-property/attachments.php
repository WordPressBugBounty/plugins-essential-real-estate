<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $attachments array
 */
$wrapper_classes = array(
    'single-property-element',
    'property-attachments',
    'ere__single-property-element',
    'ere__single-property-attachments'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_attachments_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php esc_html_e('File Attachments', 'essential-real-estate'); ?></h2>
    </div>
    <div class="ere-property-element row">
        <?php foreach ($attachments as $attach): ?>
            <div class="col-md-4 col-sm-6 mb-3 mt-0 media ere__property-attachment">
                <img class="mr-3" alt="<?php echo esc_attr($attach['name'])?>" src="<?php echo esc_url($attach['thumb']); ?>">
                <div class="media-body">
                    <h5 class="ere__property-attachment-title mb-1"><?php echo esc_html($attach['name']) ?></h5>
                    <a class="ere__property-attachment-download" target="_blank" href="<?php echo esc_url($attach['url']); ?>"><?php esc_html_e('Download', 'essential-real-estate'); ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
