<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
/**
 * @var $price
 * @var $price_short
 * @var $price_unit
 * @var $price_prefix
 * @var $price_postfix
 * @var $empty_price_text
 * @var $extra_class
 */
$wrapper_classes = array(
  'property-price',
  'ere__loop-property-price'
);
if (isset($extra_class)) {
    $wrapper_classes[] = $extra_class;
}
$wrapper_class = join(' ', apply_filters('ere_loop_property_price_wrapper_classes',$wrapper_classes));
?>
<?php if ($price !== ''): ?>
	<span class="<?php echo esc_attr($wrapper_class)?>">
		<?php if ($price_prefix !== ''): ?>
			<span class="property-price-prefix"><?php echo esc_html($price_prefix)?></span>
		<?php endif; ?>
		<?php echo wp_kses_post(ere_get_format_money($price_short,$price_unit))  ?>
		<?php if ($price_postfix !== ''): ?>
			<span class="property-price-postfix">/ <?php echo esc_html($price_postfix)?></span>
		<?php endif; ?>
	</span>
<?php elseif ($empty_price_text !== ''): ?>
    <span class="<?php echo esc_attr($wrapper_class)?>">
		<?php echo esc_html($empty_price_text);?>
	</span>
<?php endif; ?>
