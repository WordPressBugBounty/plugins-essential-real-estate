<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $desc
 */
?>
<div class="ere__single-agency-desc">
    <?php echo wp_kses_post( $desc ); ?>
</div>
