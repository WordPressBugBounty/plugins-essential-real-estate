<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$my_properties_page_link = ere_get_permalink('my_properties');
$post_status = isset($_REQUEST['post_status']) ?  sanitize_title(wp_unslash($_REQUEST['post_status'])) : '';
$status = array(
    '' => esc_html__('All', 'essential-real-estate'),
    'publish' => esc_html__('Approved', 'essential-real-estate'),
    'pending' => esc_html__('Pending', 'essential-real-estate'),
    'expired' => esc_html__('Expired', 'essential-real-estate'),
    'hidden' => esc_html__('Hidden', 'essential-real-estate'),
);
?>
<ul class="ere__my-property-filter ere-my-properties-filter">
    <?php foreach ($status as $k => $v): ?>
        <?php
            $item_classes = array($k);
            if ($post_status === $k) {
                $item_classes[] = 'active';
            }
            $item_class = join(' ', $item_classes);
            $item_link = remove_query_arg(array('new_id', 'edit_id'), add_query_arg(array('post_status' => $k), $my_properties_page_link));
            if (empty($k)) {
                $item_link = $my_properties_page_link;
            }
            $item_count = ERE_Property::getInstance()->get_total_my_properties($k);
        ?>
        <li class="ere__my-property-filter-<?php echo esc_attr($item_class)?>">
            <a href="<?php echo esc_url($item_link)?>" title="<?php echo esc_attr($v)?>"><?php echo esc_html(sprintf('%s (%d)',$v,$item_count)) ?></a>
        </li>
    <?php endforeach; ?>
</ul>
