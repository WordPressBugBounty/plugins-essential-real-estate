<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $property_gallery array
 */
$wrapper_classes = array(
    'single-property-element',
    'property-gallery-wrap',
    'ere__single-property-element',
    'ere__single-property-gallery'
);
$gallery_id = 'ere_gallery-' . wp_rand();
$wrapper_class = join(' ', apply_filters('ere_single_property_gallery_wrapper_classes',$wrapper_classes));

$images_main_wrapper_classes = array(
    'single-property-image-main',
    'owl-nav-inline',
    'owl-carousel',
);

$images_main_wrapper_class = join(' ', apply_filters('ere_single_property_gallery_images_main_wrapper_classes',$images_main_wrapper_classes));

$images_thumb_wrapper_classes = array(
    'single-property-image-thumb',
    'owl-carousel',
);

$images_thumb_wrapper_class = join(' ', apply_filters('ere_single_property_gallery_images_thumb_wrapper_classes',$images_thumb_wrapper_classes));

$image_width = 870;
$image_height = 420;
$image_size = ere_get_single_property_gallery_image_size();
if (preg_match('/\d+x\d+/', $image_size)) {
    $image_size_arr = explode('x', $image_size);
    $image_width = $image_size_arr[0];
    $image_height = $image_size_arr[1];
}

$image_thumb_width = 250;
$image_thumb_height = 130;
$image_thumb_size = ere_get_single_property_gallery_thumb_image_size();
if (preg_match('/\d+x\d+/', $image_thumb_size)) {
    $image_thumb_size_arr = explode('x', $image_thumb_size);
    $image_thumb_width = $image_thumb_size_arr[0];
    $image_thumb_height = $image_thumb_size_arr[1];
}


?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="<?php echo esc_attr($images_main_wrapper_class)?>">
        <?php foreach ($property_gallery as $image): ?>
            <?php
            $image_src = ere_image_resize_id($image, $image_width, $image_height, true);
            $image_src = apply_filters('ere_property_image_main_url',$image_src,$image);
            $image_full_arr = wp_get_attachment_image_src($image, 'full');
            $image_full_src = '';
            if (is_array($image_full_arr) && isset($image_full_arr[0])) {
                $image_full_src = $image_full_arr[0];
            }
            if (empty($image_full_src)) {
                continue;
            }
            ?>
            <div class="property-gallery-item ere-light-gallery">
                <img src="<?php echo esc_url($image_src) ?>" alt="<?php the_title(); ?>"
                     title="<?php the_title(); ?>">
                <a data-thumb-src="<?php echo esc_url($image_full_src); ?>"
                   data-gallery-id="<?php echo esc_attr($gallery_id); ?>"
                   data-rel="ere_light_gallery" href="<?php echo esc_url($image_full_src); ?>"
                   class="zoomGallery"><i class="fa fa-expand"></i></a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="<?php echo esc_attr($images_thumb_wrapper_class)?>">
        <?php foreach ($property_gallery as $image): ?>
            <?php
                $image_src = ere_image_resize_id($image, $image_thumb_width, $image_thumb_height, true);
                if (empty($image_src)) {
                    continue;
                }
            ?>
            <div class="property-gallery-item">
                <img src="<?php echo esc_url($image_src) ?>" alt="<?php the_title(); ?>"
                     title="<?php the_title(); ?>">
            </div>
        <?php endforeach; ?>
    </div>
</div>
