<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Shortcode attributes
 * @var $atts
 */
$item_amount = $show_paging = $include_heading = $heading_sub_title
	= $heading_title  = $el_class = '';
extract( shortcode_atts( array(
	'item_amount'       => '6',
	'show_paging'       => '',
	'include_heading'   => '',
	'heading_sub_title' => '',
	'heading_title'     => '',
	'el_class'          => ''
), $atts ) );

$agency_item_classes = array( 'agency-item','ere__loop-agency-item');
$wrapper_classes = array(
	'ere-agency',
    'ere-agency-wrap',
    'ere__agency-wrap',
	$el_class
);
$keyword = '';$unique=array();
$args = array(
	'number' => ( $item_amount > 0 ) ? $item_amount : - 1,
	'taxonomy'      => 'agency',
	'orderby'        => 'date',
	'offset' => (max(1, get_query_var('paged')) - 1) * $item_amount,
	'order'          => 'DESC',
);

if (isset ($_GET['keyword'])) {
	$keyword = ere_clean(wp_unslash($_GET['keyword']));
	$q1 = get_categories(array(
		'fields' => 'ids',
		'taxonomy'      => 'agency',
		'name__like' => $keyword
	));
	$q2 = get_categories(array(
		'fields' => 'ids',
		'taxonomy'      => 'agency',
		'meta_query' => array(
			array(
				'key'       => 'agency_address',
				'value'     => $keyword,
				'compare'   => 'LIKE'
			)
		)
	));
	$unique = array_unique( array_merge( $q1, $q2 ) );
	if(empty($unique))
	{
		$unique[]=-1;
	}
	$args['include'] = $unique;
}

$sortby = isset($_GET['sortby']) ? ere_clean(wp_unslash($_GET['sortby'])) : '';
if (in_array($sortby, array('a_date','d_date','a_name','d_name'))) {
	if ($sortby == 'a_date') {
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
	} else if ($sortby == 'd_date') {
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	}else if ($sortby == 'a_name') {
		$args['orderby'] = 'name__like';
		$args['order'] = 'ASC';
	}else if ($sortby == 'd_name') {
		$args['orderby'] = 'name__like';
		$args['order'] = 'DESC';
	}
}
$args = apply_filters('ere_shortcodes_agency_query_args',$args);
$agencies = get_categories($args);
$agency_item_class = join(' ',$agency_item_classes);
$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)  ?>">
    <?php if ( $include_heading && (!empty( $heading_sub_title ) || !empty( $heading_title ))): ?>
        <div class="ere__archive-agency-above">
            <?php ere_template_heading(array(
                'heading_title' => $heading_title,
                'heading_sub_title' => $heading_sub_title
            )) ?>
            <div class="ere__archive-actions ere__archive-agency-actions">
                <?php
                /**
                 * Hook: ere_archive_agency_actions.
                 *
                 * @hooked ere_template_archive_agency_action_search - 5
                 * @hooked ere_template_archive_agency_action_orderby - 10
                 */
                do_action('ere_archive_agency_actions');
                ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="agency-content ere__agency-list">
        <?php if ( $agencies ) :
            foreach ($agencies as $agency) :
                ?>
                <div class="<?php echo esc_attr($agency_item_class); ?>">
                    <?php
                    /**
                     * Hook: ere_before_loop_agency_content.
                     *
                     * @hooked ere_template_loop_agency_image - 10
                     */
                    do_action('ere_before_loop_agency_content',$agency);
                    ?>
                    <div class="agency-item-content ere__loop-agency-content">
                        <div class="ere__loop-agency-heading">
                            <?php
                            /**
                             * Hook: ere_loop_property_heading.
                             *
                             * @hooked ere_template_loop_agency_title - 5
                             * @hooked ere_template_loop_agency_address - 10
                             * @hooked ere_template_loop_agency_social - 15
                             */
                            do_action('ere_loop_agency_heading',$agency);
                            ?>
                        </div>
                        <?php
                        /**
                         * Hook: ere_after_loop_agency_heading.
                         *
                         * @hooked ere_template_loop_agency_desc - 5
                         * @hooked ere_template_loop_agency_meta - 10
                         */
                        do_action('ere_after_loop_agency_heading',$agency);
                        ?>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <?php ere_get_template('loop/content-none.php'); ?>
        <?php endif; ?>
    </div>
    <?php if (filter_var($show_paging,FILTER_VALIDATE_BOOLEAN)): ?>
        <div class="agency-paging-wrap ere__agency-paging" data-admin-url="<?php echo esc_url(ERE_AJAX_URL) ; ?>"
             data-items-amount="<?php echo esc_attr( $item_amount ); ?>" >
            <?php
            $args = array(
                'taxonomy'      => 'agency'
            );
            if (isset ($_GET['keyword'])) {
                $args['include'] = $unique;
            }
            $all_agency = get_categories($args);
            $max_num_pages = floor(count( $all_agency ) / $item_amount);
            if(count( $all_agency ) % $item_amount > 0) {
                $max_num_pages++;
            }
            ere_get_template( 'global/pagination.php', array( 'max_num_pages' => $max_num_pages ) );
            ?>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>