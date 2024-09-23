<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 * @var $icon_class
 * @var $title
 * @var $icon_favorite
 * @var $icon_not_favorite
 */
$wrapper_classes = array(
  'property-favorite',
  'ere__loop-property_action-item'
);
$wrapper_class = join(' ', $wrapper_classes);
?>
<a href="javascript:void(0)" class="<?php echo esc_attr($wrapper_class)?>" data-property-id="<?php echo esc_attr(intval($property_id)) ?>"
   data-toggle="tooltip"
   title="<?php echo esc_attr($title) ?>"
   data-title-not-favorite="<?php esc_attr_e('Add to Favorite', 'essential-real-estate') ?>"
   data-title-favorited="<?php esc_attr_e('It is my favorite', 'essential-real-estate'); ?>"
   data-icon-not-favorite="<?php echo esc_attr($icon_not_favorite) ?>"
   data-icon-favorited="<?php echo esc_attr($icon_favorite) ?>">
    <i class="<?php echo esc_attr($icon_class); ?>"></i>
</a>
