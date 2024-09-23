<?php
/**
 * @var $atts
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$property_types = $property_status = $property_feature = $property_cities = $property_state =
$property_neighborhood = $property_label = $property_featured = $is_carousel = $color_scheme = $category_filter = $filter_style =
$include_heading = $heading_sub_title = $heading_title = $item_amount = $image_size = $columns_gap = $columns =
$dots = $nav = $autoplay = $autoplaytimeout = $property_type = $el_class = '';
extract(shortcode_atts(array(
    'property_types' => '',
    'property_status' => '',
    'property_feature' => '',
    'property_cities' => '',
    'property_state' => '',
    'property_neighborhood' => '',
    'property_label' => '',
    'property_featured' => '',
    'is_carousel' => '',
    'color_scheme' => 'color-dark',
    'category_filter' => '',
    'filter_style' => 'filter-isotope',
    'include_heading' => '',
    'heading_sub_title' => '',
    'heading_title' => '',
    'item_amount' => '6',
    'image_size' => ere_get_sc_property_gallery_image_size_default(),
    'columns_gap' => 'col-gap-0',
    'columns' => '4',
    'dots' => '',
    'nav' => '',
    'autoplay' => 'false',
    'autoplaytimeout' => 1000,
    'property_type' => '',
    'el_class' => ''
), $atts));

$property_item_class = array('property-item');
$property_content_class = array('property-content clearfix');
$property_content_attributes = array();
$content_attributes = array();
$filter_class = array('hidden-mb property-filter-content');

$filter_attributes = array();

if (empty($property_types)) {
    $property_types_all = get_categories(array('taxonomy' => 'property-type', 'hide_empty' => 0, 'orderby' => 'ASC'));
    $property_types = array();
    if (is_array($property_types_all)) {
        foreach ($property_types_all as $property_typ) {
            $property_types[] = $property_typ->slug;
        }
        $property_types = join(',', $property_types);
    }
}

if ($category_filter) {
    $filter_attributes['data-is-carousel'] = $is_carousel;
    $filter_attributes['data-columns-gap'] = $columns_gap;
    $filter_attributes['data-columns'] = $columns;
    $filter_attributes['data-item-amount'] = $item_amount;
    $filter_attributes['data-image-size'] = $image_size;
    $filter_attributes['data-color-scheme'] = $color_scheme;
    $filter_attributes['data-item'] = '.property-item';

    $content_attributes['data-filter-content'] = 'filter';
}
$wrapper_classes = array(
    'ere-property-gallery',
    'ere-property',
    'clearfix',
    $color_scheme,
    $el_class,
);

if ($columns_gap == 'col-gap-30') {
    $col_gap = 30;
} elseif ($columns_gap == 'col-gap-20') {
    $col_gap = 20;
} elseif ($columns_gap == 'col-gap-10') {
    $col_gap = 10;
} else {
    $col_gap = 0;
}
if (filter_var($is_carousel,FILTER_VALIDATE_BOOLEAN)) {
    $content_attributes['data-type'] = 'carousel';
    $property_content_class[] = 'owl-carousel ere__owl-carousel';

    $owl_attributes = array(
        'dots' => (bool) $dots,
        'nav' => (bool) $nav,
        'items' => (int)$columns,
        'autoplay' => (bool) $autoplay,
        'autoplayTimeout' => ($autoplaytimeout ? (int)$autoplaytimeout  : 1000),
        'responsive' => array(
            '0' => array(
                'items' => 1,
                'margin' => 0
            ),
            '480' => array(
	            'items' => 2,
	            'margin' => $col_gap
            ),
            '992' => array(
	            'items' => ($columns >= 3) ? 3 : (int)$columns,
	            'margin' => $col_gap
            ),
            '1200' => array(
	            'items' => (int)$columns,
	            'margin' => $col_gap
            )
        )
    );
    $property_content_attributes['data-plugin-options'] = $owl_attributes;

    if ($category_filter) {
        $filter_class[] = 'property-filter-carousel';
        $filter_attributes['data-filter-type'] = 'carousel';
        $content_attributes['data-layout'] = 'filter';
    }
} else {
    $content_attributes['data-type'] = 'grid';
    $content_attributes['data-layout'] = 'fitRows';

    $property_content_class[] = $columns_gap;
    if ($columns_gap == 'col-gap-30') {
        $property_item_class[] = 'mg-bottom-30';
    } elseif ($columns_gap == 'col-gap-20') {
        $property_item_class[] = 'mg-bottom-20';
    } elseif ($columns_gap == 'col-gap-10') {
        $property_item_class[] = 'mg-bottom-10';
    }
    $property_content_class[] = 'row';
    $property_content_class[] = 'columns-' . $columns;
    $property_content_class[] = 'columns-md-' . ($columns >= 3 ? 3 : $columns);
    $property_content_class[] = 'columns-sm-2';
    $property_content_class[] = 'columns-xs-2';
    $property_content_class[] = 'columns-mb-1';
    $property_item_class[] = 'ere-item-wrap';
    if ($category_filter) {
        $filter_attributes['data-filter-type'] = 'filter';
        $filter_attributes['data-filter-style'] = $filter_style;
    }
}


$_atts =  array(
    'item_amount' => ($item_amount > 0) ? $item_amount : -1,
    'featured' => $property_featured
);


if (!empty($author)) {
    $_atts['author_id'] = $author;
}

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
$args = apply_filters('ere_shortcodes_property_gallery_query_args',$args);
$data = new WP_Query($args);
$total_post = $data->found_posts;
?>
<div class="ere-property-wrap">
    <div class="<?php echo esc_attr(join(' ', $wrapper_classes))?>">
        <?php $filter_id = wp_rand(); ?>
        <?php if ($category_filter):
            $filter_item_class = 'portfolio-filter-category';
            ?>
            <div class="filter-wrap">
                <div class="filter-inner" data-admin-url="<?php echo esc_url( wp_nonce_url( ERE_AJAX_URL, 'ere_property_gallery_fillter_ajax_action', 'ere_property_gallery_fillter_ajax_nonce' ) ); ?>">
                    <?php
                        if ($include_heading) {
                            ere_template_heading(array(
                                'heading_title' => $heading_title,
                                'heading_sub_title' => $heading_sub_title,
                                'extra_classes' => array($color_scheme)
                            ));
                        }
                     ?>
                    <div data-filter_id="<?php echo esc_attr($filter_id); ?>" <?php ere_render_html_attr($filter_attributes); ?>
                        class="<?php echo esc_attr(join(' ', $filter_class)); ?>">
                        <?php
                        if (!empty($property_types)) {
                            $property_type_arr = explode(',', $property_types);?>
                            <a data-filter="*" class="<?php echo esc_attr($filter_item_class); ?> active-filter"><?php esc_html_e('All', 'essential-real-estate') ?></a>
                            <?php
                            foreach ($property_type_arr as $type_item) {
                                $type = get_term_by('slug', $type_item, 'property-type', 'OBJECT'); ?>
                                <a class="<?php echo esc_attr($filter_item_class); ?>"
                                   data-filter=".<?php echo esc_attr($type_item); ?>"><?php echo esc_attr($type->name) ?></a>
                                <?php
                            }
                        } ?>
                    </div>
                    <select class="visible-mb property-filter-mb form-control">
                        <?php
                        if (!empty($property_types)) {
                            $property_type_arr = explode(',', $property_types);?>
                            <option value="*" selected><?php esc_html_e('All', 'essential-real-estate') ?></option>
                            <?php
                            foreach ($property_type_arr as $type_item) {
                                $type = get_term_by('slug', $type_item, 'property-type', 'OBJECT'); ?>
                                <option value=".<?php echo esc_attr($type_item); ?>"><?php echo esc_html($type->name) ?></option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($is_carousel): ?>
        <div class="<?php echo esc_attr(join(' ', $property_content_class))  ?>" <?php if ($category_filter): ?> data-filter_id="<?php echo esc_attr($filter_id); ?>"<?php endif; ?>
            data-callback="owl_callback" <?php echo ere_render_html_attr($property_content_attributes); ?>
            <?php ere_render_html_attr($content_attributes);  ?>>
            <?php else: ?>
            <div class="<?php echo esc_attr(join(' ', $property_content_class))  ?>" <?php if ($category_filter): ?> data-filter_id="<?php echo esc_attr($filter_id); ?>"<?php endif; ?>
                <?php ere_render_html_attr($content_attributes);  ?>>
                <?php endif; ?>

                <?php if ($data->have_posts()): ?>
                    <?php while ($data->have_posts()): $data->the_post(); ?>
                        <?php
                            $property_id=get_the_ID();
                            $property_type_list = get_the_terms($property_id, 'property-type');
                            $property_type_class = array();
                            if ($property_type_list) {
                                foreach ($property_type_list as $type) {
                                    $property_type_class[] = $type->slug;
                                }
                            }
                        ?>
                    <div class="<?php echo esc_attr(join(' ', array_merge($property_item_class, $property_type_class))); ?>">
                        <div class="property-inner">
                            <div class="property-image">
                                <?php ere_template_loop_property_image(array(
                                    'image_size' => $image_size,
                                    'property_id' => $property_id,
                                    'image_size_default' => ere_get_sc_property_gallery_image_size_default()
                                )); ?>
                                <div class="property-item-content">
                                    <?php
                                    /**
                                     * Hook: ere_sc_property_gallery_loop_property_content.
                                     *
                                     * @hooked ere_template_loop_property_title - 5
                                     * @hooked ere_template_loop_property_price - 10
                                     * @hooked ere_template_loop_property_location - 15
                                     */
                                    do_action('ere_sc_property_gallery_loop_property_content');
                                    ?>
                                </div>
                                <?php
                                /**
                                 * Hook: ere_sc_property_gallery_after_loop_property_content.
                                 * @hooked ere_template_loop_property_link - 5
                                 */
                                do_action('ere_sc_property_gallery_after_loop_property_content');
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <?php ere_get_template('loop/content-none.php'); ?>
                <?php endif; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>