<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'ERE_Admin_Invoice' ) ) {
	/**
	 * Class ERE_Admin_Invoice
	 */
	class ERE_Admin_Invoice {
		/**
		 * Register custom columns
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		public function register_custom_column_titles( $columns ) {
			$columns['cb']                     = "<input type=\"checkbox\" />";
			$columns['title']                  = esc_html__( 'Invoice', 'essential-real-estate' );
			$columns['invoice_status']         = esc_html__( 'Status', 'essential-real-estate' );
			$columns['invoice_payment_method'] = esc_html__( 'Payment Method', 'essential-real-estate' );
			$columns['invoice_payment_type']   = esc_html__( 'Payment Type', 'essential-real-estate' );
			$columns['invoice_price']          = esc_html__( 'Money', 'essential-real-estate' );
			$columns['invoice_user_id']        = esc_html__( 'Buyer', 'essential-real-estate' );
			$columns['date']                   = esc_html__( 'Date', 'essential-real-estate' );
			$new_columns                       = array();
			$custom_order                      = array(
				'cb',
				'title',
				'invoice_status',
				'invoice_payment_method',
				'invoice_payment_type',
				'invoice_price',
				'invoice_user_id',
				'date'
			);
			foreach ( $custom_order as $colname ) {
				$new_columns[ $colname ] = $columns[ $colname ];
			}

			return $new_columns;
		}

		/**
		 * sortable_columns
		 *
		 * @param $columns
		 *
		 * @return mixed
		 */
		public function sortable_columns( $columns ) {
			$columns['title']                  = 'title';
			$columns['invoice_status']         = 'invoice_status';
			$columns['invoice_payment_method'] = 'invoice_payment_method';
			$columns['invoice_payment_type']   = 'invoice_payment_type';
			$columns['invoice_price']          = 'invoice_price';
			$columns['date']                   = 'date';

			return $columns;
		}

		/**
		 * @param $vars
		 *
		 * @return array
		 */
		public function column_orderby( $vars ) {
			if ( is_admin() ) {
				$_orderby = isset( $vars['orderby'] ) ? ere_clean( wp_unslash( $vars['orderby'] ) ) : '';
				if ( 'invoice_payment_method' == $_orderby ) {
					$vars = array_merge( $vars, array(
						'meta_key' => ERE_METABOX_PREFIX . 'invoice_payment_method',
						'orderby'  => 'meta_value',
					) );
				}
				if ( 'invoice_payment_type' == $_orderby ) {
					$vars = array_merge( $vars, array(
						'meta_key' => ERE_METABOX_PREFIX . 'invoice_payment_type',
						'orderby'  => 'meta_value',
					) );
				}
				if ( 'invoice_price' == $_orderby ) {
					$vars = array_merge( $vars, array(
						'meta_key' => ERE_METABOX_PREFIX . 'invoice_price',
						'orderby'  => 'meta_value_num',
					) );
				}
				if ( 'invoice_status' == $_orderby ) {
					$vars = array_merge( $vars, array(
						'meta_key' => ERE_METABOX_PREFIX . 'invoice_payment_status',
						'orderby'  => 'meta_value_num',
					) );
				}
			}


			return $vars;
		}

		/**
		 * Display custom column for invoice
		 *
		 * @param $column
		 */
		public function display_custom_column( $column ) {
			global $post;
			$invoice_meta = get_post_meta( $post->ID, ERE_METABOX_PREFIX . 'invoice_meta', true );
			switch ( $column ) {
				case 'invoice_payment_method':
					echo esc_html( ERE_Invoice::get_invoice_payment_method( $invoice_meta['invoice_payment_method'] ) );
					break;
				case 'invoice_payment_type':
					echo esc_html( ERE_Invoice::get_invoice_payment_type( $invoice_meta['invoice_payment_type'] ) );
					break;
				case 'invoice_price':
					echo esc_html( $invoice_meta['invoice_item_price'] );
					break;
				case 'invoice_user_id':
					$user_info = get_userdata( $invoice_meta['invoice_user_id'] );
					if ( $user_info ) {
						echo esc_html( $user_info->display_name );
					}
					break;
				case 'invoice_status':
					$invoice_status = get_post_meta( $post->ID, ERE_METABOX_PREFIX . 'invoice_payment_status', true );
					if ( $invoice_status == 0 ) {
						echo '<span class="ere-label-red">' . esc_html__( 'Not Paid', 'essential-real-estate' ) . '</span>';
					} else {
						echo '<span class="ere-label-blue">' . esc_html__( 'Paid', 'essential-real-estate' ) . '</span>';
					}
					break;
			}
		}

		/**
		 * Get invoices by property
		 *
		 * @param $property_id
		 */
		public function get_invoices_by_property( $property_id ) {
			$args     = array(
				'post_type'  => 'invoice',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => ERE_METABOX_PREFIX . 'invoice_item_id',
						'value'   => $property_id,
						'compare' => '=',
						'type'    => 'NUMERIC'
					),
					array(
						'key'     => ERE_METABOX_PREFIX . 'invoice_payment_type',
						'value'   => 'Package',
						'compare' => '!=',
						'type'    => 'CHAR'
					)
				)
			);
			$invoices = get_posts( $args );
			if ( ! $invoices ) {
				echo esc_html__( 'No invoice', 'essential-real-estate' );
			} else {
				foreach ( $invoices as $invoice ):
					if ( $invoice->ID > 0 ):
						?>
						<a title="<?php esc_attr_e( 'Click to view invoice', 'essential-real-estate' ) ?>"
						   href="<?php echo esc_url( get_edit_post_link( $invoice->ID ) ) ?>"><?php echo esc_html( $invoice->ID ); ?></a>
					<?php
					endif;
				endforeach;
			}
		}

		/**
		 * Modify invoice slug
		 *
		 * @param $existing_slug
		 *
		 * @return string
		 */
		public function modify_invoice_slug( $existing_slug ) {
			$invoice_url_slug = ere_get_option( 'invoice_url_slug' );
			if ( $invoice_url_slug ) {
				return $invoice_url_slug;
			}

			return $existing_slug;
		}

		/**
		 * filter_restrict_manage_invoice
		 */
		public function filter_restrict_manage_invoice() {
			global $typenow;
			$post_type = 'invoice';

			if ( $typenow == $post_type ) {
				//Invoice Status
                $values = array(
                    '' => esc_html__('All Status', 'essential-real-estate'),
                    'not_paid' => esc_html__('Not Paid', 'essential-real-estate'),
                    'paid' => esc_html__('Paid', 'essential-real-estate'),
                );
                $current_v = isset( $_GET['invoice_status'] ) ? ere_clean( wp_unslash( $_GET['invoice_status'] ) ) : '';
				?>
				<select name="invoice_status">
                    <?php foreach ($values as $k => $v): ?>
                        <option <?php selected($k,$current_v) ?> value="<?php echo esc_attr($k)?>"><?php echo esc_html($v)?></option>
                    <?php endforeach; ?>
				</select>
				<?php
				//Payment method
                $values = array(
                    '' => esc_html__('All Payment Methods', 'essential-real-estate'),
                    'Paypal' => esc_html__('Paypal', 'essential-real-estate'),
                    'Stripe' => esc_html__('Stripe', 'essential-real-estate'),
                    'Wire_Transfer' => esc_html__('Wire Transfer', 'essential-real-estate'),
                    'Free_Package' => esc_html__('Free Package', 'essential-real-estate'),
                );
                $current_v = isset( $_GET['invoice_payment_method'] ) ? ere_clean( wp_unslash( $_GET['invoice_payment_method'] ) ) : '';
				?>
				<select name="invoice_payment_method">
                    <?php foreach ($values as $k => $v): ?>
                        <option <?php selected($k,$current_v) ?> value="<?php echo esc_attr($k)?>"><?php echo esc_html($v)?></option>
                    <?php endforeach; ?>
				</select>
				<?php
				//Payment type
                $values = array(
                    '' => esc_html__('All Payment Types', 'essential-real-estate'),
                    'Package' => esc_html__('Package', 'essential-real-estate'),
                    'Listing' => esc_html__('Listing', 'essential-real-estate'),
                    'Upgrade_To_Featured' => esc_html__('Upgrade to Featured', 'essential-real-estate'),
                    'Listing_With_Featured' => esc_html__('Listing with Featured', 'essential-real-estate'),
                );
                $current_v = isset( $_GET['invoice_payment_type'] ) ? ere_clean( wp_unslash( $_GET['invoice_payment_type'] ) ) : '';
				?>
				<select name="invoice_payment_type">
                    <?php foreach ($values as $k => $v): ?>
                        <option <?php selected($k,$current_v) ?> value="<?php echo esc_attr($k)?>"><?php echo esc_html($v)?></option>
                    <?php endforeach; ?>
				</select>
                <?php $invoice_user = isset( $_GET['invoice_user'] ) ? ere_clean( wp_unslash( $_GET['invoice_user'] ) ) : '';?>
				<input type="text" placeholder="<?php echo esc_attr__( 'Buyer', 'essential-real-estate' ); ?>"
				       name="invoice_user" value="<?php echo esc_attr( $invoice_user ); ?>">
			<?php }
		}

		/**
		 * invoice_filter
		 *
		 * @param $query
		 */
		public function invoice_filter( $query ) {
			global $pagenow;
			$post_type  = 'invoice';
			$q_vars     = &$query->query_vars;
			$filter_arr = array();
			if ( $pagenow == 'edit.php' && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type ) {
				$invoice_user = isset( $_GET['invoice_user'] ) ? ere_clean( wp_unslash( $_GET['invoice_user'] ) ) : '';
				if ( $invoice_user !== '' ) {
					$user    = get_user_by( 'login', $invoice_user );
					$user_id = - 1;
					if ( $user ) {
						$user_id = $user->ID;
					}
					$filter_arr[] = array(
						'key'     => ERE_METABOX_PREFIX . 'invoice_user_id',
						'value'   => $user_id,
						'compare' => 'IN',
					);
				}

				$_invoice_status = isset( $_GET['invoice_status'] ) ? ere_clean( wp_unslash( $_GET['invoice_status'] ) ) : '';

				if ( $_invoice_status !== '' ) {
					$invoice_status = 0;
					if ( $_invoice_status == 'paid' ) {
						$invoice_status = 1;
					}
					$filter_arr[] = array(
						'key'     => ERE_METABOX_PREFIX . 'invoice_payment_status',
						'value'   => $invoice_status,
						'compare' => '=',
					);
				}

				$invoice_payment_method = isset( $_GET['invoice_payment_method'] ) ? ere_clean( wp_unslash( $_GET['invoice_payment_method'] ) ) : '';

				if ( $invoice_payment_method !== '' ) {
					$filter_arr[] = array(
						'key'     => ERE_METABOX_PREFIX . 'invoice_payment_method',
						'value'   => $invoice_payment_method,
						'compare' => '=',
					);
				}

				$invoice_payment_type = isset( $_GET['invoice_payment_type'] ) ? ere_clean( wp_unslash( $_GET['invoice_payment_type'] ) ) : '';

				if ( $invoice_payment_type !== '' ) {
					$filter_arr[] = array(
						'key'     => ERE_METABOX_PREFIX . 'invoice_payment_type',
						'value'   => $invoice_payment_type,
						'compare' => '=',
					);
				}
				if ( ! empty( $filter_arr ) ) {
					$q_vars['meta_query'] = $filter_arr;
				}
			}
		}

		/**
		 * @param $actions
		 * @param $post
		 *
		 * @return mixed
		 */
		public function modify_list_row_actions( $actions, $post ) {
			// Check for your post type.
			if ( $post->post_type == 'invoice' ) {
				unset( $actions['view'] );
			}

			return $actions;
		}
	}
}