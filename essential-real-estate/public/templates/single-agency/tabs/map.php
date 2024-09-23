<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $location
 */
?>
<div id="ere__single_agency_map" class="ere__map-canvas ere__single-agency-map" data-location="<?php echo esc_attr(wp_json_encode($location)) ?>"></div>