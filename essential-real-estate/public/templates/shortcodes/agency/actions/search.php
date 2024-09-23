<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$keyword = isset($_GET['keyword']) ? ere_clean(wp_unslash($_GET['keyword'])) : '';
?>
<div class="ere__apa-item ere__apa-search">
    <form method="get" action="<?php echo esc_url(get_post_type_archive_link( 'agent' )) ; ?>">
        <div class="input-group">
            <input type="search" class="form-control" value="<?php echo esc_attr($keyword)?>" name="keyword" placeholder="<?php echo esc_attr__( 'Name or Location', 'essential-real-estate' ); ?>">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
</div>
