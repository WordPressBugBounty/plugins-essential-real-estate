<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $sort_by_list
 */
$sort_by = $_REQUEST['sortby'] ?? '';
$sort_by_label = esc_html__( 'Sort By', 'essential-real-estate' );
if (!empty($sort_by)) {
    foreach ($sort_by_list as $k => $v) {
        if ($sort_by === $k) {
            $sort_by_label = $v;
            break;
        }
    }
}
?>
<div class="ere__apa-item ere__apa-orderby dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <?php echo esc_html($sort_by_label); ?>
    </a>
    <div class="dropdown-menu">
        <?php foreach ($sort_by_list as $k => $v): ?>
            <a data-sortby="<?php esc_attr($k); ?>" title="<?php echo esc_attr($v)?>" class="dropdown-item" href="<?php echo esc_url(add_query_arg( [ 'sortby' => $k ] ))?>"><?php echo esc_html($v)?></a>
        <?php endforeach; ?>
    </div>
</div>
