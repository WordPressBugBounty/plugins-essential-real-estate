<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $email
 * @var $enable_captcha
 * @var $extend_class
 */
$wrapper_classes = array(
    'ere__contact-form'
);

if (isset($extend_class)) {
    $wrapper_classes[] = $extend_class;
}

$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__('Contact', 'essential-real-estate'); ?></h2>
    </div>
    <form class="needs-validation ere__form" novalidate>
        <div class="form-group">
            <label for="sender_name"><?php echo esc_html__('Full Name', 'essential-real-estate'); ?></label>
            <input class="form-control" id="sender_name" required name="sender_name" type="text" placeholder="<?php echo esc_attr__('Full Name', 'essential-real-estate'); ?>">
            <div class="invalid-feedback"> <?php echo esc_html__('Please enter your Name!', 'essential-real-estate'); ?> </div>
        </div>
        <div class="form-group">
            <label for="sender_phone"><?php echo esc_html__('Phone Number', 'essential-real-estate'); ?></label>
            <input class="form-control" id="sender_phone" required name="sender_phone" type="text" placeholder="<?php echo esc_attr__('Phone Number', 'essential-real-estate'); ?>">
            <div class="invalid-feedback"> <?php echo esc_html__('Please enter your Phone!', 'essential-real-estate'); ?> </div>
        </div>
        <div class="form-group">
            <label for="sender_email"><?php echo esc_html__('Email Address', 'essential-real-estate'); ?></label>
            <input class="form-control" id="sender_email" required name="sender_email" type="email" placeholder="<?php echo esc_attr__('Email Address', 'essential-real-estate'); ?>">
            <div class="invalid-feedback"> <?php echo esc_html__('Please enter your valid Email!', 'essential-real-estate'); ?> </div>
        </div>
        <div class="form-group">
            <label for="sender_msg"><?php echo esc_html__('Message', 'essential-real-estate'); ?></label>
            <textarea class="form-control" id="sender_msg" name="sender_msg" rows="5" placeholder="<?php esc_attr_e('Message', 'essential-real-estate'); ?>" required></textarea>
            <div class="invalid-feedback"> <?php echo esc_html__('Please enter your Message!', 'essential-real-estate'); ?> </div>
        </div>
        <?php if ($enable_captcha): ?>
            <div class="form-group">
                <?php  do_action('ere_generate_form_recaptcha'); ?>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block ere__btn-submit-contact-form"><?php echo esc_html__('Submit Request', 'essential-real-estate'); ?></button>
        </div>
        <input type="hidden" name="target_email" value="<?php echo esc_attr($email); ?>">
        <input type="hidden" name="action" id="contact_agent_action" value="ere_contact_agent_ajax">
        <?php wp_nonce_field('ere_contact_agent_ajax_nonce', 'ere_security_contact_agent'); ?>
        <div class="ere__message"></div>
    </form>
</div>
