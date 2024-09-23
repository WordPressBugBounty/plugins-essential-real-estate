<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $tabs array
 * @var $extend_class
 */
$wrapper_classes = array(
    'ere-tabs',
);

if (isset($extend_class)) {
    $wrapper_classes[]= $extend_class;
}

$wrapper_class = join(' ', $wrapper_classes);
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <ul data-tabcollapse class="nav nav-tabs">
        <?php $index = 0; ?>
        <?php foreach ($tabs as $k => $v): ?>
            <?php
            $nav_link_classes = array('nav-link');
            if ($index === 0) {
                $nav_link_classes[] = 'active';
            }
            $nav_link_class = join(' ',$nav_link_classes);
            ?>
            <li class="nav-item"><a class="<?php echo esc_attr($nav_link_class)?>" data-toggle="tab" href="#<?php echo esc_attr($k)?>"><?php echo esc_html($v['title'])?></a></li>
            <?php $index++; ?>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content">
        <?php $index = 0; ?>
        <?php foreach ($tabs as $k => $v): ?>
            <?php
            $tab_pane_classes = array('tab-pane','fade');
            if ($index === 0) {
                $tab_pane_classes[] = 'active';
                $tab_pane_classes[] = 'show';
            }
            $tab_pane_class = implode(' ', $tab_pane_classes);
            ?>
            <div id="<?php echo esc_attr($k)?>" class="<?php echo esc_attr($tab_pane_class)?>">
                <?php echo wp_kses_post($v['content'])?>
            </div>
            <?php $index++; ?>
        <?php endforeach; ?>
    </div>
</div>
