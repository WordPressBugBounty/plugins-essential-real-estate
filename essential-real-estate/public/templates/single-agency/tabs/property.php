<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $agency_id
 */

$agent_ids_arr = ere_agency_get_agent_ids($agency_id);
$agent_ids  = join( ',', $agent_ids_arr['agent_ids'] );
$author_ids = join( ',', $agent_ids_arr['agent_user_ids'] );

$layout_style = ere_get_option( 'property_of_agency_layout_style', 'property-grid' );
$item_amount = ere_get_option( 'property_of_agency_items_amount', 6 );
$image_size   = ere_get_option( 'property_of_agency_image_size', ere_get_loop_property_image_size_default() );
$show_paging  = ere_get_option( 'property_of_agency_show_paging', array() );

$column_lg = ere_get_option( 'property_of_agency_column_lg', '3' );
$column_md = ere_get_option( 'property_of_agency_column_md', '3' );
$column_sm = ere_get_option( 'property_of_agency_column_sm', '2' );
$column_xs = ere_get_option( 'property_of_agency_column_xs', '1' );
$column_mb = ere_get_option( 'property_of_agency_column_mb', '1' );

$columns_gap = ere_get_option( 'property_of_agency_columns_gap', 'col-gap-30' );

if ( ! is_array( $show_paging ) ) {
    $show_paging = array();
}

if ( in_array( "show_paging_property_of_agency", $show_paging ) ) {
    $show_paging = 'true';
} else {
    $show_paging  = '';
    $item_amount = -1;
}
echo ere_do_shortcode( 'ere_property', array(
    'layout_style' => $layout_style,
    'item_amount'  => $item_amount,
    'columns'      => $column_lg,
    'items_md'     => $column_md,
    'items_sm'     => $column_sm,
    'items_xs'     => $column_xs,
    'items_mb'     => $column_mb,
    'image_size'   => $image_size,
    'columns_gap'  => $columns_gap,
    'show_paging'  => $show_paging,
    'author_id'    => $author_ids,
    'agent_id'     => $agent_ids
) );