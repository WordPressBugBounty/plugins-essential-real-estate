<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $property_id
 * @var $enable_create_date
 * @var $enable_views_count
 * @var $total_views
 */
global $post;

$wrapper_classes = array(
    'single-property-element',
    'property-info-footer',
    'ere__single-property-element',
    'ere__single-property-info-footer'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_footer_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-property-element">
        <?php if ($enable_create_date): ?>
            <span class="ere__date">
		        <i class="fa fa-calendar"></i> <?php echo get_the_time(get_option('date_format'),$property_id); ?>
	        </span>
        <?php endif; ?>

        <?php if ($enable_views_count): ?>
            <span class="ere__views-count">
		        <i class="fa fa-eye"></i>
                <?php
                /* translators: %s: Number of reviews. */
                echo esc_html(sprintf(_n('%s view', '%s views', $total_views, 'essential-real-estate'), ere_get_format_number($total_views)));
                ?>
	        </span>
        <?php endif; ?>
    </div>
</div>