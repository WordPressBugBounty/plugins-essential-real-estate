<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $post;
$agent_id = get_the_ID();
$agent_post_meta_data = get_post_custom($agent_id);
$custom_agent_image_size_single = ere_get_option('custom_agent_image_size_single', '270x340');
$agent_name = get_the_title();
$agent_position = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_position']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_position'][0] : '';

$agent_description = apply_filters('ere_description',isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_description']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_description'][0] : '') ;
$agent_company = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_company']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_company'][0] : '';
$agent_licenses = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_licenses']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_licenses'][0] : '';
$agent_office_address = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_office_address']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_office_address'][0] : '';
$agent_mobile_number = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_mobile_number']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_mobile_number'][0] : '';
$agent_fax_number = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_fax_number']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_fax_number'][0] : '';
$agent_office_number = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_office_number']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_office_number'][0] : '';
$email = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_email']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_email'][0] : '';
$agent_website_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_website_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_website_url'][0] : '';

$agent_facebook_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_facebook_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_facebook_url'][0] : '';
$agent_twitter_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_twitter_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_twitter_url'][0] : '';
$agent_linkedin_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_linkedin_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_linkedin_url'][0] : '';
$agent_pinterest_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_pinterest_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_pinterest_url'][0] : '';
$agent_instagram_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_instagram_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_instagram_url'][0] : '';
$agent_skype = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_skype']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_skype'][0] : '';
$agent_youtube_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_youtube_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_youtube_url'][0] : '';
$agent_vimeo_url = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_vimeo_url']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_vimeo_url'][0] : '';

