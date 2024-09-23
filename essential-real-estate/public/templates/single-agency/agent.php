<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $agency WP_Term
 */
$wrapper_classes = array(
    'ere__single-agency-element',
    'ere__single-agency-agent'
);

$wrapper_class = join(' ', $wrapper_classes);

$layout_style = ere_get_option( 'agents_of_agency_layout_style', 'agent-slider' );
$item_amount  = ere_get_option( 'agents_of_agency_item_amount', 12 );
$image_size   = ere_get_option( 'agents_of_agency_image_size', '270x340' );
$show_paging  = ere_get_option( 'agents_of_agency_show_paging', array() );

$column_lg = ere_get_option( 'agents_of_agency_column_lg', '4' );
$column_md = ere_get_option( 'agents_of_agency_column_md', '3' );
$column_sm = ere_get_option( 'agents_of_agency_column_sm', '2' );
$column_xs = ere_get_option( 'agents_of_agency_column_xs', '2' );
$column_mb = ere_get_option( 'agents_of_agency_column_mb', '1' );

if ( ! is_array( $show_paging ) ) {
    $show_paging = array();
}
if ( in_array( "show_paging_other_agent", $show_paging ) ) {
    $agent_show_paging = 'true';
} else {
    $agent_show_paging            = '';
    $item_amount = - 1;
}

if ( $layout_style == 'agent-slider' ) {
    $agent_show_paging = '';
}
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading">
        <h2><?php echo esc_html__( 'Our Agents', 'essential-real-estate' ); ?></h2>
        <p><?php echo esc_html__( 'We Have Professional Agents', 'essential-real-estate' ); ?></p>
    </div>
    <?php
    echo ere_do_shortcode( 'ere_agent', array(
        'agency'       => $agency->slug,
        'layout_style' => $layout_style,
        'item_amount'  => $item_amount,
        'items'        => $column_lg,
        'items_md'     => $column_md,
        'items_sm'     => $column_sm,
        'items_xs'     => $column_xs,
        'items_mb'     => $column_mb,
        'image_size'   => $image_size,
        'show_paging'  => $agent_show_paging
    ) );
    ?>
</div>
