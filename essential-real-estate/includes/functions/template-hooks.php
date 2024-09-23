<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @see ere_template_single_property_header
 * @see ere_template_single_property_gallery
 * @see ere_template_single_property_description
 * @see ere_template_single_property_address
 * @see ere_template_single_property_floor
 * @see ere_template_single_property_features
 * @see ere_template_single_property_map
 * @see ere_template_single_property_nearby_places
 * @see ere_template_single_property_walk_score
 * @see ere_template_single_property_contact_agent
 * @see ere_template_single_property_footer
 * @see ere_template_single_property_reviews
 *
 */
add_action('ere_single_property_summary','ere_template_single_property_header',5);
add_action( 'ere_single_property_summary', 'ere_template_single_property_gallery', 10 );
add_action( 'ere_single_property_summary', 'ere_template_single_property_description', 15 );
add_action( 'ere_single_property_summary', 'ere_template_single_property_address', 20 );
add_action( 'ere_single_property_summary', 'ere_template_single_property_features', 25 );
add_action('ere_single_property_summary','ere_template_single_property_floor',30);
add_action('ere_single_property_summary','ere_template_single_property_attachments',35);
add_action('ere_single_property_summary','ere_template_single_property_map',40);
add_action('ere_single_property_summary','ere_template_single_property_nearby_places',45);
add_action('ere_single_property_summary','ere_template_single_property_walk_score',50);
add_action('ere_single_property_summary','ere_template_single_property_contact_agent',55);
add_action('ere_single_property_summary','ere_template_single_property_footer',90);
add_action('ere_single_property_summary','ere_template_single_property_reviews',95);

/**
 * @see ere_template_loop_property_action_view_gallery
 * @see ere_template_loop_property_action_favorite
 * @see ere_template_loop_property_action_compare
 */
add_action('ere_loop_property_action','ere_template_loop_property_action_view_gallery',5);
add_action('ere_loop_property_action','ere_template_loop_property_action_favorite',10);
add_action('ere_loop_property_action','ere_template_loop_property_action_compare',15);

/**
 * @see ere_template_loop_property_action
 * @see ere_template_loop_property_featured_label
 * @see ere_template_loop_property_term_status
 * @see ere_template_loop_property_link
 */
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_action',5);
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_featured_label',10);
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_term_status',15);
add_action('ere_after_loop_property_thumbnail','ere_template_loop_property_link',20);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 */
add_action('ere_loop_property_heading','ere_template_loop_property_title',5);
add_action('ere_loop_property_heading','ere_template_loop_property_price',10);

/**
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_meta
 * @see ere_template_loop_property_excerpt
 * @see ere_template_loop_property_info
 */
add_action('ere_after_loop_property_heading','ere_template_loop_property_location',5);
add_action('ere_after_loop_property_heading','ere_template_loop_property_meta',10);
add_action('ere_after_loop_property_heading','ere_template_loop_property_excerpt',15);
add_action('ere_after_loop_property_heading','ere_template_loop_property_info',20);

/**
 * @see ere_template_loop_property_type
 * @see ere_template_loop_property_agent
 * @see ere_template_loop_property_date
 */
add_action('ere_loop_property_meta','ere_template_loop_property_type',5);
add_action('ere_loop_property_meta','ere_template_loop_property_agent',10);
add_action('ere_loop_property_meta','ere_template_loop_property_date',15);

/**
 * @see ere_template_loop_property_size
 * @see ere_template_loop_property_bedrooms
 * @see ere_template_loop_property_bathrooms
 */
add_action('ere_loop_property_info','ere_template_loop_property_size',5);
add_action('ere_loop_property_info','ere_template_loop_property_bedrooms',10);
add_action('ere_loop_property_info','ere_template_loop_property_bathrooms',15);

/**
 * @see ere_template_archive_property_heading
 * @see ere_template_archive_property_action
 */
