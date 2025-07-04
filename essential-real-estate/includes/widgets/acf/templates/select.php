<?php
/**
 * @var $require_element
 * @var $require_element_id
 * @var $require_compare
 * @var $require_values
 * @var $field_output_name
 * @var $field_title
 * @var $field_output_id
 * @var $field_value
 * @var $is_title_block
 * @var $multiple
 * @var $field_seclect_options
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="select-wrap element"  data-require-element="<?php if(isset($require_element)){ echo esc_attr($require_element);} ?>"
     data-require-element-id="<?php if(isset($require_element_id)){ echo esc_attr($require_element_id);} ?>"
     data-require-compare="<?php if(isset($require_compare)){ echo esc_attr($require_compare);} ?>"
     data-require-values="<?php if(isset($require_values)){ echo esc_attr($require_values);} ?>"
    >
    <label for="<?php echo esc_attr($field_output_name); ?>"><?php echo esc_html($field_title); ?></label>
    <?php if($multiple){ ?>
        <select data-value="<?php echo esc_attr(wp_json_encode($field_value)) ?>" class="widefat selectize" id="<?php echo esc_attr($field_output_id); ?>" name="<?php echo esc_attr($field_output_name); ?>[]" multiple>
            <?php foreach ( $field_seclect_options as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>" > <?php echo esc_attr( $option_value ); ?></option>
            <?php endforeach; ?>
        </select>
    <?php }else{ ?>
        <select class="widefat selectize" id="<?php echo esc_attr($field_output_id); ?>" name="<?php echo esc_attr($field_output_name); ?>">
            <?php foreach ( $field_seclect_options as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>" <?php if(isset($field_value)){ selected( $option_key, $field_value ); };  ?>  > <?php echo esc_attr( $option_value ); ?></option>
            <?php endforeach; ?>
        </select>
    <?php } ?>
</div>
