<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $name
 * @var $link
 */
?>
<div class="property-agent">
    <a href="<?php echo esc_url($link)?>" title="<?php echo esc_attr($name)?>">
        <i class="fa fa-user"></i>
        <span><?php echo esc_html( $name ) ?></span>
    </a>
</div>
