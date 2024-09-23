<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 19/09/2017
 * Time: 11:00 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$number = (!empty($instance['number'])) ? absint($instance['number']) : 3;
if (!$number)
    $number = 3;

$args = array(
    'post_type' => 'property',
    'ignore_sticky_posts' => true,
    'posts_per_page' => $number,
    'orderby'   => array(
        'menu_order'=>'ASC',
        'date' =>'DESC',
    ),
    'post_status' => 'publish',
);
$filter_by_agent= (!empty($instance['filter_by_agent'])) ? ($instance['filter_by_agent']) : '0';
if ($filter_by_agent==1 && is_single() &&  get_post_type() == 'agent') {
    $agent_id = get_the_ID();
    $agent_post_meta_data = get_post_custom( $agent_id);
    $agent_user_id = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id'][0] : '';
    $user = get_user_by('id', $agent_user_id);
    if (empty($user)) {
        $agent_user_id = 0;
    }
    $args['meta_query'] = array();
    if (!empty($agent_user_id) && !empty($agent_id)) {
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'key' => ERE_METABOX_PREFIX . 'property_agent',
                'value' => explode(',', $agent_id),
                'compare' => 'IN'
            ),
            array(
                'key' => ERE_METABOX_PREFIX . 'property_author',
                'value' => explode(',', $agent_user_id),
                'compare' => 'IN'
            )
        );
    } else {
        if (!empty($agent_user_id)) {
            $args['author'] = $agent_user_id;
        } else if (!empty($agent_id)) {
            $args['meta_query'] = array(
                array(
                    'key' => ERE_METABOX_PREFIX . 'property_agent',
                    'value' => explode(',', $agent_id),
                    'compare' => 'IN'
                )
            );
        }
    }
}
$args['meta_query'][] = array(
    'key' => ERE_METABOX_PREFIX . 'property_featured',
    'value' => true,
    'compare' => '=',
);
$data = new WP_Query($args);

$owl_attributes = array(
	'items' => 1,
	'dots' => true,
	'nav' => false,
	'autoplay' => false,
	'loop' => true,
	'responsive' => array()
);
?>
<div class="list-featured-properties ere-property property-grid">
    <div class="owl-carousel ere__owl-carousel" data-plugin-options="<?php echo esc_attr(wp_json_encode($owl_attributes)) ?>">
        <?php if ($data->have_posts()):
            while ($data->have_posts()): $data->the_post();
                $image_size = apply_filters('ere_widget_featured_properties_image_size','370x180') ;
                ?>
                <div class="property-item">
                    <div class="property-inner">
                        <?php ere_template_loop_property_thumbnail(array(
                            'image_size' => $image_size
                        ));?>
                        <div class="property-item-content">
	                        <?php ere_template_loop_property_title(); ?>
	                        <?php ere_template_loop_property_price(); ?>
	                        <?php ere_template_loop_property_location(); ?>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
        else: ?>
            <?php ere_get_template('loop/content-none.php'); ?>
        <?php endif; ?>
    </div>
    <?php if(isset($instance['link']) && !empty($instance['link'])):?>
    <a class="ere-link-more" href="<?php echo esc_url($instance['link']) ?>"><?php esc_html_e('More...', 'essential-real-estate'); ?></a>
    <?php endif; ?>
</div>
<?php
wp_reset_postdata();