<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
/**
 * @var $atts
 * @var $css_class_field
 * @var $css_class_half_field
 * @var $show_status_tab
 */
$address_enable = $keyword_enable = $title_enable = $city_enable = $type_enable = $status_enable = $rooms_enable = $bedrooms_enable =
$bathrooms_enable = $price_enable = $price_is_slider = $area_enable = $area_is_slider = $land_area_enable = $land_area_is_slider = $country_enable = $state_enable = $neighborhood_enable = $label_enable = $garage_enable =
$property_identity_enable = $other_features_enable = $show_advanced_search_btn = '';
extract(shortcode_atts(array(
    'status_enable' => 'true',
    'type_enable' => 'true',
    'keyword_enable' => 'true',
    'title_enable' => 'true',
    'address_enable' => 'true',
    'country_enable' => '',
    'state_enable' => '',
    'city_enable' => '',
    'neighborhood_enable' => '',
    'rooms_enable' => '',
    'bedrooms_enable' => '',
    'bathrooms_enable' => '',
    'price_enable' => 'true',
    'price_is_slider' => '',
    'area_enable' => '',
    'area_is_slider' => '',
    'land_area_enable' => '',
    'land_area_is_slider' => '',
    'label_enable' => '',
    'garage_enable' => '',
    'property_identity_enable' => '',
    'other_features_enable' => '',
    'show_advanced_search_btn' => 'true',
), $atts));

$advanced_search = ere_get_permalink( 'advanced_search' );
$wrapper_classes = [
    'form-search-wrap',
];

if ( filter_var( $status_enable, FILTER_VALIDATE_BOOLEAN ) && filter_var( $show_status_tab, FILTER_VALIDATE_BOOLEAN ) ) {
    $wrapper_classes[] = 'has-status-tab';
}
$additional_fields = ere_get_search_additional_fields();
$search_fields = ere_get_option('search_fields', array('property_status',  'property_type', 'property_title', 'property_address','property_country', 'property_state', 'property_city', 'property_neighborhood', 'property_bedrooms', 'property_bathrooms', 'property_price', 'property_size', 'property_land', 'property_label', 'property_garage', 'property_identity', 'property_feature'));
if (array_key_exists('sort_order',$search_fields)) {
    unset($search_fields['sort_order']);
}

if (filter_var( $show_status_tab, FILTER_VALIDATE_BOOLEAN ) ) {
    if (array_key_exists('property_status', $search_fields)) {
        unset($search_fields['property_status']);
    }
}

if (empty($search_fields)) {
    return;
}
?>
<div class="<?php echo esc_attr( join( ' ', $wrapper_classes ) ) ?>">
    <div class="form-search-inner">
        <div class="ere-search-content">
            <div data-href="<?php echo esc_url( $advanced_search ) ?>" class="search-properties-form">
                <?php if ( filter_var( $status_enable, FILTER_VALIDATE_BOOLEAN ) && filter_var( $show_status_tab, FILTER_VALIDATE_BOOLEAN ) ): ?>
                    <?php ere_get_template('property/search-fields/property_status_tabs.php'); ?>
                <?php endif; ?>
                <div class="form-search">
                    <div class="row">
                        <?php
                        do_action('ere_before_property_search_form', $search_fields , $css_class_field, $css_class_half_field);
                        foreach ($search_fields as $field) {
                            switch ($field) {
                                case 'property_status':
                                    if (filter_var($status_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_type':
                                    if (filter_var($type_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'keyword':
                                    if (filter_var($keyword_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_title':
                                    if (filter_var($title_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_address':
                                    if (filter_var($address_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_country':
                                    if (filter_var($country_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_state':
                                    if (filter_var($state_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_city':
                                    if (filter_var($city_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_neighborhood':
                                    if (filter_var($neighborhood_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_rooms':
                                    if (filter_var($rooms_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_bedrooms':
                                    if (filter_var($bedrooms_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_bathrooms':
                                    if (filter_var($bathrooms_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field
                                        ));
                                    }
                                    break;
                                case 'property_price':
                                    if (filter_var($price_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                            'css_class_half_field' => $css_class_half_field,
                                            'price_is_slider' => $price_is_slider,
                                            'show_status_tab' => $show_status_tab
                                        ));
                                    }
                                    break;
                                case 'property_size':
                                    if (filter_var($area_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                            'css_class_half_field' => $css_class_half_field,
                                            'area_is_slider' => $area_is_slider
                                        ));
                                    }
                                    break;
                                case 'property_land':
                                    if (filter_var($land_area_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                            'css_class_half_field' => $css_class_half_field,
                                            'land_area_is_slider' => $land_area_is_slider
                                        ));
                                    }
                                    break;
                                case 'property_label':
                                    if (filter_var($label_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                        ));
                                    }
                                    break;
                                case 'property_garage':
                                    if (filter_var($garage_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                        ));
                                    }
                                    break;
                                case 'property_identity':
                                    if (filter_var($property_identity_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                        ));
                                    }
                                    break;
                                case 'property_feature':
                                    if (filter_var($other_features_enable,FILTER_VALIDATE_BOOLEAN)) {
                                        ere_get_template('property/search-fields/' . $field . '.php', array(
                                            'css_class_field' => $css_class_field,
                                        ));
                                    }
                                    break;
                                default:
                                    if (array_key_exists($field,$additional_fields)) {
                                        if (isset($atts["{$field}_enable"]) && filter_var($atts["{$field}_enable"],FILTER_VALIDATE_BOOLEAN)) {
                                            $additional_field = ere_get_search_additional_field($field);
                                            if ($additional_field !== false) {
                                                $type = isset($additional_field['field_type']) ? $additional_field['field_type'] : 'text';
                                                $file_type = $type;
                                                if ($type === 'textarea') {
                                                    $file_type = 'text';
                                                }

                                                if ($type === 'checkbox_list' || $type === 'radio') {
                                                    $file_type = 'select';
                                                }

                                                ere_get_template('property/search-fields/custom-fields/' . $file_type . '.php', array(
                                                    'css_class_field' => $css_class_field,
                                                    'field' => $additional_field
                                                ));
                                            }
                                        }
                                    }
                                    break;
                            }
                            do_action('ere_property_search_form',$field, $css_class_field, $css_class_half_field);
                        }
                        do_action('ere_after_property_search_form', $search_fields , $css_class_field, $css_class_half_field);
                        ?>
                        <?php if (filter_var($show_advanced_search_btn,FILTER_VALIDATE_BOOLEAN)): ?>
                            <div class="form-group <?php echo esc_attr($css_class_field)?> submit-search-form">
                                <button type="button" class="ere-advanced-search-btn"><i class="fa fa-search"></i>
                                    <?php echo esc_html__('Search', 'essential-real-estate') ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>