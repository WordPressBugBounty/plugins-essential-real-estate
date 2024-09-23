<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$property_item_class = array('property-item');
$property_content_class = array('property-content');
$property_content_attributes = array();

$wrapper_classes = array(
    'ere-property clearfix',
);
$custom_property_layout_style = ere_get_option( 'search_property_layout_style', 'property-grid' );
$custom_property_items_amount = ere_get_option( 'search_property_items_amount', '6' );
$custom_property_image_size = ere_get_option( 'search_property_image_size', ere_get_loop_property_image_size_default() );
$custom_property_columns      = ere_get_option( 'search_property_columns', '3' );
$custom_property_columns_gap  = ere_get_option( 'search_property_columns_gap', 'col-gap-30' );
$custom_property_items_md = ere_get_option( 'search_property_items_md', '3' );
$custom_property_items_sm = ere_get_option( 'search_property_items_sm', '2' );
$custom_property_items_xs = ere_get_option( 'search_property_items_xs', '1' );
$custom_property_items_mb = ere_get_option( 'search_property_items_mb', '1' );

ERE_Compare::open_session();

$ss_property_view_as = isset($_SESSION["property_view_as"]) ? sanitize_text_field(wp_unslash($_SESSION["property_view_as"])) : '';
if(in_array($ss_property_view_as, array('property-list', 'property-grid'))) {
    $custom_property_layout_style = $ss_property_view_as;
}
$property_item_class         = array();
$wrapper_classes = array(
    'ere-property clearfix',
    $custom_property_layout_style,
    $custom_property_columns_gap
);

if($custom_property_layout_style=='property-list'){
    $wrapper_classes[] = 'list-1-column';
}

if ( $custom_property_columns_gap == 'col-gap-30' ) {
    $property_item_class[] = 'mg-bottom-30';
} elseif ( $custom_property_columns_gap == 'col-gap-20' ) {
    $property_item_class[] = 'mg-bottom-20';
} elseif ( $custom_property_columns_gap == 'col-gap-10' ) {
    $property_item_class[] = 'mg-bottom-10';
}

$wrapper_classes[]     = 'columns-' . $custom_property_columns;
$wrapper_classes[]     = 'columns-md-' . $custom_property_items_md;
$wrapper_classes[]     = 'columns-sm-' . $custom_property_items_sm;
$wrapper_classes[]     = 'columns-xs-' . $custom_property_items_xs;
$wrapper_classes[]     = 'columns-mb-' . $custom_property_items_mb;
$property_item_class[] = 'ere-item-wrap';

$_atts =  [
    'item_amount' => $custom_property_items_amount
];

$enable_advanced_search_status_tab = ere_get_option( 'enable_advanced_search_status_tab', '1' );
if (filter_var($enable_advanced_search_status_tab, FILTER_VALIDATE_BOOLEAN)) {
    $_atts['status'] = ere_get_property_status_default_value();
}
$args =  ere_get_property_query_args($_atts);
$args = apply_filters('ere_advanced_search_query_args',$args);
$parameters = ere_get_property_query_parameters();
$parameters = join('; ', $parameters);
$data       = new WP_Query( $args );
$search_query=$args;
$total_post = $data->found_posts;
wp_enqueue_script(ERE_PLUGIN_PREFIX . 'archive-property');
?>
<div class="ere-advanced-search-wrap ere-property-wrap">
    <?php
    /**
     * Hook: ere_before_advanced_search.
     *
     * @hooked ere_template_property_advanced_search_form - 10
     */
    do_action('ere_before_advanced_search',$parameters,$search_query);
    ?>
    <div class="ere-archive-property">
        <div class="above-archive-property">
            <?php
            /**
             * Hook: ere_before_archive_property.
             *
             * @hooked ere_template_archive_property_heading - 10
             * @hooked ere_template_archive_property_action - 15
             */
            do_action('ere_before_archive_property', $total_post);
            ?>
        </div>
        <div class="<?php echo esc_attr(join( ' ', $wrapper_classes )) ?>">
            <?php if ( $data->have_posts() ) :
                while ( $data->have_posts() ): $data->the_post(); ?>

                    <?php ere_get_template( 'content-property.php', array(
                        'custom_property_image_size' => $custom_property_image_size,
                        'property_item_class' => $property_item_class
                    )); ?>

                <?php endwhile;
            else: ?>
                <?php ere_get_template('loop/content-none.php'); ?>
            <?php endif; ?>
        </div>
        <?php
        $max_num_pages = $data->max_num_pages;
        ere_get_template( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) );
        wp_reset_postdata(); ?>
    </div>
    <?php do_action('ere_advanced_search_after_main_content'); ?>
</div>