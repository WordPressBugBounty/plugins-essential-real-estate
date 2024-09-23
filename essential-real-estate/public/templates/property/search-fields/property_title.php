<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $css_class_field
 * @var $placeholder
 */
$request_title = isset($_GET['title']) ? ere_clean(wp_unslash($_GET['title']))  : '';
if (!isset($placeholder)) {
    $placeholder = esc_html__('Title', 'essential-real-estate');
}
?>
<div class="<?php echo esc_attr($css_class_field); ?> form-group">
    <input type="text" class="form-control search-field" data-default-value=""
           value="<?php echo esc_attr($request_title); ?>"
           name="title"
           placeholder="<?php echo esc_attr($placeholder)?>">
</div>