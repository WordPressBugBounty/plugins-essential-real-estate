<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<?php echo get_the_term_list($property_id,'property-type','<div class="property-type-list"><i class="fa fa-tag"></i>',', ','</div>') ?>