add_action('ere_before_archive_property','ere_template_archive_property_heading',10,4);
add_action('ere_before_archive_property','ere_template_archive_property_action',15);

/**
 * @see ere_template_archive_property_action_status
 * @see ere_template_archive_property_action_orderby
 * @see ere_template_archive_property_action_switch_layout
 */
add_action('ere_archive_property_actions','ere_template_archive_property_action_status',5);
add_action('ere_archive_property_actions','ere_template_archive_property_action_orderby',10);
add_action('ere_archive_property_actions','ere_template_archive_property_action_switch_layout',15);

/**
 * @see ere_template_property_advanced_search_form
 */
add_action('ere_before_advanced_search','ere_template_property_advanced_search_form', 10,2);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_location
 */
add_action('ere_sc_property_gallery_loop_property_content','ere_template_loop_property_title',5);
add_action('ere_sc_property_gallery_loop_property_content','ere_template_loop_property_price',10);
add_action('ere_sc_property_gallery_loop_property_content','ere_template_loop_property_location',15);

/**
 * @@see ere_template_loop_property_link
 */
add_action('ere_sc_property_gallery_after_loop_property_content','ere_template_loop_property_link',5);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_term_status
 * @see ere_template_loop_property_location
 */
add_action('ere_sc_property_slider_layout_navigation_middle_loop_property_heading','ere_template_loop_property_price',10);
add_action('ere_sc_property_slider_layout_navigation_middle_loop_property_heading','ere_template_loop_property_term_status',15);
add_action('ere_sc_property_slider_layout_navigation_middle_loop_property_heading','ere_template_loop_property_location',20);

/**
 * @see ere_template_loop_property_title
 */
add_action('ere_before_sc_property_slider_layout_navigation_middle_loop_property_heading','ere_template_loop_property_title', 5);

/**
 * @see ere_template_loop_property_info_layout_2
 */
add_action('ere_after_sc_property_slider_layout_navigation_middle_loop_property_content','ere_template_loop_property_info_layout_2',5);

/**
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 */
add_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading','ere_template_loop_property_location',5);
add_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading','ere_template_loop_property_title',10);
add_action('ere_sc_property_gallery_layout_pagination_image_loop_property_heading','ere_template_loop_property_price',15);

/**
 * @see ere_template_loop_property_info_layout_2
 */
add_action('ere_after_sc_property_gallery_layout_pagination_image_loop_property_content','ere_template_loop_property_info_layout_2',5);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_excerpt
 * @see ere_template_loop_property_link_detail
 */
add_action('ere_sc_property_featured_layout_property_list_two_columns_loop_property_content','ere_template_loop_property_title',5);
add_action('ere_sc_property_featured_layout_property_list_two_columns_loop_property_content','ere_template_loop_property_price',10);
add_action('ere_sc_property_featured_layout_property_list_two_columns_loop_property_content','ere_template_loop_property_location',15);
add_action('ere_sc_property_featured_layout_property_list_two_columns_loop_property_content','ere_template_loop_property_excerpt',20);
add_action('ere_sc_property_featured_layout_property_list_two_columns_loop_property_content','ere_template_loop_property_link_detail',25);


/**
 * @see ere_template_loop_property_title
 */
add_action('ere_before_sc_property_featured_layout_property_single_carousel_loop_property_heading','ere_template_loop_property_title',5);

/**
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_status
 */
add_action('ere_sc_property_featured_layout_property_single_carousel_loop_property_heading','ere_template_loop_property_price',5);
add_action('ere_sc_property_featured_layout_property_single_carousel_loop_property_heading','ere_template_loop_property_status',10);

/**
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_excerpt
 * @see ere_template_single_property_info
 */
add_action('ere_after_sc_property_featured_layout_property_single_carousel_loop_property_heading','ere_template_loop_property_location', 5);
add_action('ere_after_sc_property_featured_layout_property_single_carousel_loop_property_heading','ere_template_loop_property_excerpt', 10);
add_action('ere_after_sc_property_featured_layout_property_single_carousel_loop_property_heading','ere_template_single_property_info', 15);

