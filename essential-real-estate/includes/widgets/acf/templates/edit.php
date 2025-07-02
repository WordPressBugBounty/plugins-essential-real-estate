<?php
/**
 * @var $data_section_wrap
 * @var $extras
 * @var $field_values
 * @var $extra_values
 * @var $x
 * @var $allowed_fields
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="widget_acf_wrap" id="<?php echo esc_attr($data_section_wrap) ?>">
	<!-- begin init extra fields -->
	<?php
	if (isset($extras) && is_array($extras)) {
		foreach ($extras as $extra) {
			$field_type = isset($extra['type']) ? sanitize_text_field(wp_unslash($extra['type'])) : 'text';
			$field_name = isset($extra['name']) ? sanitize_text_field(wp_unslash($extra['name'])) : '';
			$field_title = isset($extra['title']) ? sanitize_text_field(wp_unslash($extra['title'])) : '';
			$field_output_id = $this->widget->get_field_id($field_name);
			$field_output_name = $this->widget->get_field_name('extra') . '[' . $field_name . ']';
			$is_title_block = 0;
			$field_value = isset($extra_values) && $extra_values!='' && array_key_exists($field_name, $extra_values) ? $extra_values[$field_name] : '';

			$require = array_key_exists('require', $extra) && isset($extra['require']) ? $extra['require'] : '';
			$require_element = $require_element_id = $require_compare = $require_values = '';
			if(is_array($require)){
				$require_element = array_key_exists('element', $require) && isset($require['element']) ? $require['element'] : '';
				$require_element_id = $this->widget->get_field_id($require_element);
				$require_compare =  array_key_exists('compare', $require) && isset($require['compare']) ? $require['compare'] : '';
				$require_values =  array_key_exists('value', $require) && isset($require['value']) ? implode(',',$require['value']) : '';
			}

			$select_field_id = 'extra_'.$field_name;
			$select_field_name = 'extra'. '[' . $field_name . ']';
			$field_seclect_options = array_key_exists('options', $extra) && isset($extra['options']) ? $extra['options'] : '';
			$allow_clear = array_key_exists('allow_clear', $extra) && isset($extra['allow_clear']) ? $extra['allow_clear'] : '0';
			$multiple = array_key_exists('multiple', $extra) && isset($extra['multiple']) ? true : false;
            if (in_array($field_type,$allowed_fields)) {
                include (ERE_PLUGIN_DIR . "/includes/widgets/acf/templates/{$field_type}.php");
            }
		}
	}
	?>

    <?php
    $section_id = 'widget_acf_accordion_' . $x;
    if(isset($fields) && is_array($fields)){ ?>
    <div class="accordion-wrap">
        <?php foreach ($field_values as $value) {
            $section_id = 'widget_acf_accordion_' . $x;
            $section_title = 'Section';
            foreach ($fields as $field) {
                if (array_key_exists('is_title_block', $field) && $field['is_title_block'] == '1') {
                    $section_title = array_key_exists($field['name'],$value) && $value[$field['name']]!='' ? $value[$field['name']] : 'New Section';
                }
            }
            ?>
            <div class="widget_acf_accordion" id="<?php echo esc_attr($section_id) ?>">
                <h3 class="title"><span class="icon collapse-out"></span><span><?php echo esc_attr($section_title) ?></span>
                </h3>

                <div class="fieldset" data-collapse="0">
                    <?php foreach ($fields as $field) {

                        $field_type = isset($field['type']) ? sanitize_text_field(wp_unslash($field['type'])) : 'text';
                        $field_name = isset($field['name']) ? sanitize_text_field(wp_unslash($field['name'])) : '';
                        $field_title = isset($field['title']) ? sanitize_text_field(wp_unslash($field['title'])) : '';
                        $placeholder = isset($field['placeholder']) ? sanitize_text_field(wp_unslash($field['placeholder'])) : __('Title', 'essential-real-estate');
                        $field_output_id = $this->widget->get_field_id($field_name) . '_' . $x;
                        $field_output_name = $this->widget->get_field_name('fields') . '[' . $x . ']' . '[' . $field_name . ']';
                        $is_title_block = isset($field['is_title_block']) && $field['is_title_block'] == '1' ? 1 : 0;
                        $field_value = isset($value) && $value!='' && array_key_exists($field['name'], $value) ? $value[$field['name']] : '';

                        //select element
                        $select_field_id = 'fields_'.$field_name.'_'.$x;
                        $select_field_name = 'fields'.'[' . $x . ']' . '[' . $field_name . ']';
                        $field_seclect_options = array_key_exists('options', $field) && isset($field['options']) ? $field['options'] : '';
                        $allow_clear = array_key_exists('allow_clear', $field) && isset($field['allow_clear']) ? $field['allow_clear'] : '0';
                        $multiple = array_key_exists('multiple', $field) && isset($field['multiple'])  ? true : false;

                        //image element
                        $img_width = array_key_exists('width', $field) && isset($field['width']) ? $field['width'] : '46';
                        $img_height = array_key_exists('height', $field) && isset($field['height']) ? $field['height'] : '28';
                        $attachment_id = is_array($field_value) && array_key_exists('attachment_id',$field_value) ? $field_value['attachment_id'] : '' ;
                        $url = is_array($field_value) && array_key_exists('url',$field_value) ? $field_value['url'] : '' ;

                        $require = array_key_exists('require', $field) && isset($field['require']) ? $field['require'] : '';
                        $require_element = $require_element_id = $require_compare = $require_values = '';
                        if(is_array($require)){
                            $require_element = array_key_exists('element', $require) && isset($require['element']) ? $require['element'] : '';
                            $require_element_id = $this->widget->get_field_id($require_element) . '_' . $x;
                            $require_compare =  array_key_exists('compare', $require) && isset($require['compare']) ? $require['compare'] : '';
                            $require_values =  array_key_exists('value', $require) && isset($require['value']) ? implode(',',$require['value']) : '';
                        }
                        if (in_array($field_type,$allowed_fields)) {
                            include (ERE_PLUGIN_DIR . "/includes/widgets/acf/templates/{$field_type}.php");
                        }
                    } ?>
                    <div class="button-groups">
                        <a class="button deletion" data-section-id="<?php echo esc_attr($section_id) ?>"
                           data-section-wrap="<?php echo esc_attr($data_section_wrap) ?>"
                           href="javascript:void(0);"><?php echo esc_html__('Delete','essential-real-estate') ?></a>
                    </div>
                </div>
            </div>
            <?php $x++;
        }
        ?>
    </div>
    <div class="button-groups"><a class="button add" href="javascript:void(0);"
                                  data-section-wrap="<?php echo esc_attr($data_section_wrap) ?>"><?php echo esc_html__('Add row','essential-real-estate') ?></a>
    </div>
    <?php }?>


</div>
