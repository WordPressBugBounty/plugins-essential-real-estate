<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $agency WP_Term
 * @var $image
 */
list( $width, $height ) = getimagesize( $image );
?>
<div class="ere__single-agency-avatar-wrap">
    <div class="ere__single-agency-avatar">
        <a href="<?php echo esc_url( get_term_link($agency, 'agency' ) ); ?>" title="<?php echo esc_attr( $agency->name ); ?>">
            <img width="<?php echo esc_attr( $width ) ?>"
                 height="<?php echo esc_attr( $height ) ?>"
                 src="<?php echo esc_url( $image ) ?>"
                 alt="<?php echo esc_attr( $agency->name ); ?>"
                 title="<?php echo esc_attr( $agency->name ); ?>">
        </a>
    </div>
</div>

