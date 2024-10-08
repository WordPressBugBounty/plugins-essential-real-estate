<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$users_can_register = ERE_Login_Register::getInstance()->users_can_register();
?>
<?php if (!$users_can_register): ?>
<div class="modal modal-login fade" id="ere_signin_modal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo esc_html__('Log in','essential-real-estate') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo do_shortcode( '[ere_login redirect="current_page"]' ); ?>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<div class="modal modal-login fade" id="ere_signin_modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<ul class="nav nav-tabs list-inline mb-0">
						<li class="list-inline-item">
							<a class="active" id="ere_login_modal_tab" href="#login"
							   data-toggle="tab"><?php esc_html_e( 'Log in', 'essential-real-estate' ); ?></a>
						</li>
						<li class="list-inline-item">
							<a id="ere_register_modal_tab" href="#register"
							   data-toggle="tab"><?php esc_html_e( 'Register', 'essential-real-estate' ); ?></a>
						</li>
					</ul>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="tab-content ">
						<div class="tab-pane active" id="login">
							<?php echo do_shortcode( '[ere_login redirect="current_page"]' ); ?>
						</div>
						<div class="tab-pane" id="register">
							<?php echo do_shortcode( '[ere_register redirect="login_tab"]' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>