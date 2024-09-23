<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
function ere_update_add_customer_role() {
	if (get_option('ere_update_add_customer_role', '') !== 'updated') {
		$args = array(
			'role' => 'subscriber'
		);
		$users = get_users( $args );
		foreach ($users as $u) {
			/**
			 * @var $u WP_User
			 */
			$u->set_role('ere_customer');
		}
		update_option('ere_update_add_customer_role', 'updated');
	}
}
add_action('init', 'ere_update_add_customer_role');