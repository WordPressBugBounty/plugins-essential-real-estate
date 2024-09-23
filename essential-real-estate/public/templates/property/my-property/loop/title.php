<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
$status = get_post_status($property_id);
?>
<h4 class="ere__loop-my-property-title">
    <?php if ($status === 'publish'): ?>
        <a target="_blank" href="<?php the_permalink($property_id); ?>" title="<?php the_title_attribute(array('post' => $property_id)); ?>"><?php echo esc_html(get_the_title($property_id))  ?></a>
    <?php else: ?>
        <?php echo esc_html(get_the_title($property_id))  ?>
    <?php endif; ?>
</h4>
