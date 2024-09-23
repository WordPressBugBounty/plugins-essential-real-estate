<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<div class="property-link-detail">
    <a  href="<?php the_permalink($property_id); ?>" title="<?php the_title_attribute(array('post' => $property_id)); ?>"> <span><?php esc_html_e('Details', 'essential-real-estate'); ?></span>
        <i class="fa fa-long-arrow-right"></i></a>
</div>

