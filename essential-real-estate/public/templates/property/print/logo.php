<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$print_logo = ere_get_option('print_logo', '');
$attach_id = '';
if (is_array($print_logo) && !empty($print_logo['id'])) {
    $attach_id = $print_logo['id'];
}
$image_size = ere_get_option('print_logo_size', '200x100');
if (!empty($attach_id)) {
    if (preg_match('/\d+x\d+/', $image_size)) {
        $image_sizes = explode('x', $image_size);
        $image_src = ere_image_resize_id($attach_id, $image_sizes[0], $image_sizes[1], true);
    } else {
        if (!in_array($image_size, array('full', 'thumbnail'))) {
            $image_size = 'full';
        }
        $image_src = wp_get_attachment_image_src($attach_id, $image_size);
        if ($image_src && !empty($image_src[0])) {
            $image_src = $image_src[0];
        }
    }
}
if (!empty($image_src)) {
    list($width, $height) = getimagesize($image_src);
}
$page_name = get_bloginfo('name', '');
?>
<?php if (!empty($image_src)): ?>
    <div class="ere__print-property-logo">
        <img src="<?php echo esc_url($image_src) ?>" alt="<?php echo esc_attr($page_name) ?>"
             width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>">
    </div>
<?php endif; ?>
