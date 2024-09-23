<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $atts
 */
$redirect = 'login';
extract( shortcode_atts( array(
	'redirect' => 'login'
), $atts ) );
$redirect_url = ere_get_permalink( 'login' );
if ( $redirect != 'login' ) {
	$redirect_url = '';
}
$register_terms_condition = ere_get_option( 'register_terms_condition' );
$enable_password          = ere_get_option( 'enable_password', 0 );
?>
<div class="ere__account-login-wrap ere-register-wrap">
	<form class="ere-register needs-validation" novalidate>
        <div class="ere_messages message"></div>
        <div class="form-group control-username">
            <label class="sr-only"><?php echo esc_html__( 'Username', 'essential-real-estate' ); ?></label>
            <input required name="user_login" class="form-control"
                   placeholder="<?php echo esc_attr__( 'Username', 'essential-real-estate' ); ?>"
                   type="text"/>
        </div>

        <div class="form-group control-email">
            <label class="sr-only"><?php echo esc_html__( 'Email', 'essential-real-estate' ); ?></label>
            <input required name="user_email" class="form-control"
                   placeholder="<?php echo esc_attr__( 'Email', 'essential-real-estate' ); ?>"
                   type="email"/>
        </div>

		<?php if ( $enable_password ) : ?>

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

            <div class="form-group control-password-retype">
                <label class="sr-only"><?php echo esc_html__( 'Retype Password', 'essential-real-estate' ); ?></label>
                <div class="input-group">
                    <input required name="user_password_retype" class="form-control ere__password"
                           placeholder="<?php echo esc_attr__( 'Retype Password', 'essential-real-estate' ); ?>" type="password"/>
                    <div class="input-group-append ere__show-password">
                        <div class="input-group-text"><i class="fa fa-eye"></i></div>
                    </div>
                </div>
            </div>

		<?php endif; ?>
		<?php

		/**
		 * Fires following the 'Email' field in the user registration form.
		 *
		 * @since 2.1.0
		 */
		do_action( 'register_form' );

		?>
        <div class="form-check form-group control-term-condition">
            <input required type="checkbox" class="form-check-input" name="term_condition" id="term_condition">
            <label class="form-check-label" for="term_condition">
                <?php
                /* translators: %s: link of page register terms condition. */
                echo wp_kses(sprintf(__( 'I agree with your <a target="_blank" href="%s">Terms & Conditions</a>', 'essential-real-estate' ),
                    get_permalink( $register_terms_condition )),
                    array(
                    'a' => array(
                        'target' => array(),
                        'href'   => array()
                    )
                ));
                ?></label>
        </div>
        <button type="submit" data-redirect-url="<?php echo esc_url( $redirect_url ); ?>"
                class="ere-register-button btn btn-primary btn-block"><?php esc_html_e( 'Register', 'essential-real-estate' ); ?></button>
		<input type="hidden" name="ere_register_security"
		       value="<?php echo esc_attr(wp_create_nonce( 'ere_register_ajax_nonce' )); ?>"/>
		<input type="hidden" name="action" value="ere_register_ajax">
	</form>
</div>
