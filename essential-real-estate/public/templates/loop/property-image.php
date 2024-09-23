<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $property_id
 * @var $image_size
 * @var $image_size_default
 */
$attach_id = get_post_thumbnail_id($property_id);
$no_image_src = ERE_PLUGIN_URL . 'public/assets/images/no-image.jpg';
$default_image = ere_get_option('default_property_image', '');
$image_size_default_args = explode('x', $image_size_default);
$width = $image_size_default_args[0];
$height = $image_size_default_args[1];
if (preg_match('/\d+x\d+/', $image_size)) {
    $image_sizes = explode('x', $image_size);
    $width = $image_sizes[0];
    $height = $image_sizes[1];
    $image_src = ere_image_resize_id($attach_id, $width, $height, true);
    if ($default_image != '') {
        if (is_array($default_image) && $default_image['url'] != '') {
            $resize = ere_image_resize_url($default_image['url'], $width, $height, true);
            if ($resize != null && is_array($resize)) {
                $no_image_src = $resize['url'];
            }
        }
    }
} else {
    if (!in_array($image_size, array('full', 'thumbnail'))) {
        $image_size = 'full';
    }
    $image_src = wp_get_attachment_image_src($attach_id, $image_size);
    if ($image_src && !empty($image_src[0])) {
        $image_src = $image_src[0];
    }
    if (!empty($image_src)) {
        list($width, $height) = getimagesize($image_src);
    }
    if ($default_image != '') {
        if (is_array($default_image) && $default_image['url'] != '') {
            $no_image_src = $default_image['url'];
        }
    }
}
if (empty($image_src)) {
    $image_src = $no_image_src;
}
?>
<img width="<?php echo esc_attr($width) ?>"
     height="<?php echo esc_attr($height) ?>"
     src="<?php echo esc_url($image_src) ?>"
     onerror="this.src = '<?php echo esc_url($no_image_src) ?>';"
     alt="<?php the_title(); ?>"
     title="<?php the_title(); ?>">

