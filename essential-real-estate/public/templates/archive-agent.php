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
$agency = ere_get_option('agent_agency', '');
$agent_layout_style = ere_get_option('archive_agent_layout_style', 'agent-grid');
$custom_agent_image_size = ere_get_option( 'archive_agent_image_size', '270x340' );
$posts_per_page = ere_get_option('archive_agent_item_amount', 12);
$column_lg = ere_get_option('archive_agent_column_lg', '4');
$column_md = ere_get_option('archive_agent_column_md', '3');
$column_sm = ere_get_option('archive_agent_column_sm', '2');
$column_xs = ere_get_option('archive_agent_column_xs', '2');
$column_mb = ere_get_option('archive_agent_column_mb', '1');

ERE_Compare::open_session();
$ss_agent_view_as = isset($_SESSION["agent_view_as"]) ? ere_clean(wp_unslash($_SESSION["agent_view_as"])) : '';
if (in_array($ss_agent_view_as, array('agent-list', 'agent-grid'))) {
    $agent_layout_style = $ss_agent_view_as;
}

$wrapper_classes = array(
    'ere-agent clearfix',
    $agent_layout_style,
);
if ($agent_layout_style == 'agent-list') {
    $wrapper_classes[] = 'list-1-column';
}

$gf_item_wrap = '';

$gf_item_wrap = 'ere-item-wrap';
$wrapper_classes[] = 'row columns-' . $column_lg . ' columns-md-' . $column_md . ' columns-sm-' . $column_sm . ' columns-xs-' . $column_xs . ' columns-mb-' . $column_mb . '';

$args = array(
    'posts_per_page' => $posts_per_page,
    'post_type' => 'agent',
    'orderby'   => array(
        'menu_order'=>'ASC',
        'date' =>'DESC',
    ),
    'offset' => (max(1, get_query_var('paged')) - 1) * $posts_per_page,
    'ignore_sticky_posts' => 1,
    'post_status' => 'publish'
);
$sortby = isset($_GET['sortby']) ? ere_clean(wp_unslash($_GET['sortby'])) : '';
if (in_array($sortby, array('a_date','d_date','a_name','d_name'))) {
    if ($sortby == 'a_date') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } else if ($sortby == 'd_date') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }else if ($sortby == 'a_name') {
        $args['orderby'] = 'post_title';
        $args['order'] = 'ASC';
    }else if ($sortby == 'd_name') {
        $args['orderby'] = 'post_title';
        $args['order'] = 'DESC';
    }
}
if (!empty($agency)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'agency',
            'field' => 'term_id',
            'terms' => $agency,
            'operator' => 'IN'
        )
    );
}
$keyword = isset($_GET['agent_name']) ? ere_clean(wp_unslash($_GET['agent_name'])) : '';
if (!empty($keyword)) {
	$args['s'] = $keyword;
}

$args = apply_filters('ere_agent_archive_query_args',$args);
$data = new WP_Query($args);
$total_post = $data->found_posts;
$wrapper_classes = implode(' ', array_filter($wrapper_classes));
?>
    <div class="ere-archive-agent-wrap">
        <?php do_action('ere_archive_agent_before_main_content');?>
        <div class="ere-archive-agent">
            <div class="above-archive-agent ere__archive-agent-above">
                <?php
                /**
                 * Hook: ere_before_archive_agent.
                 *
                 * @hooked ere_template_archive_agent_heading - 5
                 * @hooked ere_template_archive_agent_action - 15
                 */
                do_action('ere_before_archive_agent', $total_post);
                ?>
            </div>
            <?php if ($data->have_posts()): ?>
                <div class="<?php echo esc_attr($wrapper_classes) ?>">
                    <?php while ($data->have_posts()): $data->the_post(); ?>
                        <?php ere_get_template('content-agent.php', array(
                            'gf_item_wrap' => $gf_item_wrap,
                            'agent_layout_style' => $agent_layout_style,
                            'custom_agent_image_size'=>$custom_agent_image_size
                        )); ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <?php ere_get_template('loop/content-none.php'); ?>
                <?php
            endif; ?>
            <div class="clearfix"></div>
            <?php
            $max_num_pages = $data->max_num_pages;
            ere_get_template('global/pagination.php', array('max_num_pages' => $max_num_pages));
            wp_reset_postdata(); ?>
        </div>
        <?php do_action('ere_archive_agent_after_main_content');?>
    </div>
<?php
/**
 * ere_after_main_content hook.
 *
 * @hooked ere_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'ere_after_main_content' );
/**
 * ere_sidebar_agent hook.
 *
 * @hooked ere_sidebar_agent - 10
 */
do_action('ere_sidebar_agent');
get_footer('ere');
