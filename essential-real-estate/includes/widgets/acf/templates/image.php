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
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="media-wrap element"  data-require-element="<?php if(isset($require_element)){ echo esc_attr($require_element);} ?>"
     data-require-element-id="<?php if(isset($require_element_id)){ echo esc_attr($require_element_id);} ?>"
     data-require-compare="<?php if(isset($require_compare)){ echo esc_attr($require_compare);} ?>"
     data-require-values="<?php if(isset($require_values)){ echo esc_attr($require_values);} ?>">
    <label for="<?php echo esc_attr($field_output_name); ?>"><?php echo esc_html($field_title); ?></label>
	<div class="widget-media-field-wrap image">
		<div class="widget-media-field image">
			<?php
			if (!empty($field_value)) {
				$thumbnail = wp_get_attachment_image_src($field_value, 'thumbnail');
				if ($thumbnail && is_array($thumbnail)) {
					echo '<span data-id="' . esc_attr($field_value) . '"><img src="' . esc_url($thumbnail[0]) . '" /><span class="close">x</span></span>';
				}
			}
			?>
		</div>
		<input type="hidden" name="<?php echo esc_attr($field_output_name); ?>" id="<?php echo esc_attr( $field_output_id ); ?>" value="<?php echo esc_attr($field_value); ?>">
		<p class="none"><a href="#" class="button"><?php esc_html_e('Pick Image','essential-real-estate'); ?></a></p>
	</div>

</div>

