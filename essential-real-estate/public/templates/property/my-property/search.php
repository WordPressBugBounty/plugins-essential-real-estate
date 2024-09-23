<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
$property_status = isset($_REQUEST['property_status']) ? ere_clean( wp_unslash( $_REQUEST['property_status'] ) ) : '';
$property_identity = isset($_REQUEST['property_identity']) ?  ere_clean( wp_unslash( $_REQUEST['property_identity'] ) ) : '';
$title = isset($_REQUEST['title']) ?  ere_clean( wp_unslash( $_REQUEST['title'] ) ) : '';
$post_status = isset($_REQUEST['post_status']) ?  sanitize_title(wp_unslash($_REQUEST['post_status'])) : '';
?>
<form class="ere-my-properties-search ere__my-property-search" action="<?php echo esc_url(get_page_link()) ; ?>">
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="form-group">
                <label class="sr-only" for="property_status"><?php echo esc_html__('Property Status', 'essential-real-estate'); ?></label>
                <select name="property_status" id="property_status" class="form-control" title="<?php echo esc_attr__('Property Status', 'essential-real-estate') ?>">
                    <?php ere_get_property_status_search_slug($property_status); ?>
                    <option value="" <?php selected('', $property_status); ?>>
                        <?php echo esc_html__('All Status', 'essential-real-estate') ?>
                    </option>
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="form-group">
                <label class="sr-only" for="property_identity"><?php echo esc_html__('Property ID', 'essential-real-estate'); ?></label>
                <input type="text" name="property_identity" id="property_identity"
                       value="<?php echo esc_attr($property_identity); ?>"
                       class="form-control"
                       placeholder="<?php echo esc_attr__('Property ID', 'essential-real-estate'); ?>">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="form-group">
                <label class="sr-only" for="title"><?php echo esc_html__('Title', 'essential-real-estate'); ?></label>
                <input type="text" name="title" id="title"
                       value="<?php echo esc_attr($title); ?>"
                       class="form-control"
                       placeholder="<?php echo esc_attr__('Title', 'essential-real-estate'); ?>">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="form-group">
                <button type="submit" id="search_property" class="btn btn-primary"><?php echo esc_html__('Search', 'essential-real-estate')?></button>
            </div>
        </div>
        <?php if (!empty($post_status)): ?>
            <input type="hidden" name="post_status" value="<?php echo esc_attr($post_status); ?>"/>
        <?php endif; ?>
    </div>
</form>

