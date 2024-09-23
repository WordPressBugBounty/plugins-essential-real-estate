<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * @var $atts
 */
$status_enable = $el_class ='';
extract(shortcode_atts(array(
    'status_enable' => 'true',
    'el_class' => '',
), $atts));
$wrapper_classes = array(
    'ere-mini-search-properties',
    $el_class,
);
$advanced_search = ere_get_permalink('advanced_search');
$wrapper_class = join(' ', apply_filters('ere_sc_mini_search_property_wrapper_classes',$wrapper_classes) );
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div data-href="<?php echo esc_url($advanced_search) ?>" class="ere-mini-search-properties-form form-search-wrap">
        <?php
            if (filter_var($status_enable, FILTER_VALIDATE_BOOLEAN)) {
                ere_get_template('property/search-fields/property_status.php', array(
                    'css_class_field' => 'status'
                ));
            }
            ere_get_template('property/search-fields/keyword.php', array(
                'css_class_field' => 'keyword'
            ));
        ?>
        <button type="button" id="mini-search-btn"><i class="fa fa-search"></i></button>
    </div>
</div>