/**
 * @see ere_template_loop_property_identity
 * @see ere_template_loop_property_size
 * @see ere_template_loop_property_bedrooms
 * @see ere_template_loop_property_bathrooms
 */
add_action('ere_single_property_info','ere_template_loop_property_identity',5);
add_action('ere_single_property_info','ere_template_loop_property_size',10);
add_action('ere_single_property_info','ere_template_loop_property_bedrooms',15);
add_action('ere_single_property_info','ere_template_loop_property_bathrooms',20);




/**
 * @see ere_template_loop_property_title
 */
add_action('ere_before_sc_property_featured_layout_property_sync_carousel_loop_property_heading','ere_template_loop_property_title',5);

/**
 * @see ere_template_loop_property_price
 * @see ere_template_loop_property_status
 */
add_action('ere_sc_property_featured_layout_property_sync_carousel_loop_property_heading','ere_template_loop_property_price',5);
add_action('ere_sc_property_featured_layout_property_sync_carousel_loop_property_heading','ere_template_loop_property_status',10);

/**
 * @see ere_template_loop_property_location
 * @see ere_template_loop_property_excerpt
 * @see ere_template_single_property_info
 */
add_action('ere_after_sc_property_featured_layout_property_sync_carousel_loop_property_heading','ere_template_loop_property_location', 5);
add_action('ere_after_sc_property_featured_layout_property_sync_carousel_loop_property_heading','ere_template_loop_property_excerpt', 10);
add_action('ere_after_sc_property_featured_layout_property_sync_carousel_loop_property_heading','ere_template_single_property_info', 15);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 */
add_action('ere_sc_property_featured_layout_property_cities_filter_loop_property_heading','ere_template_loop_property_title',5);
add_action('ere_sc_property_featured_layout_property_cities_filter_loop_property_heading','ere_template_loop_property_price',10);

/**
 * @see ere_template_single_property_info
 */
add_action('ere_after_sc_property_featured_layout_property_cities_filter_loop_property_heading','ere_template_single_property_info',5);



/**
 * @see ere_template_single_property_title
 * @see ere_template_single_property_header_price_location
 */
add_action('ere_single_property_header_info','ere_template_single_property_title',5);
add_action('ere_single_property_header_info','ere_template_single_property_header_price_location',10);

/**
 * @see ere_template_single_property_header_meta_action
 */
add_action('ere_after_single_property_header_info','ere_template_single_property_header_meta_action',5);


/**
 * @see ere_template_single_property_price
 * @see ere_template_single_property_status
 * @see ere_template_single_property_location
 */
add_action('ere_single_property_header_price_location','ere_template_single_property_price',5);
add_action('ere_single_property_header_price_location','ere_template_single_property_status',10);
add_action('ere_single_property_header_price_location','ere_template_single_property_location',15);

/**
 * @see ere_template_single_property_info
 * @see ere_template_single_property_action
 */
add_action('ere_single_property_header_meta_action','ere_template_single_property_info',5);
add_action('ere_single_property_header_meta_action','ere_template_single_property_action',10);

/**
 * @see ere_template_single_property_action_social_share
 * @see ere_template_loop_property_action_favorite
 * @see ere_template_loop_property_action_compare
 * @see ere_template_single_property_action_print
 */
add_action('ere_single_property_action','ere_template_single_property_action_social_share',5);
add_action('ere_single_property_action','ere_template_loop_property_action_favorite',10);
add_action('ere_single_property_action','ere_template_loop_property_action_compare',15);
add_action('ere_single_property_action','ere_template_single_property_action_print',20);

/**
 * @see ere_template_print_property_logo
 * @see ere_template_print_property_header
 * @see ere_template_single_property_info
 * @see ere_template_print_property_image
 */
