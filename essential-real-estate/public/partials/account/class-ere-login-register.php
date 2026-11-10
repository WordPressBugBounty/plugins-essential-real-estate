<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if (!class_exists('ERE_Login_Register')) {
    /**
     * Class ERE_Login_Register
     */
    class ERE_Login_Register
    {
	    /*
		 * loader instances
		 */
	    private static $_instance;

	    public static function getInstance()
	    {
		    if (self::$_instance == null) {
			    self::$_instance = new self();
		    }

		    return self::$_instance;
	    }


	    /**
         * Login
         */
        public function login_ajax() {
            check_ajax_referer( 'ere_login_ajax_nonce', 'ere_security_login' );
            $user_login = isset($_POST['user_login']) ? ere_clean(wp_unslash($_POST['user_login'])) : '';
            $user_password = isset($_POST['user_password']) ? ere_clean(wp_unslash($_POST['user_password'])) : '';

            if( isset( $_POST['remember'] ) ) {
                $remember = ere_clean( wp_unslash($_POST['remember']));
            } else {
                $remember = '';
            }

            if( empty( $user_login ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('The username field is empty.', 'essential-real-estate') ) );
                wp_die();
            }

            if( empty( $user_password ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('The password field is empty.', 'essential-real-estate') ) );
                wp_die();
            }

            wp_clear_auth_cookie();

            $remember = ($remember == 'on') ? true : false;

            $credentials = array();
            $credentials['user_login'] = $user_login;
            $credentials['user_password'] = $user_password;
            $credentials['remember'] = $remember;


	        // On multisite, ensure user exists on current site, if not add them before allowing login.
	        if ( is_multisite() ) {
		        $user_data = get_user_by( is_email( $credentials['user_login'] ) ? 'email' : 'login', $credentials['user_login'] );

		        if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
			        add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
		        }
	        }



	        $user = wp_signon( $credentials, false );
            if ( is_wp_error( $user ) ) {
                echo wp_json_encode( array(
                    'success' => false,
                    'message' => $user->get_error_messages() )
                );

                wp_die();
            } else {
                wp_set_current_user($user->ID);
                do_action('set_current_user');
                global $current_user;
                $current_user = wp_get_current_user();
                echo wp_json_encode( array( 'success' => true, 'message' => esc_html__('Login successful, redirecting...', 'essential-real-estate') ) );

            }
            wp_die();
        }

        /**
         * Register account
         */
        public function register_ajax() {

            check_ajax_referer('ere_register_ajax_nonce', 'ere_register_security');
            $user_login          = isset($_POST['user_login']) ? trim(ere_clean(wp_unslash($_POST['user_login']))) : '';
            $user_pass='';
            $email             = isset($_POST['user_email']) ?  trim(sanitize_email(wp_unslash($_POST['user_email']))) : '';
            $term_condition    = isset($_POST['term_condition']) ? ere_clean(wp_unslash($_POST['term_condition'])) : '';
            $enable_password = ere_get_option('enable_password',0);

            $term_condition = ( $term_condition == 'on') ? true : false;

            if( !$term_condition ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('You need to agree with terms & conditions.', 'essential-real-estate') ) );
                wp_die();
            }
            $user_login = sanitize_user( $user_login );
            if( empty( $user_login ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('The username field is empty.', 'essential-real-estate') ) );
                wp_die();
            }
            if( strlen( $user_login ) < 3 ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('Minimum 3 characters required', 'essential-real-estate') ) );
                wp_die();
            }
            if ( ! validate_username( $user_login ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('Please enter a valid account username.', 'essential-real-estate') ) );
                wp_die();
            }
            // Free the username of an account that was never activated
            $this->delete_expired_unverified_user( username_exists( $user_login ) );
            if( username_exists( $user_login ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('This username is already registered.', 'essential-real-estate') ) );
                wp_die();
            }
            if( empty( $email ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('The email field is empty.', 'essential-real-estate') ) );
                wp_die();
            }
             if( !is_email( $email ) ) {
                 echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('Invalid email address.', 'essential-real-estate') ) );
                 wp_die();
             }
            // Free the email of an account that was never activated (e.g. registered by someone else)
            $this->delete_expired_unverified_user( email_exists( $email ) );
            if( email_exists( $email ) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('This email address is already registered.', 'essential-real-estate') ) );
                wp_die();
            }
            //recaptcha
            if (ere_enable_captcha('register')) {do_action('ere_verify_recaptcha');}
            if( $enable_password==1){
                $user_pass         = isset($_POST['user_password']) ? ere_clean(wp_unslash($_POST['user_password'])) : '';
                $user_pass_retype  = isset($_POST['user_password_retype']) ? ere_clean(wp_unslash($_POST['user_password_retype'])) : '';

                if ($user_pass == '' || $user_pass_retype == '' ) {
                    echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('The password field is empty!', 'essential-real-estate') ) );
                    wp_die();
                }

                if ($user_pass !== $user_pass_retype ){
                    echo wp_json_encode( array( 'success' => false, 'message' => esc_html__('Passwords don\'t match', 'essential-real-estate') ) );
                    wp_die();
                }
            }

            if($enable_password) {
                $user_password = $user_pass;
            } else {
                $user_password = wp_generate_password( 12, false,false);
            }
            $user_id = wp_create_user( $user_login, $user_password, $email );

            if ( is_wp_error($user_id) ) {
                echo wp_json_encode( array( 'success' => false, 'message' => $user_id ) );
                wp_die();
            } else {
                // A user-chosen password does not prove ownership of the email address: require activation by email
                $require_verification = $enable_password && apply_filters( 'ere_register_require_email_verification', true, $user_id );
                if ( $require_verification ) {
                    $this->send_verification_email( $user_id );
                }
                if( $enable_password && $require_verification ) {
                    echo wp_json_encode( array( 'success' => true, 'message' => esc_html__('Your account was created. Please check your email and click the activation link before logging in.', 'essential-real-estate') ) );
                } elseif( $enable_password) {
                    echo wp_json_encode( array( 'success' => true, 'message' => esc_html__('Your account was created, you can login now!', 'essential-real-estate') ) );
                } else {
                    echo wp_json_encode( array( 'success' => true, 'message' => esc_html__('A generated password was sent to your email, please check email!', 'essential-real-estate') ) );
                }
                $this-> wp_new_user_notification( $user_id, $user_password );

	            $wp_user_object = new WP_User($user_id);
	            $wp_user_object->set_role('ere_customer');

				do_action('ere_register_user_success', $user_id);
            }
            wp_die();
        }

        /**
         * Send the account activation link to the account email address
         *
         * @param $user_id
         * @return bool
         */
        public function send_verification_email( $user_id ) {
            $user = get_userdata( $user_id );
            if ( ! $user ) {
                return false;
            }
            $hash = wp_generate_password( 32, false, false );
            update_user_meta( $user_id, ERE_METABOX_PREFIX . 'email_verify', array(
                'hash' => $hash,
                'sent' => time()
            ) );
            $verify_url = add_query_arg( array( 'ere_verify_email' => $hash, 'uid' => $user_id ), home_url( '/' ) );
            $site_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
            /* translators: %s: site name. */
            $subject = sprintf( __( '[%s] Activate your account', 'essential-real-estate' ), $site_name );
            /* translators: %1$s: site name, %2$s: username, %3$s: activation link. */
            $message = sprintf( __( "An account was created on %1\$s with this email address (username: %2\$s).\n\nTo activate the account, please click the following link:\n%3\$s\n\nThis link expires in 48 hours. If you did not create this account, you can safely ignore this email and it will be removed.", 'essential-real-estate' ), $site_name, $user->user_login, $verify_url );
            return wp_mail( $user->user_email, $subject, $message );
        }

        /**
         * Block login of accounts whose email address has not been verified yet
         *
         * @param WP_User|WP_Error $user
         * @param string $password
         * @return WP_User|WP_Error
         */
        public function check_email_verified( $user, $password ) {
            if ( ! is_a( $user, 'WP_User' ) ) {
                return $user;
            }
            $verify = get_user_meta( $user->ID, ERE_METABOX_PREFIX . 'email_verify', true );
            if ( empty( $verify ) ) {
                return $user;
            }
            // Wrong password: let WordPress report it as usual
            if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
                return $user;
            }
            // Re-send the activation link, at most once every 5 minutes
            if ( ! is_array( $verify ) || empty( $verify['sent'] ) || ( time() - (int) $verify['sent'] > 5 * MINUTE_IN_SECONDS ) ) {
                $this->send_verification_email( $user->ID );
            }
            return new WP_Error( 'ere_email_unverified', esc_html__( 'Your account has not been activated yet. Please click the activation link we sent to your email address.', 'essential-real-estate' ) );
        }

        /**
         * Handle the account activation link
         */
        public function verify_email_link() {
            if ( empty( $_GET['ere_verify_email'] ) || empty( $_GET['uid'] ) ) {
                return;
            }
            $user_id = absint( wp_unslash( $_GET['uid'] ) );
            $hash = sanitize_text_field( wp_unslash( $_GET['ere_verify_email'] ) );
            $verify = get_user_meta( $user_id, ERE_METABOX_PREFIX . 'email_verify', true );
            $message = esc_html__( 'This activation link is invalid or has expired. Please log in to receive a new activation link.', 'essential-real-estate' );
            if ( is_array( $verify ) && ! empty( $verify['hash'] ) && hash_equals( $verify['hash'], $hash ) && ( time() - (int) $verify['sent'] <= 2 * DAY_IN_SECONDS ) ) {
                delete_user_meta( $user_id, ERE_METABOX_PREFIX . 'email_verify' );
                do_action( 'ere_user_email_verified', $user_id );
                $message = esc_html__( 'Your account has been activated. You can log in now.', 'essential-real-estate' );
            } elseif ( empty( $verify ) && get_userdata( $user_id ) ) {
                $message = esc_html__( 'Your account is already activated.', 'essential-real-estate' );
            }
            wp_die( $message, esc_html__( 'Account activation', 'essential-real-estate' ), array(
                'response'  => 200,
                'link_url'  => home_url( '/' ),
                'link_text' => esc_html__( 'Back to home', 'essential-real-estate' ),
            ) );
        }

        /**
         * Delete an account that was registered more than 48 hours ago and never activated,
         * so its username / email address can be registered again by their real owner.
         *
         * @param int|false $user_id
         */
        private function delete_expired_unverified_user( $user_id ) {
            if ( empty( $user_id ) || ! get_user_meta( $user_id, ERE_METABOX_PREFIX . 'email_verify', true ) ) {
                return;
            }
            $user = get_userdata( $user_id );
            if ( ! $user || ( time() - strtotime( $user->user_registered . ' UTC' ) <= 2 * DAY_IN_SECONDS ) || count_user_posts( $user_id ) > 0 || count_user_posts( $user_id, 'property' ) > 0 ) {
                return;
            }
            require_once ABSPATH . 'wp-admin/includes/user.php';
            wp_delete_user( $user_id );
        }

        /**
         * Users list: allow administrators to activate an account manually
         *
         * @param array $actions
         * @param WP_User $user
         * @return array
         */
        public function user_row_actions( $actions, $user ) {
            if ( current_user_can( 'edit_user', $user->ID ) && get_user_meta( $user->ID, ERE_METABOX_PREFIX . 'email_verify', true ) ) {
                $url = wp_nonce_url( add_query_arg( array( 'action' => 'ere_activate_user', 'user_id' => $user->ID ), admin_url( 'admin-post.php' ) ), 'ere_activate_user_' . $user->ID );
                $actions['ere_activate_user'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Activate (email not verified)', 'essential-real-estate' ) . '</a>';
            }
            return $actions;
        }

        /**
         * Manually activate an account from the Users list
         */
        public function admin_activate_user() {
            $user_id = isset( $_GET['user_id'] ) ? absint( wp_unslash( $_GET['user_id'] ) ) : 0;
            check_admin_referer( 'ere_activate_user_' . $user_id );
            if ( ! current_user_can( 'edit_user', $user_id ) ) {
                wp_die( esc_html__( 'You are not allowed to edit this user.', 'essential-real-estate' ) );
            }
            delete_user_meta( $user_id, ERE_METABOX_PREFIX . 'email_verify' );
            do_action( 'ere_user_email_verified', $user_id );
            $redirect = wp_get_referer();
            wp_safe_redirect( $redirect ? $redirect : admin_url( 'users.php' ) );
            exit;
        }

        /**
         * user notification
         * @param $user_id
         * @param string $randonpassword
         */
        public function wp_new_user_notification( $user_id, $randonpassword = '' ) {

            $user = new WP_User( $user_id );
            $user_login = stripslashes( $user->user_login );
            $user_email = stripslashes( $user->user_email );
            $args = array(
                'user_login_register' => $user_login,
                'user_email_register' => $user_email
            );
            $admin_email = get_bloginfo('admin_email');
            ere_send_email( $admin_email, 'admin_mail_register_user', $args );

            if ( empty( $randonpassword ) ) {
                return;
            }
            $args = array(
                'user_login_register'  =>  $user_login,
                'user_email_register'  =>  $user_email,
                'user_pass_register'   => $randonpassword
            );
            ere_send_email( $user_email, 'mail_register_user', $args );
        }

        /**
         * Reset password
         * @return bool
         */
        public function reset_password_ajax() {
            check_ajax_referer('ere_reset_password_ajax_nonce', 'ere_security_reset_password');
            $user_login = isset($_POST['user_login']) ? ere_clean(wp_unslash($_POST['user_login'])) : '';

            if ( empty( $user_login ) ) {
                echo wp_json_encode(array( 'success' => false, 'message' => esc_html__('Enter a username or email address.', 'essential-real-estate') ) );
                wp_die();
            }
            //recaptcha
            if (ere_enable_captcha('reset_password')) {do_action('ere_verify_recaptcha');}
            if ( strpos( $user_login, '@' ) ) {
                $user_data = get_user_by( 'email', trim( $user_login ) );
                if ( empty( $user_data ) ) {
                    echo wp_json_encode(array('success' => false, 'message' => esc_html__('There is no user registered with that email address.', 'essential-real-estate')));
                    wp_die();
                }
            } else {
                $login = trim( $user_login );
                $user_data = get_user_by('login', $login);

                if ( !$user_data ) {
                    echo wp_json_encode(array( 'success' => false, 'message' => esc_html__('Invalid username', 'essential-real-estate') ) );
                    wp_die();
                }
            }
            $user_login = $user_data->user_login;
            $user_email = $user_data->user_email;
            $key = get_password_reset_key( $user_data );

            if ( is_wp_error( $key ) ) {
                echo wp_json_encode(array( 'success' => false, 'message' => $key ) );
                wp_die();
            }

            $message = esc_html__('Someone has requested a password reset for the following account:', 'essential-real-estate' ) . "\r\n\r\n";
            $message .= network_home_url( '/' ) . "\r\n\r\n";
            /* translators: %s: username */
            $message .= sprintf(esc_html__('Username: %s', 'essential-real-estate'), $user_login) . "\r\n\r\n";
            $message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.', 'essential-real-estate') . "\r\n\r\n";
            $message .= esc_html__('To reset your password, visit the following address:', 'essential-real-estate') . "\r\n\r\n";
            $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

            if ( is_multisite() ) {
                $blogname = $GLOBALS['current_site']->site_name;
            } else {
                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            }

            /* translators: %s: site name */
            $title = sprintf( esc_html__('[%s] Password Reset', 'essential-real-estate'), $blogname );
            $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );
            $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );
            if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
                echo wp_json_encode(array('success' => false, 'message' => esc_html__('The email could not be sent.', 'essential-real-estate') . "<br />\n" . esc_html__('Possible reason: your host may have disabled the mail() function.', 'essential-real-estate')));
                wp_die();
            } else {
                echo wp_json_encode(array('success' => true, 'message' => esc_html__('Please, Check your email', 'essential-real-estate') ));
                wp_die();
            }
        }

        /**
         * Check is user restricted
         * @return bool
         */
        private function is_user_restricted() {
            $user = wp_get_current_user();
            if ( in_array( 'ere_customer', (array) $user->roles ) ) {
                return true;
            }
            if ( in_array( 'subscriber', (array) $user->roles ) ) {
                return true;
            }
            return false;
        }

        /**
         * restrict_admin_access
         */
        public function restrict_admin_access() {

            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

            } else if ( isset( $_GET[ 'action' ] ) && ( sanitize_text_field(wp_unslash($_GET[ 'action' ]))  == 'delete' ) ) {

            } else {
                if ($this-> is_user_restricted() ) {
                    wp_redirect( esc_url_raw( home_url( '/' ) ) );
                    exit;
                }
            }
        }

        /**
         * Hide admin bar
         */
        public function hide_admin_bar() {
            if ( is_user_logged_in() ) {
                if ( $this->is_user_restricted() ) {
                    add_filter( 'show_admin_bar', '__return_false' );
                }
            }
        }

        /**
         * Modal login/register
         */
        public function login_register_modal() {
	        if ( !is_user_logged_in() ) {
		        echo ere_get_template_html('global/dashboard-login-modal.php');
	        }

        }

	    public function redirect_is_login() {
		    if (is_user_logged_in()) {
			    $login_page_id = ere_get_page_id('login');
			    $register_page_id = ere_get_page_id('register');
			    if ((($login_page_id > 0) && is_page($login_page_id)) || (($register_page_id > 0) && is_page($register_page_id)) ) {
				    $redirect_url = ere_get_permalink( 'my_profile' );
				    if ($redirect_url === false) {
					    $redirect_url = home_url('/');
				    }
				    $redirect_url = apply_filters('ere_redirect_url_is_login',$redirect_url);
				    $page_on_front_url = '';
				    if ('page' === get_option( 'show_on_front' )) {
					    $page_on_front = (int) get_option( 'page_on_front' );
					    $page_on_front_url = get_permalink($page_on_front);
				    }

				    if ($redirect_url != $page_on_front_url) {
						wp_safe_redirect($redirect_url);
					}
			    }
		    }
	    }

	    /**
	     * Check users can register
	     * @return bool
	     */
		public function users_can_register() {
			$enable_register_tab = ere_get_option( 'enable_register_tab', 1 );
			return $enable_register_tab == 1;
		}

    }
}