<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $actions
 * @var $property_id
 */
$my_properties_page_link = ere_get_permalink('my_properties');
?>
<?php do_action('ere_my_property_before_actions',$property_id) ?>
<ul class="ere__loop-my-property-action">
    <?php foreach ($actions as $k => $v): ?>
        <?php
        $action_url = add_query_arg(array('action' => $k, 'property_id' => $property_id), $my_properties_page_link);
        if ($v['nonce']) {
            $action_url = wp_nonce_url($action_url, 'ere_my_properties_actions');
        }
        $item_attributes = array();
        $item_attributes['href'] = $action_url;
        if (!empty($v['confirm'])) {
            $item_attributes['onclick'] = sprintf("return confirm('%s')",$v['confirm']);
        }
        $item_attributes['data-toggle'] = "tooltip";
        $item_attributes['data-placement'] = "bottom";
        $item_attributes['title'] = $v['tooltip'];
        $item_attributes['class'] = sprintf("ere__btn-dashboard-action ere__btn-dashboard-action-%s",$k);
        ?>
        <li class="ere__loop-my-property-action-<?php echo esc_attr($k)?>">
            <a <?php ere_render_html_attr($item_attributes) ?>><?php echo esc_html($v['label'])?></a>
        </li>
    <?php endforeach; ?>
</ul>
