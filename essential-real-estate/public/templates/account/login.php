<?php
/**
 * @var $atts
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$redirect = 'my_profile';
extract( shortcode_atts( array(
	'redirect' => 'my_profile'
), $atts ) );
$redirect_url = ere_get_permalink( 'my_profile' );
if ( $redirect != 'my_profile' ) {
	$redirect_url = '';
}
$rememberId = uniqid('remember_');
?>
<div class="ere__account-login-wrap ere-login-wrap">
	<form class="ere-login needs-validation" novalidate>
        <div class="ere_messages message"></div>
		<div class="form-group control-username">
            <label class="sr-only"><?php echo esc_html__( 'Username or email address', 'essential-real-estate' ); ?></label>
            <input required name="user_login" class="form-control login_user_login"
                   placeholder="<?php echo esc_attr__( 'Username or email address', 'essential-real-estate' ); ?>"
                   type="text"/>
		</div>
		<div class="form-group control-password">
            <label class="sr-only"><?php echo esc_html__( 'Password', 'essential-real-estate' ); ?></label>
            <div class="input-group">
                <input required name="user_password" class="form-control ere__password"
                       placeholder="<?php echo esc_attr__( 'Password', 'essential-real-estate' ); ?>" type="password"/>
                <div class="input-group-append ere__show-password">
                    <div class="input-group-text"><i class="fa fa-eye"></i></div>
                </div>
            </div>
		</div>
		<?php
		/**
		 * Fires following the 'Password' field in the login form.
		 *
		 * @since 2.1.0
		 */
		do_action( 'login_form' );
		?>
        <div class="form-group d-flex justify-content-between">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="<?php echo esc_attr($rememberId)?>">
                <label class="form-check-label" for="<?php echo esc_attr($rememberId)?>"><?php echo esc_html__( 'Remember me', 'essential-real-estate' ); ?></label>
            </div>
            <a href="javascript:void(0)" class="ere-reset-password"><?php echo esc_html__( 'Forgot password?', 'essential-real-estate' ) ?></a>
        </div>
        <button type="submit" data-redirect-url="<?php echo esc_url( $redirect_url ); ?>"
                class="ere-login-button btn btn-primary btn-block"><?php esc_html_e( 'Login', 'essential-real-estate' ); ?></button>

		<input type="hidden" name="ere_security_login"
		       value="<?php echo esc_attr(wp_create_nonce( 'ere_login_ajax_nonce' )); ?>"/>
		<input type="hidden" name="action" value="ere_login_ajax">
	</form>
</div>
<?php echo ere_get_template_html( 'account/reset-password.php' ); ?>