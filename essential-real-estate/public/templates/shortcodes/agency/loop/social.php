<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $data
 */
?>
<ul class="ere__loop-agency-social">
    <?php foreach ($data as $k => $v): ?>
        <li class="<?php echo esc_attr($k)?>">
            <?php if ($k === 'skype'): ?>
                <a href="skype:<?php echo esc_attr($v['link']); ?>?call" title="<?php echo esc_attr($v['label'])?>"><i class="<?php echo esc_attr($v['icon'])?>"></i></a>
            <?php else: ?>
                <a href="<?php echo esc_url($v['link'])?>" title="<?php echo esc_attr($v['label'])?>"><i class="<?php echo esc_attr($v['icon'])?>"></i></a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
