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
     src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=<?php echo esc_url(get_permalink($property_id)); ?>&choe=UTF-8"
     title="<?php echo esc_attr(get_the_title($property_id)); ?>"/>
