<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/**
 * @var $isRTL
 * @var $property_id
 */
$post_object = get_post( $property_id );
if (! is_a( $post_object, 'WP_Post' ) || $post_object->post_type !== 'property' ) {
    echo esc_html__('Posts ineligible to print!', 'essential-real-estate');
    return;
}
remove_action( 'wp_head',             '_wp_render_title_tag',            1     );
remove_action( 'wp_head',             'wp_resource_hints',               2     );
remove_action( 'wp_head',             'feed_links',                      2     );
remove_action( 'wp_head',             'feed_links_extra',                3     );
remove_action( 'wp_head',             'rsd_link'                               );
remove_action( 'wp_head',             'wlwmanifest_link'                       );
remove_action( 'wp_head',             'adjacent_posts_rel_link_wp_head', 10);
remove_action( 'publish_future_post', 'check_and_publish_future_post',   10);
remove_action( 'wp_head',             'noindex',                          1    );
remove_action( 'wp_head',             'print_emoji_detection_script',     7    );
remove_action( 'wp_head',             'wp_generator'                           );
remove_action( 'wp_head',             'rel_canonical'                          );
remove_action( 'wp_head',             'wp_shortlink_wp_head',            10);
remove_action( 'wp_head',             'wp_custom_css_cb',                101   );
remove_action( 'wp_head',             'wp_site_icon',                    99    );
add_action('wp_enqueue_scripts','ere_dequeue_assets_print_property',9999);
function ere_dequeue_assets_print_property() {
    foreach (wp_styles()->registered as $k => $v) {
        if (!in_array($k,array('bootstrap','font-awesome','star-rating',ERE_PLUGIN_PREFIX . 'main',ERE_PLUGIN_PREFIX . 'main-rtl',ERE_PLUGIN_PREFIX . 'property-print',ERE_PLUGIN_PREFIX . 'property-print-rtl'))) {
            unset(wp_styles()->registered[$k]);
        }
    }
}

?>
<html <?php language_attributes(); ?>>
    <head>
        <?php wp_head(); ?>
        <script type="text/javascript">
            (function( $ ) {
                'use strict';
                $(document).ready(function () {
                    $(window).on('load',function (){
                        print();
                    });
                });
            })( jQuery );
        </script>
    </head>
    <body <?php body_class(); ?>>
    <?php
    setup_postdata( $GLOBALS['post'] =& $post_object );
    ?>
    <div class="ere__property-print-wrap" id="property-print-wrap">

        <?php
        /**
         * ere_before_print_property_summary hook.
         *
         * @hooked ere_template_print_property_logo - 5
         * @hooked ere_template_print_property_header - 10
         * @hooked ere_template_single_property_info - 15
         * @hooked ere_template_print_property_image - 20
         */
        do_action('ere_before_print_property_summary');
        ?>
        <div class="ere__print-property-summary">
            <?php
            /**
             * ere_print_property_summary hook
             *
             * @hooked ere_template_single_property_description - 5
             * @hooked ere_template_single_property_address - 10
             * @hooked ere_template_single_property_overview - 15
             * @hooked ere_template_single_property_feature - 20
             * @hooked ere_template_print_property_floor - 25
             * @hooked ere_template_print_property_contact_agent - 30
             */
            do_action('ere_print_property_summary');
            ?>
        </div>
    </div>
    <?php
        wp_reset_postdata();
    ?>
    </body>
</html>
