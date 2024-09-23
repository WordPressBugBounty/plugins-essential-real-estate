<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $agency WP_Term
 */
?>
<h2 class="ere__loop-agency-title">
    <a href="<?php echo esc_url( get_term_link( $agency->slug, 'agency' ) ); ?>" title="<?php echo esc_attr( $agency->name ); ?>"><?php echo esc_html( $agency->name ); ?></a>
</h2>