add_action('ere_before_print_property_summary','ere_template_print_property_logo',5);
add_action('ere_before_print_property_summary','ere_template_print_property_header',10);
add_action('ere_before_print_property_summary','ere_template_single_property_info',15);
add_action('ere_before_print_property_summary','ere_template_print_property_image',20);

/**
 * @see ere_template_single_property_title
 * @see ere_template_single_property_location
 * @see ere_template_single_property_price
 */
add_action('ere_print_property_header_left','ere_template_single_property_title',5);
add_action('ere_print_property_header_left','ere_template_single_property_location',10);
add_action('ere_print_property_header_left','ere_template_single_property_price',15);

/**
 * @see ere_template_print_property_qr_image
 */
add_action('ere_print_property_header_right','ere_template_print_property_qr_image',5);


/**
 * @see ere_template_single_property_description
 * @see ere_template_single_property_address
 * @see ere_template_single_property_overview
 * @see ere_template_single_property_feature
 * @see ere_template_print_property_floor
 * @see ere_template_print_property_contact_agent
 */
add_action('ere_print_property_summary','ere_template_single_property_description',5);
add_action('ere_print_property_summary','ere_template_single_property_address',10);
add_action('ere_print_property_summary','ere_template_single_property_overview',15);
add_action('ere_print_property_summary','ere_template_single_property_feature',20);
add_action('ere_print_property_summary','ere_template_print_property_floor',25);
add_action('ere_print_property_summary','ere_template_print_property_contact_agent',30);


/**
 * @see ere_template_my_property_search
 * @see ere_template_my_property_filter
 */
add_action('ere_my_property_toolbar','ere_template_my_property_search',5);
add_action('ere_my_property_toolbar','ere_template_my_property_filter',10);

/**
 * @see ere_template_loop_my_property_title
 * @see ere_template_loop_my_property_meta
 * @see ere_template_loop_my_property_action
 */
add_action('ere_loop_my_property_content','ere_template_loop_my_property_title',5);
add_action('ere_loop_my_property_content','ere_template_loop_my_property_meta',10);
add_action('ere_loop_my_property_content','ere_template_loop_my_property_action',15);

/**
 * @see ere_template_loop_my_property_meta_location
 * @see ere_template_loop_my_property_meta_view
 * @see ere_template_loop_my_property_meta_date
 * @see ere_template_loop_my_property_meta_expire_date
 */
add_action('ere_loop_my_property_meta','ere_template_loop_my_property_meta_location',5);
add_action('ere_loop_my_property_meta','ere_template_loop_my_property_meta_view',10);
add_action('ere_loop_my_property_meta','ere_template_loop_my_property_meta_date',15);
add_action('ere_loop_my_property_meta','ere_template_loop_my_property_meta_expire_date',20);

/**
 * @see ere_template_loop_my_property_featured
 * @see ere_template_loop_my_property_status
 */
add_action('ere_after_loop_my_property_thumbnail','ere_template_loop_my_property_featured',5);
add_action('ere_after_loop_my_property_thumbnail','ere_template_loop_my_property_status',10);


/**
 * @see ere_template_loop_property_featured_label
 * @see ere_template_loop_property_term_status
 * @see ere_template_loop_property_link
 */
add_action('ere_after_loop_compare_property_thumbnail','ere_template_loop_property_featured_label',5);
add_action('ere_after_loop_compare_property_thumbnail','ere_template_loop_property_term_status',10);
add_action('ere_after_loop_compare_property_thumbnail','ere_template_loop_property_link',15);

/**
 * @see ere_template_loop_property_title
 * @see ere_template_loop_property_price
 */
add_action('ere_loop_compare_property_heading','ere_template_loop_property_title',5);
add_action('ere_loop_compare_property_heading','ere_template_loop_property_price',10);

/**
 * @see ere_template_loop_property_location
 */
add_action('ere_after_loop_compare_property_heading','ere_template_loop_property_location',5);








