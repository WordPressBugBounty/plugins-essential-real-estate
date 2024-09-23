<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * @var $css_class_field
 */
$request_features = isset($_GET['other_features']) ? ere_clean(wp_unslash($_GET['other_features']))  : '';
if (!empty($request_features)) {
    $request_features = explode(';', $request_features);
}

$property_features = get_categories(array(
    'taxonomy' => 'property-feature',
    'hide_empty' => 0,
    'orderby' => 'term_id',
    'order' => 'ASC'
));

if (!is_array($property_features) || (count($property_features) == 0)) {
    return;
}


$parents_items = $child_items = array();
foreach ($property_features as $term) {
    if (0 == $term->parent) {
        $parents_items[] = $term;
    }
    if ($term->parent) {
        $child_items[] = $term;
    }
};

$has_request_features = !empty($request_features) && is_array($request_features) & count($request_features) > 0;
?>
<div class="col-12 other-features-wrap">
    <div class="enable-other-features">
        <a class="btn-other-features" data-toggle="collapse" href="#ere_search_other_features">
            <?php if ($has_request_features): ?>
                <i class="fa fa-chevron-up"></i>
            <?php else: ?>
                <i class="fa fa-chevron-down"></i>
            <?php endif; ?>
            <?php echo esc_html__('Other Features', 'essential-real-estate'); ?>
        </a>
    </div>
    <div class="collapse<?php echo esc_attr($has_request_features ? ' show' : ''); ?>" id="ere_search_other_features">
        <div class="other-features-list mt-2<?php echo esc_attr($has_request_features ? ' ere-display-block' : ''); ?>">
            <?php if (is_taxonomy_hierarchical('property-feature') && (count($child_items)>0)): ?>
                <?php foreach ($parents_items as $parents_item): ?>
                    <h4 class="property-feature-name"><?php echo esc_html($parents_item->name)?></h4>
                    <div class="row">
                        <?php foreach ($child_items as $child_item): ?>
                            <?php if ($child_item->parent == $parents_item->term_id): ?>
                                <div class="col-lg-2 col-md-3 col-sm-4 col-12 mt-2">
                                    <div class="form-check">
                                        <?php if (!empty($request_features) && in_array($child_item->slug, $request_features)):  ?>
                                            <input type="checkbox" class="form-check-input" id="property_feature_<?php echo esc_attr($child_item->term_id)?>" name="other_features" checked="checked" value="<?php echo esc_attr($child_item->slug) ?>" />
                                        <?php else: ?>
                                            <input type="checkbox" class="form-check-input" id="property_feature_<?php echo esc_attr($child_item->term_id)?>" name="other_features" value="<?php echo esc_attr($child_item->slug) ?>" />
                                        <?php endif; ?>
                                        <label class="form-check-label" for="property_feature_<?php echo esc_attr($child_item->term_id)?>">
                                            <?php echo esc_html($child_item->name); ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($parents_items as $parents_item): ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-12 mt-2">
                            <div class="form-check">
                                <?php if (!empty($request_features) && in_array($parents_item->slug, $request_features)):  ?>
                                    <input type="checkbox" class="form-check-input" id="property_feature_<?php echo esc_attr($parents_item->term_id)?>" name="other_features" checked="checked" value="<?php echo esc_attr($parents_item->slug) ?>" />
                                <?php else: ?>
                                    <input type="checkbox" class="form-check-input" id="property_feature_<?php echo esc_attr($parents_item->term_id)?>" name="other_features" value="<?php echo esc_attr($parents_item->slug) ?>" />
                                <?php endif; ?>
                                <label class="form-check-label" for="property_feature_<?php echo esc_attr($parents_item->term_id)?>">
                                    <?php echo esc_html($parents_item->name); ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>