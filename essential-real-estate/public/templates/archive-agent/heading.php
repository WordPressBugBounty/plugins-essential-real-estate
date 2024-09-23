<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $total_post
 */
?>
<div class="ere-heading">
    <h2><?php esc_html_e('Agents', 'essential-real-estate') ?>
        <sub>(<?php echo esc_html(ere_get_format_number($total_post)) ; ?>)</sub></h2>
</div>