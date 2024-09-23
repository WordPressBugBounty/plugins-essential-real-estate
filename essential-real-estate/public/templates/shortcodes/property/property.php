<?php
/**
 * Shortcode attributes
 * @var $atts
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$layout_style = $property_type = $property_status = $property_feature = $property_city = $property_state = $property_neighborhood =
$property_label = $property_featured = $item_amount = $columns_gap = $columns = $items_md = $items_sm = $items_xs = $items_mb =
$view_all_link = $image_size = $show_paging = $include_heading = $heading_sub_title = $heading_title =
$dots = $nav = $move_nav = $nav_position = $autoplay = $autoplaytimeout = $paged = $author_id = $agent_id = $el_class = '';
extract(shortcode_atts(array(
    'layout_style' => 'property-grid',
    'property_type' => '',
    'property_status' => '',
    'property_feature' => '',
    'property_city' => '',
    'property_state' => '',
    'property_neighborhood' => '',
    'property_label' => '',
    'property_featured' => '',
    'item_amount' => '6',
    'columns_gap' => 'col-gap-30',
    'columns' => '3',
    'items_lg' => '4',
    'items_md' => '3',
    'items_sm' => '2',
    'items_xs' => '1',
    'items_mb' => '1',
    'view_all_link' => '',
    'image_size' => ere_get_loop_property_image_size_default(),
    'show_paging' => '',
    'include_heading' => '',
    'heading_sub_title' => '',
    'heading_title' => '',
    'dots' => '',
    'nav' => 'true',
    'move_nav' => '',
    'nav_position' => '',
    'autoplay' => 'true',
    'autoplaytimeout' => '1000',
    'paged' => '1',
    'author_id' => '',
    'agent_id' => '',
    'el_class' => ''
), $atts));
$property_item_class = array('ere-item-wrap property-item');
$property_content_classes = array('property-content');
$property_content_attributes = array();
$wrapper_attributes = array();
$wrapper_classes = array(
    'ere-property',
    'clearfix',
    $layout_style,
    $el_class
);

if ($layout_style == 'property-zigzac' || $layout_style == 'property-list') {
    $columns_gap = 'col-gap-0';
}
if ($layout_style == 'property-carousel') {
    $property_content_classes[] = 'owl-carousel ere__owl-carousel';
    if ($nav) {
	    if (in_array($nav_position, array('top-right','bottom-center'))) {
            $property_content_classes[] = 'owl-nav-size-sm';
	    }
        if (!$move_nav && !empty($nav_position)) {
            $property_content_classes[] = 'owl-nav-' . $nav_position;
        } elseif ($move_nav) {
            $property_content_classes[] = 'owl-nav-top-right';
            $property_content_classes[] = 'owl-nav-size-sm';
            $wrapper_classes[] = 'owl-move-nav-par-with-heading';
        }
    }
    if ($columns_gap == 'col-gap-30') {
        $col_gap = 30;
    } elseif ($columns_gap == 'col-gap-20') {
        $col_gap = 20;
    } elseif ($columns_gap == 'col-gap-10') {
        $col_gap = 10;
    } else {
        $col_gap = 0;
    }

	$owl_attributes = array(
		'dots' => (bool) $dots,
		'nav' => (bool) $nav,
		'autoplay' => (bool) $autoplay,
		'autoplayTimeout' => $autoplaytimeout ? (int)$autoplaytimeout  : 1000,
		'responsive' => array(
			"0" => array(
				'items' => (int)$items_mb,
				'margin' => ($items_mb > 1) ? $col_gap  : 0
			),
			"480" => array(
				'items' => (int)$items_xs,
				'margin' => ($items_xs > 1) ? $col_gap  : 0
			),
			"768" => array(
				'items' => (int)$items_sm,
				'margin' => ($items_sm > 1) ? $col_gap  : 0
			),
			"992" => array(
				'items' => (int)$items_md,
				'margin' => ($items_md > 1) ? $col_gap  : 0
			),
			"1200" => array(
				'items' => ($columns >= 4) ? 4 : (int) $columns,
				'margin' => ($columns > 1) ? $col_gap  : 0
			),
			"1820" => array(
				'items' => (int)$columns,
				'margin' => $col_gap
			)
		)
	);

    $property_content_attributes['data-plugin-options'] = $owl_attributes;
} else {
    $property_content_classes[] = $columns_gap;
    if ($columns_gap == 'col-gap-30') {
        $property_item_class[] = 'mg-bottom-30';
    } elseif ($columns_gap == 'col-gap-20') {
        $property_item_class[] = 'mg-bottom-20';
    } elseif ($columns_gap == 'col-gap-10') {
        $property_item_class[] = 'mg-bottom-10';
    }
    $property_content_classes[] = 'clearfix';
    if ($layout_style == 'property-grid') {
        $property_content_classes[] = 'columns-' . $columns . ' columns-md-' . $items_md . ' columns-sm-' . $items_sm . ' columns-xs-' . $items_xs . ' columns-mb-' . $items_mb;
    }
    if ($layout_style == 'property-list') {
        //$image_size = '330x180';
        $property_item_class[] = 'mg-bottom-30';
    }
    if ($layout_style == 'property-zigzac') {
        //$image_size = '290x270';
        $property_content_classes[] = 'columns-2 columns-md-2 columns-sm-1';
    }
}

if (!empty($view_all_link)) {
    $wrapper_attributes['data-view-all-link'] = $view_all_link;
}

$_atts =  array(
    'item_amount' => ($item_amount > 0) ? $item_amount : -1,
    'paged' => $paged,
    'author_id' => $author_id,
    'agent_id' => $agent_id,
    'featured' => $property_featured
);

if (!empty($property_type)) {
    $_atts['type'] = explode(',', $property_type);
}
if (!empty($property_status)) {
    $_atts['status'] = explode(',', $property_status);
}
if (!empty($property_feature)) {
    $_atts['features'] = explode(',', $property_feature);
}

if (!empty($property_city)) {
    $_atts['city'] = explode(',', $property_city);
}
if (!empty($property_state)) {
    $_atts['state'] = explode(',', $property_state);
}
if (!empty($property_neighborhood)) {
    $_atts['neighborhood'] = explode(',', $property_neighborhood);
}

if (!empty($property_label)) {
    $_atts['label'] = explode(',', $property_label);
}

$args = ere_get_property_query_args($_atts);
$args = apply_filters('ere_shortcodes_property_query_args',$args);
$data = new WP_Query($args);
$total_post = $data->found_posts;
$property_content_class = join(' ', apply_filters('ere_shortcodes_property_content_classes',$property_content_classes,$atts));
$wrapper_class = join(' ', apply_filters('ere_shortcodes_property_wrapper_classes',$wrapper_classes,$atts));
?>
<div class="ere-property-wrap">
    <div class="<?php echo esc_attr($wrapper_class)  ?>" <?php ere_render_html_attr($wrapper_attributes); ?>>
        <?php if ($include_heading) : ?>
        <div class="container">
            <?php ere_template_heading(array(
                'heading_title' => $heading_title,
                'heading_sub_title' => $heading_sub_title,
            )) ?>
        </div>
        <?php endif; ?>
        <?php if ($layout_style == 'property-carousel'): ?>
        <div class="<?php echo esc_attr($property_content_class)  ?>" data-section-id="<?php echo esc_attr(uniqid()) ; ?>"
             data-callback="owl_callback" <?php ere_render_html_attr($property_content_attributes); ?>>
            <?php else: ?>
            <div class="<?php echo esc_attr($property_content_class)  ?>">
                <?php endif; ?>
                <?php if ($data->have_posts()) :
                    while ($data->have_posts()): $data->the_post();
	                    ere_get_template('content-property.php', array(
		                    'custom_property_image_size' => $image_size,
		                    'property_item_class' => $property_item_class,
	                    ));
                        ?>
                    <?php endwhile;
                else: if (empty($agent_id) && empty($author_id)): ?>
                    <?php ere_get_template('loop/content-none.php'); ?>
                <?php endif; ?>
                <?php endif; ?>
                <?php if ($layout_style == 'property-carousel'): ?>
            </div>
            <?php else: ?>
        </div>
    <?php endif; ?>
        <?php if (!empty($view_all_link)): ?>
            <div class="view-all-link">
                <a href="<?php echo esc_url($view_all_link) ?>"
                   class="btn btn-xs btn-dark btn-classic"><?php esc_html_e('View All', 'essential-real-estate') ?></a>
            </div>
        <?php endif; ?>
        <?php
        if ($show_paging == 'true') { ?>
            <div class="property-paging-wrap"
                 data-admin-url="<?php echo esc_url(wp_nonce_url( ERE_AJAX_URL, 'ere_property_paging_ajax_action', 'ere_property_paging_ajax_nonce' ))   ?>"
                 data-layout="<?php echo esc_attr($layout_style); ?>"
                 data-items-amount="<?php echo esc_attr($item_amount); ?>"
                 data-columns="<?php echo esc_attr($columns); ?>"
                 data-image-size="<?php echo esc_attr($image_size); ?>"
                 data-columns-gap="<?php echo esc_attr($columns_gap); ?>"
                 data-view-all-link="<?php echo esc_attr($view_all_link); ?>"
                 data-property-type="<?php echo esc_attr($property_type); ?>"
                 data-property-status="<?php echo esc_attr($property_status); ?>"
                 data-property-feature="<?php echo esc_attr($property_feature); ?>"
                 data-property-city="<?php echo esc_attr($property_city); ?>"
                 data-property-state="<?php echo esc_attr($property_state); ?>"
                 data-property-neighborhood="<?php echo esc_attr($property_neighborhood); ?>"
                 data-property-label="<?php echo esc_attr($property_label); ?>"
                 data-property-featured="<?php echo esc_attr($property_featured); ?>"
                 data-author-id="<?php echo esc_attr($author_id); ?>"
                 data-agent-id="<?php echo esc_attr($agent_id); ?>">
                <?php $max_num_pages = $data->max_num_pages;
                set_query_var('paged', $paged);
                ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages));
                ?>
            </div>
        <?php }
        wp_reset_postdata(); ?>
    </div>
</div>

