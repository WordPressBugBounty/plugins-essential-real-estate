<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!function_exists('ere_dashboard_get_menu')) {
    function ere_dashboard_get_menu() {
        $menu = array();

        $my_profile_url = ere_get_permalink( 'my_profile' );
        if ($my_profile_url) {
            $menu['my_profile'] = array(
                'title' => esc_html__('My Profile', 'essential-real-estate'),
                'link' => $my_profile_url,
                'icon' => 'fa fa-user',
                'priority' => 10
            );
        }

        $allow_submit        = ere_allow_submit();
        if ($allow_submit) {
            $my_properties_url = ere_get_permalink( 'my_properties' );
            if ($my_properties_url) {

                $total_properties    = ERE_Property::getInstance()->get_total_my_properties( array( 'publish', 'pending', 'expired', 'hidden' ) );
                $menu['my_properties'] = array(
                    'title' => esc_html__('My Properties', 'essential-real-estate'),
                    'link' => $my_properties_url,
                    'icon' => 'fa fa-list-alt',
                    'count' => $total_properties,
                    'priority' => 20
                );
            }

            $paid_submission_type = ere_get_option( 'paid_submission_type', 'no' );
            if ($paid_submission_type != 'no') {
                $my_invoices_url = ere_get_permalink( 'my_invoices' );
                if ($my_invoices_url) {
                    $total_invoices      = ERE_Invoice::getInstance()->get_total_my_invoice();
                    $menu['my_invoices'] = array(
                        'title' => esc_html__('My Invoices', 'essential-real-estate'),
                        'link' => $my_invoices_url,
                        'icon' => 'fa fa-file-text-o',
                        'count' => $total_invoices,
                        'priority' => 30
                    );
                }
            }
        }

        $enable_favorite = ere_get_option( 'enable_favorite_property', 1 );
        if ($enable_favorite == 1) {
            $my_favorites_url = ere_get_permalink( 'my_favorites' );
            if ($my_favorites_url) {
                $total_favorite      = ERE_Property::getInstance()->get_total_favorite();
                $menu['my_favorites'] = array(
                    'title' => esc_html__('My Favorites', 'essential-real-estate'),
                    'link' => $my_favorites_url,
                    'icon' => 'fa fa-heart',
                    'count' => $total_favorite,
                    'priority' => 40
                );
            }
        }

        $enable_saved_search = ere_get_option( 'enable_saved_search', 1 );
        if ($enable_saved_search == 1) {
            $my_save_search_url =  ere_get_permalink( 'my_save_search' );
            if ($my_save_search_url) {
                $total_save_search   = ERE_Save_Search::getInstance()->get_total_save_search();
                $menu['my_save_search'] = array(
                    'title' => esc_html__('My Saved Searches', 'essential-real-estate'),
                    'link' => $my_save_search_url,
                    'icon' => 'fa fa-search',
                    'count' => $total_save_search,
                    'priority' => 50
                );
            }
        }

        if ($allow_submit) {
            $submit_property_url =  ere_get_permalink( 'submit_property' );
            if ($submit_property_url) {
                $menu['submit_property'] = array(
                    'title' => esc_html__('Submit New Property', 'essential-real-estate'),
                    'link' => $submit_property_url,
                    'icon' => 'fa fa-file-o',
                    'priority' => 60
                );
            }
        }


        $menu = apply_filters( 'ere_dashboard_menu', $menu);
        uasort( $menu, 'ere_sort_by_order_callback' );
        return $menu;
    }
}

if (!function_exists('ere_dashboard_get_menu_title')) {
    function ere_dashboard_get_menu_title($menu) {
        $menu_title = '';
        switch ( $menu ) {
            case "my_profile":
                $menu_title =  esc_html__( 'My Profile', 'essential-real-estate' );
                break;
            case "my_properties":
                $menu_title = esc_html__( 'My Properties', 'essential-real-estate' );
                break;
            case "my_invoices":
                $menu_title = esc_html__( 'My Invoices', 'essential-real-estate' );
                break;
            case "my_favorites":
                $menu_title = esc_html__( 'My Favorites', 'essential-real-estate' );
                break;
            case "my_save_search":
                $menu_title = esc_html__( 'My Saved Searches', 'essential-real-estate' );
                break;
        }

        return apply_filters('ere_dashboard_menu_title',$menu_title, $menu);
    }
}