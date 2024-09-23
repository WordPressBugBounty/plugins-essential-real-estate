<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<a class="property-link" href="<?php the_permalink($property_id); ?>" title="<?php the_title_attribute(array('post' => $property_id)); ?>"></a>
