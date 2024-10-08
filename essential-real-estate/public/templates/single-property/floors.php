<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $property_floors
 */
?>
<div class="single-property-element property-floors-tab property-tab ere-tabs">
        <?php $index = 0; ?>
        <div class="ere-property-element">
            <ul data-tabcollapse id="ere-floors-tabs" class="nav nav-tabs">
                <?php foreach ($property_floors as $floor): ?>
                    <?php
	                    $nav_link_classes = array('nav-link');
	                    if ($index === 0) {
	                    	$nav_link_classes[] = 'active';
	                    }
						$floor_name = (isset($floor[ERE_METABOX_PREFIX . 'floor_name']) && !empty($floor[ERE_METABOX_PREFIX . 'floor_name'])) ? $floor[ERE_METABOX_PREFIX . 'floor_name'] : esc_html__('Floor', 'essential-real-estate') . ' ' . ($index + 1);
	                 ?>
                    <li class="nav-item">
	                    <a class="<?php echo esc_attr(join(' ',$nav_link_classes)) ?>" data-toggle="tab" href="#ere-floor-<?php echo esc_attr($index); ?>">
                            <?php echo esc_html($floor_name)?>
	                    </a>
                    </li>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </ul>
            <div class="tab-content">
                <?php $index = 0; ?>
                <?php foreach ($property_floors as $floor):
                    $image_id =  $floor[ERE_METABOX_PREFIX . 'floor_image']['id'];
                    $image_src = '';
                    $get_image_src = wp_get_attachment_image_src($image_id, 'full');
                    if (is_array($get_image_src) && count($get_image_src) > 0) {
                        $image_src = $get_image_src[0];
                    }
                    $floor_size = $floor[ERE_METABOX_PREFIX . 'floor_size'] ?? '';
                    $floor_size_postfix = $floor[ERE_METABOX_PREFIX . 'floor_size_postfix'] ?? '';
                    $floor_bathrooms = $floor[ERE_METABOX_PREFIX . 'floor_bathrooms'] ?? '';
                    $floor_price = $floor[ERE_METABOX_PREFIX . 'floor_price'] ?? '';
                    $floor_price_postfix = $floor[ERE_METABOX_PREFIX . 'floor_price_postfix'] ?? '';
                    $floor_bedrooms = $floor[ERE_METABOX_PREFIX . 'floor_bedrooms'] ?? '';
                    $floor_description = $floor[ERE_METABOX_PREFIX . 'floor_description'] ?? '';
                    $gallery_id = 'ere_floor-' . wp_rand();

	                $tab_pane_classes = array('tab-pane fade');
	                if ($index === 0) {
		                $tab_pane_classes[] = 'show active';
	                }

                    ?>
                    <div id="ere-floor-<?php echo esc_attr($index) ?>" class="<?php echo esc_attr(join(' ',$tab_pane_classes)) ?>">
                        <?php if (!empty($image_src)): ?>
                            <div class="floor-image ere-light-gallery mg-bottom-20">
                                <img src="<?php echo esc_url($image_src); ?>" alt="<?php the_title_attribute(); ?>">
                                <a data-thumb-src="<?php echo esc_url($image_src); ?>"
                                   data-gallery-id="<?php echo esc_attr($gallery_id); ?>"
                                   data-rel="ere_light_gallery" href="<?php echo esc_url($image_src); ?>"
                                   class="zoomGallery"><i
                                        class="fa fa-expand"></i></a>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($floor_description) && !empty($floor_description)): ?>
                            <div class="floor-description">
                                <p><?php echo wp_kses_post($floor_description); ?></p>
                            </div>
                        <?php endif; ?>
                        <ul class="ere__list-2-col ere__list-bg-gray">
                            <?php if (isset($floor_size) && !empty($floor_size)): ?>
                                <li>
                                    <strong><?php esc_html_e('Size', 'essential-real-estate'); ?></strong>
								<span>
                                    <?php echo esc_html($floor_size); ?>
                                    <?php if (isset($floor_size_postfix) && !empty($floor_size_postfix)): ?>
                                        <?php echo esc_html($floor_size_postfix) ?>
                                    <?php endif; ?>
								</span>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($floor_bedrooms) && !empty($floor_bedrooms)): ?>
                                <li>
                                    <strong><?php esc_html_e('Bedrooms', 'essential-real-estate'); ?></strong>
                                    <span><?php echo esc_html($floor_bedrooms); ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($floor_bathrooms) && !empty($floor_bathrooms)): ?>
                                <li>
                                    <strong><?php esc_html_e('Bathrooms', 'essential-real-estate'); ?></strong>
                                    <span><?php echo esc_html($floor_bathrooms); ?></span>
                                </li>
                            <?php endif; ?>

                            <?php if (isset($floor_price) && !empty($floor_price)): ?>
                                <li>
                                    <strong><?php esc_html_e('Price', 'essential-real-estate'); ?></strong>
                                    <span>
                                        <?php echo wp_kses_post(ere_get_format_money($floor_price)) ; ?>
                                        <?php if (isset($floor_price_postfix) && !empty($floor_price_postfix)): ?>
                                            <?php echo esc_html(' / ' . $floor_price_postfix) ?>
                                        <?php endif; ?>
                                    </span>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
