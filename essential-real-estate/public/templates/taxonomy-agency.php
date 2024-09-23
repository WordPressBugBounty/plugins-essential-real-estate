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
do_action( 'ere_taxonomy_agency_before_main_content' );
$agency        = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
<div class="ere-agency-single-wrap ere__single-agency-wrap">
    <?php
    /**
     * ere_taxonomy_agency_before_summary hook.
     */
    do_action( 'ere_taxonomy_agency_before_summary',$agency );
    ?>
    <?php
    /**
     * Hook: ere_taxonomy_agency_summary.
     *
     * @hooked ere_template_single_agency_header - 5
     */
    do_action( 'ere_taxonomy_agency_summary', $agency ); ?>
    <?php
    /**
     * Hook: ere_taxonomy_agency_after_summary.
     *
     * @hooked ere_template_single_agency_tabs - 5
     * @hooked ere_template_single_agency_agent - 10
     */
    do_action( 'ere_taxonomy_agency_after_summary',$agency );
    ?>
</div>
<?php
do_action( 'ere_taxonomy_agency_after_main_content' );
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