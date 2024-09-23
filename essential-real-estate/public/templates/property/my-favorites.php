<?php
/**
 * @var $favorites
 * @var $max_num_pages
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!is_user_logged_in()) {
    echo ere_get_template_html('global/access-denied.php', array('type' => 'not_login'));
    return;
}
wp_enqueue_style('dashicons');

$wrapper_classes = array(
    'ere-property',
    'clearfix',
    'property-grid',
    'col-gap-10',
    'columns-3',
    'columns-md-2',
    'columns-sm-2',
    'columns-xs-1'
);
$property_item_class = apply_filters('ere_my_favorites_property_item_class',array(
    'ere-item-wrap',
    'mg-bottom-10'
));
$custom_property_image_size = ere_get_option('archive_property_image_size', ere_get_loop_property_image_size_default());
$wrapper_class = join(' ', apply_filters('ere_my_favorites_wrapper_classes',$wrapper_classes) );
?>
<div class="row ere-user-dashboard">
    <div class="col-lg-3 ere-dashboard-sidebar">
        <?php ere_get_template('global/dashboard-menu.php', array('cur_menu' => 'my_favorites')); ?>
    </div>
    <div class="col-lg-9 ere-dashboard-content">
        <div class="card ere-card ere-my-favorites">
            <div class="card-header"><h5 class="card-title m-0"><?php echo esc_html__('My Favorites', 'essential-real-estate'); ?></h5></div>
            <div class="card-body">
                <div class="<?php echo esc_attr($wrapper_class)  ?>">
                    <?php if ($favorites->have_posts()) :
                        while ($favorites->have_posts()): $favorites->the_post(); ?>
                            <?php ere_get_template('content-property.php', array(
                                'property_item_class' => $property_item_class,
                                'custom_property_image_size' => $custom_property_image_size
                            )); ?>
                        <?php endwhile;
                    else: ?>
                        <?php ere_get_template('loop/content-none.php'); ?>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <?php
                    $max_num_pages = $favorites->max_num_pages;
                    ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages));
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
</div>