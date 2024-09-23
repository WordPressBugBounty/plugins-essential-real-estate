<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * @var $is_login
 * @var $name
 * @var $link
 * @var $display_type
 * @var $email
 * @var $avatar
 * @var $position
 * @var $facebook
 * @var $twitter
 * @var $linkedin
 * @var $pinterest
 * @var $instagram
 * @var $skype
 * @var $youtube
 * @var $vimeo
 * @var $mobile
 * @var $office
 * @var $website
 * @var $no_avatar_src
 * @var $desc
 * @var $user_id
 * @var $agent_id
 */
$wrapper_classes = array(
    'single-property-element',
    'property-contact-agent',
    'ere__single-property-element',
    'ere__single-property-contact-agent'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_contact_agent_wrapper_classes',$wrapper_classes));

$enable_captcha =  ere_enable_captcha('contact_agent');

$contact_forms_classes = array(
        'ere__contact-form',
        'ere__single-agent-contact-form'
);
if ($enable_captcha) {
    $contact_forms_classes[] = 'ere__has-captcha';
}

$contact_forms_class = join(' ', $contact_forms_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__( 'Contact', 'essential-real-estate' ); ?></h2>
    </div>
    <div class="ere-property-element">
        <?php if ($display_type !== 'other_info'): ?>
            <div class="ere__contact-agent-info row">
                <div class="ere__agent-image col-md-6">
                    <a title="<?php echo esc_attr($name)?>" href="<?php echo esc_url($link)?>">
                        <img
                                src="<?php echo esc_url($avatar) ?>"
                                onerror="this.src = '<?php echo esc_url($no_avatar_src) ?>';"
                                alt="<?php echo esc_attr($name) ?>"
                                title="<?php echo esc_attr($name) ?>">
                    </a>
                </div>
                <div class="ere__agent-content col-md-6">
                    <h4 class="ere__agent-name"><a href="<?php echo esc_url($link)?>" title="<?php echo esc_attr($name)?>"><?php echo esc_html($name)?></a></h4>
                    <?php if (!empty($position)): ?>
                        <p class="ere__agent-position m-0"><?php echo esc_html($position)?></p>
                    <?php endif; ?>
                    <div class="ere__single-agent-social">
                        <?php if (!empty($facebook)): ?>
                            <a title="<?php echo esc_attr__('Facebook','essential-real-estate'); ?>" href="<?php echo esc_url( $facebook ); ?>">
                                <i class="fa fa-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($twitter)): ?>
                            <a title="<?php echo esc_attr__('Twitter','essential-real-estate'); ?>" href="<?php echo esc_url( $twitter ); ?>">
                                <i class="fa fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($skype)): ?>
                            <a title="<?php echo esc_attr__('Skype','essential-real-estate'); ?>" href="skype:<?php echo esc_url( $skype ); ?>?chat">
                                <i class="fa fa-skype"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($linkedin)): ?>
                            <a title="<?php echo esc_attr__('Linkedin','essential-real-estate'); ?>" href="<?php echo esc_url( $linkedin ); ?>">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($pinterest)): ?>
                            <a title="<?php echo esc_attr__('Pinterest','essential-real-estate'); ?>" href="<?php echo esc_url( $pinterest ); ?>">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($instagram)): ?>
                            <a title="<?php echo esc_attr__('Instagram','essential-real-estate'); ?>" href="<?php echo esc_url( $instagram ); ?>">
                                <i class="fa fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($youtube)): ?>
                            <a title="<?php echo esc_attr__('Youtube','essential-real-estate'); ?>" href="<?php echo esc_url( $youtube ); ?>">
                                <i class="fa fa-youtube-play"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($vimeo)): ?>
                            <a title="<?php echo esc_attr__('Vimeo','essential-real-estate'); ?>" href="<?php echo esc_url( $vimeo ); ?>">
                                <i class="fa fa-vimeo"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="ere__single-agent-contact-info">
                        <?php if ( ! empty( $office ) ): ?>
                            <div class="ere__address">
                                <i class="fa fa-map-marker"></i>
                                <span><?php echo esc_html( $office ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $mobile ) ): ?>
                            <div class="ere__mobile">
                                <i class="fa fa-phone"></i>
                                <span><?php echo esc_html( $mobile ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $email ) ): ?>
                            <div class="ere__email">
                                <i class="fa fa-envelope"></i>
                                <span><?php echo esc_html( $email ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $website ) ): ?>
                            <div class="ere__website">
                                <i class="fa fa-link"></i>
                                <a href="<?php echo esc_url( $website ); ?>"><?php echo esc_html( $website ); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty( $desc )): ?>
                        <div class="ere_desc">
                            <p><?php echo wp_kses_post( $desc ); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                        $property_archive_link = get_post_type_archive_link('property');
                        if ($display_type === 'agent_info') {
                            $agent_property_link = add_query_arg('agent_id', $agent_id, $property_archive_link);
                        } else {
                            $agent_property_link = add_query_arg('user_id', $user_id, $property_archive_link);
                        }
                    ?>
                    <a class="btn btn-primary" href="<?php echo esc_url($agent_property_link) ?>" title="<?php echo esc_attr__( 'Other Properties', 'essential-real-estate' ); ?>"><?php echo esc_html__( 'Other Properties', 'essential-real-estate' ); ?></a>
                </div>
            </div>
        <?php else: ?>
        <div class="ere__contact-agent-info">
            <div class="ere__agent-content">
                <h4 class="ere__agent-name"><a href="<?php echo esc_url($link)?>" title="<?php echo esc_attr($name)?>"><?php echo esc_html($name)?></a></h4>
                <div class="ere__single-agent-contact-info">
                    <?php if ( ! empty( $mobile ) ): ?>
                        <div class="ere__mobile">
                            <i class="fa fa-phone"></i>
                            <span><?php echo esc_html( $mobile ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $email ) ): ?>
                        <div class="ere__email">
                            <i class="fa fa-envelope"></i>
                            <span><?php echo esc_html( $email ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if(!empty( $desc )): ?>
                    <div class="ere_desc">
                        <p><?php echo wp_kses_post( $desc ); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($email)): ?>
            <div class="<?php echo esc_attr($contact_forms_class)?>">
                <form class="needs-validation ere__form" novalidate>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender_name"><?php echo esc_html__('Full Name', 'essential-real-estate'); ?></label>
                                <input class="form-control" id="sender_name" required name="sender_name" type="text" placeholder="<?php echo esc_attr__('Full Name', 'essential-real-estate'); ?>">
                                <div class="invalid-feedback"> <?php echo esc_html__('Please enter your Name!', 'essential-real-estate'); ?> </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender_phone"><?php echo esc_html__('Phone Number', 'essential-real-estate'); ?></label>
                                <input class="form-control" id="sender_phone" required name="sender_phone" type="text" placeholder="<?php echo esc_attr__('Phone Number', 'essential-real-estate'); ?>">
                                <div class="invalid-feedback"> <?php echo esc_html__('Please enter your Phone!', 'essential-real-estate'); ?> </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sender_email"><?php echo esc_html__('Email Address', 'essential-real-estate'); ?></label>
                                <input class="form-control" id="sender_email" required name="sender_email" type="email" placeholder="<?php echo esc_attr__('Email Address', 'essential-real-estate'); ?>">
                                <div class="invalid-feedback"> <?php echo esc_html__('Please enter your valid Email!', 'essential-real-estate'); ?> </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="sender_msg"><?php echo esc_html__('Message', 'essential-real-estate'); ?></label>
                                 <textarea class="form-control" id="sender_msg" name="sender_msg" rows="4"
                                  placeholder="<?php echo esc_attr__( 'Message', 'essential-real-estate' ); ?> *"><?php $title=get_the_title();/* translators: %s: title of property. */ echo sprintf(esc_html__( 'Hello, I am interested in [%s]', 'essential-real-estate' ), esc_html($title)) ?></textarea>
                                <div class="invalid-feedback"> <?php echo esc_html__('Please enter your Message!', 'essential-real-estate'); ?> </div>
                            </div>
                        </div>
                        <?php if ($enable_captcha): ?>
                            <div class="col-sm-6">
                                <?php do_action('ere_generate_form_recaptcha'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-6 ere__agent-contact-btn-wrap">
                            <button type="submit" class="btn btn-primary ere__btn-submit-contact-form"><?php echo esc_html__('Submit Request', 'essential-real-estate'); ?></button>
                        </div>
                        <div class="col-12">
                            <div class="ere__message"></div>
                        </div>
                    </div>
                    <input type="hidden" name="action" id="contact_agent_with_property_url_action" value="ere_contact_agent_ajax">
                    <input type="hidden" name="target_email" value="<?php echo esc_attr( $email ); ?>">
                    <input type="hidden" name="property_url" value="<?php echo esc_url(get_permalink()) ; ?>">
                    <?php wp_nonce_field('ere_contact_agent_ajax_nonce', 'ere_security_contact_agent'); ?>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
