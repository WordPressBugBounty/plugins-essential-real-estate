<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="ere__account-login-wrap ere-reset-password-wrap">
	<form class="needs-validation" novalidate>
        <div class="ere_messages message ere_messages_reset_password"></div>
        <div class="form-group control-username">
            <label class="sr-only"><?php echo esc_html__( 'Username or email address', 'essential-real-estate' ); ?></label>
            <input required name="user_login" class="form-control reset_password_user_login"
                   placeholder="<?php echo esc_attr__( 'Username or email address', 'essential-real-estate' ); ?>"
                   type="text"/>
        </div>
		<?php
		/**
		 * Fires inside the lostpassword form tags, before the hidden fields.
		 *
		 * @since 2.1.0
		 */
		do_action( 'lostpassword_form' );

		?>
		<button type="submit" class="btn btn-primary btn-block ere_forgetpass"><?php esc_html_e( 'Get new password', 'essential-real-estate' ); ?></button>
        <input type="hidden" name="ere_security_reset_password"
               value="<?php echo esc_attr(wp_create_nonce( 'ere_reset_password_ajax_nonce' )); ?>"/>
        <input type="hidden" name="action" value="ere_reset_password_ajax">
	</form>
    <a href="javascript:void(0)"
       class="ere-back-to-login"><?php esc_html_e( 'Back to Login', 'essential-real-estate' ) ?></a>
</div>
