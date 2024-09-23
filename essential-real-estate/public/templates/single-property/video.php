<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $video_url
 * @var $video_image
 */
$video_classes = array('video');
if (!empty($video_image)) {
    $video_classes[] = 'video-has-thumb';
}
$video_class = join(' ', $video_classes);

$wrapper_classes = array(
    'single-property-element',
    'property-vide',
    'ere__single-property-element',
    'ere__single-property-video'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_video_wrapper_classes',$wrapper_classes));

?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__( 'Video', 'essential-real-estate' ); ?></h2>
    </div>
    <div class="ere-property-element">
        <div class="<?php echo esc_attr($video_class)?>">
            <div class="entry-thumb-wrap">
                <?php if (wp_oembed_get($video_url)) : ?>
                    <?php
                    $image_src = ere_image_resize_id($video_image, 870, 420, true);
                    $width = '870';
                    $height = '420';
                    if (!empty($image_src)):?>
                        <div class="entry-thumbnail property-video ere-light-gallery">
                            <img class="img-responsive" src="<?php echo esc_url($image_src); ?>"
                                 width="<?php echo esc_attr($width) ?>"
                                 height="<?php echo esc_attr($height) ?>"
                                 alt="<?php the_title_attribute(); ?>"/>
                            <a class="ere-view-video"
                               data-src="<?php echo esc_url($video_url); ?>"><i
                                        class="fa fa-play-circle-o"></i></a>
                        </div>
                    <?php else: ?>
                        <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                            <?php echo wp_oembed_get($video_url, array('wmode' => 'transparent')); ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                        <?php echo wp_kses_post($video_url); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


