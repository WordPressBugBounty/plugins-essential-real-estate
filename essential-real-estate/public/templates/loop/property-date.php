<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
?>
<div class="property-date">
    <i class="fa fa-calendar"></i>
    <?php
    $get_the_time    = get_the_time( 'U' );
    $current_time    = current_time( 'timestamp' );
    $human_time_diff = human_time_diff( $get_the_time, $current_time );
    /* translators: %s: Human time diff. */
    echo esc_html(sprintf( _x( ' %s ago', '%s = human-readable time difference', 'essential-real-estate' ), $human_time_diff )); ?>
</div>