$agent_user_id = isset($agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id']) ? $agent_post_meta_data[ERE_METABOX_PREFIX . 'agent_user_id'][0] : '';
$user = get_user_by('id', $agent_user_id);
if (empty($user)) {
    $agent_user_id = 0;
}
$ere_property = new ERE_Property();
$total_property = $ere_property->get_total_properties_by_user($agent_id, $agent_user_id);

?>

<div class="single-agent-element agent-single ere_single-agent-info ere__single-agent-element">
    <div class="agent-single-inner row">
        <?php
        $avatar_id = get_post_thumbnail_id($agent_id);
        $avatar_src = '';
        $width = 270;
        $height = 340;
        $no_avatar_src = ERE_PLUGIN_URL . 'public/assets/images/profile-avatar.png';
        $default_avatar = ere_get_option('default_user_avatar', '');
        if (preg_match('/\d+x\d+/', $custom_agent_image_size_single)) {
            $image_size = explode('x', $custom_agent_image_size_single);
            $width = $image_size[0];
            $height = $image_size[1];
            $avatar_src = ere_image_resize_id($avatar_id, $width, $height, true);
            if ($default_avatar != '') {
                if (is_array($default_avatar) && $default_avatar['url'] != '') {
                    $resize = ere_image_resize_url($default_avatar['url'], $width, $height, true);
                    if ($resize != null && is_array($resize)) {
                        $no_avatar_src = $resize['url'];
                    }
                }
            }
        } else {
            if (!in_array($custom_agent_image_size_single, array('full', 'thumbnail'))) {
                $custom_agent_image_size_single = 'full';
            }
            $avatar_src = wp_get_attachment_image_src($avatar_id, $custom_agent_image_size_single);
            if ($avatar_src && !empty($avatar_src[0])) {
                $avatar_src = $avatar_src[0];
            }
            if (!empty($avatar_src)) {
                list($width, $height) = getimagesize($avatar_src);
            }
            if ($default_avatar != '') {
                if (is_array($default_avatar) && $default_avatar['url'] != '') {
                    $no_avatar_src = $default_avatar['url'];
                }
            }
        }
        ?>
        <div class="ere__single-agent-avatar agent-avatar text-center col-lg-3">
            <img width="<?php echo esc_attr($width) ?>"
                 height="<?php echo esc_attr($height) ?>"
                 src="<?php echo esc_url($avatar_src) ?>"
                 onerror="this.src = '<?php echo esc_url($no_avatar_src) ?>';"
                 alt="<?php echo esc_attr($agent_name) ?>"
                 title="<?php echo esc_attr($agent_name) ?>">
            <?php if ($total_property > 0): ?>
                <?php
                    $property_archive_link = get_post_type_archive_link('property');
                    $agent_property_link = add_query_arg('agent_id',$agent_id,$property_archive_link);
                ?>
                <a class="btn btn-primary btn-block"
                   href="<?php echo esc_url($agent_property_link); ?>"
                   title="<?php echo esc_attr($agent_name) ?>"><?php esc_html_e('View All Properties', 'essential-real-estate'); ?></a>
            <?php endif; ?>
        </div>
        <div class="agent-content col-lg-5">
            <div class="agent-content-top">
                <?php if (!empty($agent_name)): ?>
                    <h2 class="ere__single-agent-title agent-title"><?php echo esc_html($agent_name) ?></h2>
                <?php endif; ?>
                <div class="ere__single-agent-social agent-social">
                    <?php if (!empty($agent_facebook_url)): ?>
                        <a title="Facebook" href="<?php echo esc_url($agent_facebook_url); ?>">
                            <i class="fa fa-facebook"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_twitter_url)): ?>
                        <a title="Twitter" href="<?php echo esc_url($agent_twitter_url); ?>">
                            <i class="fa fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($email)): ?>
                        <a title="Email" href="mailto:<?php echo esc_attr($email); ?>">
                            <i class="fa fa-envelope"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_skype)): ?>
                        <a title="Skype" href="skype:<?php echo esc_url($agent_skype); ?>?call">
                            <i class="fa fa-skype"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_linkedin_url)): ?>
                        <a title="Linkedin" href="<?php echo esc_url($agent_linkedin_url); ?>">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_pinterest_url)): ?>
                        <a title="Pinterest" href="<?php echo esc_url($agent_pinterest_url); ?>">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_instagram_url)): ?>
                        <a title="Instagram" href="<?php echo esc_url($agent_instagram_url); ?>">
                            <i class="fa fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_youtube_url)): ?>
                        <a title="Youtube" href="<?php echo esc_url($agent_youtube_url); ?>">
                            <i class="fa fa-youtube-play"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($agent_vimeo_url)): ?>
                        <a title="Vimeo" href="<?php echo esc_url($agent_vimeo_url); ?>">
                            <i class="fa fa-vimeo"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php if (!empty($agent_position)): ?>
                    <span class="ere__single-agent-position agent-position"><?php echo esc_html($agent_position) ?></span>
                <?php endif; ?>
                <span class="ere__single-agent-number-property agent-number-property">
					<?php /* translators: %s: Number of property agent. */ echo wp_kses_post(sprintf(_n('%s property', '%s properties', $total_property, 'essential-real-estate'), ere_get_format_number($total_property))); ?>
				</span>
            </div>
            <div class="ere__single-agent-contact-info agent-contact agent-info">
                <?php if (!empty($agent_office_address)): ?>
                    <div><i class="fa fa-map-marker"></i><strong><?php esc_html_e('Address:', 'essential-real-estate'); ?></strong>
							<span><?php echo esc_html($agent_office_address) ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($email)): ?>
                    <div><i class="fa fa-envelope"></i><strong><?php esc_html_e('Email:', 'essential-real-estate'); ?></strong>
                        <a style="display: inline;" href="mailto:<?php echo esc_attr($email) ?>"
                           title="<?php esc_attr_e('Website:', 'essential-real-estate'); ?>">
								<span><?php echo esc_html($email) ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($agent_mobile_number)): ?>
                    <div>
                        <i class="fa fa-phone"></i><strong><?php esc_html_e('Phone:', 'essential-real-estate'); ?></strong>
                        <span><?php echo esc_html($agent_mobile_number) ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($agent_website_url)): ?>
                    <div>
                        <i class="fa fa-link"></i><strong><?php esc_html_e('Website:', 'essential-real-estate'); ?></strong>
                        <a style="display: inline;" href="<?php echo esc_url($agent_website_url) ?>"
                           title="<?php esc_attr_e('Website:', 'essential-real-estate'); ?>">
                            <span><?php echo esc_url($agent_website_url); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
                <hr class="mg-top-20">
                <?php the_terms($agent_id,'agency','<div class="ere__single-agent-agency agent-agency"><strong>'. esc_html__('Agency:', 'essential-real-estate') .'</strong> ','','</div>'); ?>

                <?php
                if (!empty($agent_company)): ?>
                    <div>
                        <strong><?php esc_html_e('Company:', 'essential-real-estate'); ?></strong>
                        <span><?php echo esc_html($agent_company); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($agent_licenses)): ?>
                    <div>
                        <strong><?php esc_html_e('Licenses:', 'essential-real-estate'); ?></strong>
                        <span><?php echo esc_html($agent_licenses); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($agent_office_number)): ?>
                    <div>
                        <strong><?php esc_html_e('Office Number:', 'essential-real-estate'); ?></strong>
                        <span><?php echo esc_html($agent_office_number); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($agent_office_address)): ?>
                    <div>
                        <strong><?php esc_html_e('Office Address:', 'essential-real-estate'); ?></strong>
                        <span><?php echo esc_html($agent_office_address); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="ere__single-agent-contact-form contact-agent col-lg-4">
            <?php ere_template_single_agent_contact_form(); ?>
        </div>
    </div>
    <?php if (!empty($agent_description)): ?>
        <div class="ere__single-agent-description agent-description">
            <?php echo wp_kses_post($agent_description) ?>
        </div>
    <?php endif; ?>
</div>