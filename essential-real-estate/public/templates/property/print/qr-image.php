<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<img class="ere__print-property-qr-image"
     src="https://quickchart.io/qr?text=<?php echo esc_url(get_permalink($property_id)); ?>&size=100"
     title="<?php echo esc_attr(get_the_title($property_id)); ?>"/>
