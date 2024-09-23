<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
get_header('ere');
/**
 * ere_before_main_content hook.
 *
 * @hooked ere_output_content_wrapper_start - 10 (outputs opening divs for the content)
 */
do_action( 'ere_before_main_content' );
?>
<?php
global $post, $taxonomy_title, $taxonomy_name;

$custom_property_layout_style = ere_get_option('archive_property_layout_style', 'property-grid');
$custom_property_items_amount = ere_get_option('archive_property_items_amount', '6');
$custom_property_image_size = ere_get_option( 'archive_property_image_size', ere_get_loop_property_image_size_default() );
$custom_property_columns = ere_get_option('archive_property_columns', '3');
$custom_property_columns_gap = ere_get_option('archive_property_columns_gap', 'col-gap-30');
$custom_property_items_md = ere_get_option('archive_property_items_md', '3');
$custom_property_items_sm = ere_get_option('archive_property_items_sm', '2');
$custom_property_items_xs = ere_get_option('archive_property_items_xs', '1');
$custom_property_items_mb = ere_get_option('archive_property_items_mb', '1');

$property_item_class = array();
ERE_Compare::open_session();

$ss_property_view_as = isset($_SESSION["property_view_as"]) ? sanitize_text_field(wp_unslash($_SESSION["property_view_as"])) : '';

if (in_array($ss_property_view_as, array('property-list', 'property-grid'))) {
    $custom_property_layout_style = $ss_property_view_as;
}

$wrapper_classes = array(
    'ere-property clearfix',
    $custom_property_layout_style,
    $custom_property_columns_gap
);

if ($custom_property_layout_style == 'property-list') {
    $wrapper_classes[] = 'list-1-column';
}

if ($custom_property_columns_gap == 'col-gap-30') {
    $property_item_class[] = 'mg-bottom-30';
} elseif ($custom_property_columns_gap == 'col-gap-20') {
    $property_item_class[] = 'mg-bottom-20';
} elseif ($custom_property_columns_gap == 'col-gap-10') {
    $property_item_class[] = 'mg-bottom-10';
}

$wrapper_classes[] = 'columns-' . $custom_property_columns;
$wrapper_classes[] = 'columns-md-' . $custom_property_items_md;
$wrapper_classes[] = 'columns-sm-' . $custom_property_items_sm;
$wrapper_classes[] = 'columns-xs-' . $custom_property_items_xs;
$wrapper_classes[] = 'columns-mb-' . $custom_property_items_mb;
$property_item_class[] = 'ere-item-wrap';

$_atts =  [
    'item_amount' => $custom_property_items_amount
];

$query_args = [];
$tax_query = [];

if (is_tax()) {
    $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    $taxonomy_title = $current_term->name;
    $taxonomy_name = get_query_var('taxonomy');
    if (!empty($taxonomy_name)) {
        $tax_query[] = array(
            'taxonomy' => $taxonomy_name,
            'field' => 'slug',
            'terms' => $current_term->slug
        );
    }
}
if (count($tax_query) > 0) {
    $query_args['tax_query'] = [
        'relation' => 'AND',
        $tax_query,
    ];
}



$author_id = $agent_id = '';
$_user_id = isset($_GET['user_id']) ? ere_clean(wp_unslash($_GET['user_id'])) : '';
$_agent_id = isset($_GET['agent_id']) ? ere_clean(wp_unslash($_GET['agent_id'])) : '';
if (($_user_id != '' ) || ($_agent_id != '') ) {
    if ($_user_id != '') {
        $author_id = $_user_id;
        $agent_id = get_the_author_meta(ERE_METABOX_PREFIX . 'author_agent_id', $author_id);
    }
    if ($_agent_id != '') {
        $agent_id = $_agent_id;
        $author_id = get_post_meta($agent_id, ERE_METABOX_PREFIX . 'agent_user_id', true);
    }
}
$_atts['author_id'] = $author_id;
$_atts['agent_id'] = $agent_id;
$args = ere_get_property_query_args($_atts,$query_args);
$args = apply_filters('ere_property_archive_query_args',$args);
$data = new WP_Query($args);
$total_post = $data->found_posts;
?>
    <div class="ere-archive-property-wrap ere-property-wrap">
        <?php do_action('ere_archive_property_before_main_content'); ?>
        <div class="ere-archive-property archive-property">
            <div class="above-archive-property">
                <?php
                /**
                 * Hook: ere_before_archive_property.
                 *
                 * @hooked ere_template_archive_property_heading - 10
                 * @hooked ere_template_archive_property_action - 15
                 */
                do_action('ere_before_archive_property', $total_post, $taxonomy_title, $agent_id, $author_id);
                ?>
            </div>
            <div class="<?php echo esc_attr(join(' ', $wrapper_classes))?>">
                <?php if ($data->have_posts()) :
                    while ($data->have_posts()): $data->the_post(); ?>
                        <?php ere_get_template('content-property.php', array(
                            'property_item_class' => $property_item_class,
                            'custom_property_image_size' => $custom_property_image_size
                        )); ?>
                    <?php endwhile;
                else: ?>
                    <?php ere_get_template('loop/content-none.php'); ?>
                <?php endif; ?>
            </div>
            <?php
            $max_num_pages = $data->max_num_pages;
            ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages));
            wp_reset_postdata(); ?>
        </div>
        <?php do_action('ere_archive_property_after_main_content'); ?>
    </div>
<?php
/**
 * ere_after_main_content hook.
 *
 * @hooked ere_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'ere_after_main_content' );
/**
 * ere_sidebar_property hook.
 *
 * @hooked ere_sidebar_property - 10
 */
do_action('ere_sidebar_property');
get_footer('ere');