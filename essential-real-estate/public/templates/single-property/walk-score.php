<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * @var $property_id
 * @var $data
 */
$wrapper_classes = array(
    'single-property-element',
    'property-walkscore',
    'walkscore-wrap',
    'ere__single-property-element',
    'ere__single-property-walk-score'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_walkscore_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php esc_html_e('Walk Score', 'essential-real-estate'); ?></h2>
    </div>
    <div class="ere-property-element">
         <?php if ($data): ?>
            <?php if (!empty($data['logo'])): ?>
                 <div class="ere__logo">
                     <a href="https://www.walkscore.com" target="_blank">
                         <img src="<?php echo esc_url($data['logo'])?>" alt="<?php esc_attr_e('Walk Scores', 'essential-real-estate'); ?>">
                     </a>
                 </div>
            <?php endif; ?>
            <div class="ere__walk-score-list">
                <?php foreach ($data['items'] as $k => $v): ?>
                    <div class="ere__walk-score-item">
                        <div class="ere__score">
                            <?php echo esc_html($v['score'])?>
                        </div>
                        <div class="ere__info">
                            <div class="ere__info-inner">
                                <h4 class="ere__title">
                                    <a target="_blank" title="<?php echo esc_attr($v['title'])?>" href="<?php echo esc_url($v['url'])?>"><?php echo esc_html($v['title'])?></a>
                                </h4>
                                <p class="ere__desc m-0"><?php echo wp_kses_post($v['desc'])?></p>
                            </div>
                            <a target="_blank" class="ere__link" href="<?php echo esc_url($v['url'])?>"><?php echo esc_html__('View more', 'essential-real-estate'); ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
             <?php echo esc_html__('An error occurred while fetching walk scores.', 'essential-real-estate'); ?>
        <?php endif; ?>
    </div>
</div>
