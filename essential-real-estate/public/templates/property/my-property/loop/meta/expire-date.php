<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 */
$number_expire_days = ere_get_option('number_expire_days');
$property_date = get_post_timestamp($property_id);
$timestamp = $property_date + intval($number_expire_days) * 24 * 60 * 60;
$expired_date = gmdate('Y-m-d H:i:s', $timestamp);
$expired_date = new DateTime($expired_date);

$now = new DateTime();
$interval = $now->diff($expired_date);

$days = $interval->days;
$hours = $interval->h;
$invert = $interval->invert;

$wrapper_classes = array(
    'ere__loop-my-property-meta-item',
    'ere__loop-property-meta-expire-date'
);

$wrapper_class = join(' ', $wrapper_classes);

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <?php if ($invert == 0): ?>
        <?php if ($days > 0): ?>
            <span class="ere__loop-my-property-date-expire"><?php /* translators: %1$s: Number of day; %2$s: Number of hours. */ echo sprintf(esc_html__('Expire: %1$s days %2$s hours', 'essential-real-estate'), $days, $hours)?></span>
        <?php else: ?>
            <span class="ere__loop-my-property-date-expire"><?php /* translators: %s: Number of hours. */ echo sprintf(esc_html__('Expire: %s hours', 'essential-real-estate'), $hours)?></span>
        <?php endif; ?>
    <?php else: ?>
        <?php $expired_date = date_i18n(get_option('date_format'), $timestamp); ?>
        <span class="ere__loop-my-property-date-expire ere__expired"><?php /* translators: %s: Number of expired date. */ echo sprintf(esc_html__('Expired: %s', 'essential-real-estate'), $expired_date)?></span>
    <?php endif; ?>
</div>
