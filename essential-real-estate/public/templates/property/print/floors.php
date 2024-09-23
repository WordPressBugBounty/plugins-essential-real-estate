<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_floors
 */
$wrapper_classes = array(
    'single-property-element',
    'property-floor',
    'ere__single-property-element',
    'ere__single-property-floor'
);
$wrapper_class = join(' ', apply_filters('ere_print_property_floor_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__( 'Floor plans', 'essential-real-estate' ); ?></h2>
    </div>
    <div class="ere-property-element">
        <div class="ere__print-property-floors">
            <?php $index = 0;  ?>
            <?php foreach ($property_floors as $floor): ?>
                <?php
                    $floor_name = (isset($floor[ERE_METABOX_PREFIX . 'floor_name']) && !empty($floor[ERE_METABOX_PREFIX . 'floor_name'])) ? $floor[ERE_METABOX_PREFIX . 'floor_name'] : esc_html__('Floor', 'essential-real-estate') . ' ' . ($index + 1);
                    $floor_size = $floor[ERE_METABOX_PREFIX . 'floor_size'] ?? '';
                    $floor_size_postfix = $floor[ERE_METABOX_PREFIX . 'floor_size_postfix'] ?? '';
                    $floor_bathrooms = $floor[ERE_METABOX_PREFIX . 'floor_bathrooms'] ?? '';
                    $floor_price = $floor[ERE_METABOX_PREFIX . 'floor_price'] ?? '';
                    $floor_price_postfix = $floor[ERE_METABOX_PREFIX . 'floor_price_postfix'] ?? '';
                    $floor_bedrooms = $floor[ERE_METABOX_PREFIX . 'floor_bedrooms'] ?? '';
                    $floor_description = $floor[ERE_METABOX_PREFIX . 'floor_description'] ?? '';
                    $image_id = $floor[ERE_METABOX_PREFIX . 'floor_image']['id'] ?? '';
                    $image_src = '';
                    $width = 1160;
                    $height = 520;
                    if (!empty($image_id)) {
                        $image_src = ere_image_resize_id($image_id, $width, $height, true);
                    }


                ?>
                <div class="ere__print-property-floor">
                    <div class="ere__ppf-content">
                        <h4 class="ere__ppf-title mb-0"><?php  echo esc_html($floor_name)?></h4>
                        <ul class="ere__ppf-info">
                           <?php if (!empty($floor_size)): ?>
                                <li>
                                    <strong><?php echo esc_html__('Size', 'essential-real-estate');?></strong>
                                    <span><?php echo esc_html($floor_size)?> <?php if (!empty($floor_size_postfix)) {echo esc_html($floor_size_postfix);} ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($floor_bedrooms)): ?>
                                <li>
                                    <strong><?php echo esc_html__('Bedrooms', 'essential-real-estate'); ?></strong>
                                    <span><?php echo esc_html($floor_bedrooms)?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($floor_bathrooms)): ?>
                                <li>
                                    <strong><?php echo esc_html__('Bathrooms', 'essential-real-estate'); ?></strong>
                                    <span><?php echo esc_html($floor_bathrooms)?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($floor_price)): ?>
                                <li>
                                    <strong><?php echo esc_html__('Price', 'essential-real-estate'); ?></strong>
                                    <span><?php echo wp_kses_post(ere_get_format_money($floor_price)) ;?> <?php if (!empty($floor_price_postfix)) {echo ('/' . esc_html($floor_price_postfix));} ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php if (!empty($image_src)): ?>
                        <div class="ere__ppf-image">
                            <img width="<?php echo esc_attr($width) ?>"
                                 height="<?php echo esc_attr($height) ?>"
                                 src="<?php echo esc_url($image_src); ?>"
                                 alt="<?php echo esc_attr($floor_name)?>">
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($floor_description)): ?>
                        <div class="ere__ppf-desc"><?php echo wp_kses_post($floor_description)?></div>
                    <?php endif; ?>
                </div>
                <?php $index++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

