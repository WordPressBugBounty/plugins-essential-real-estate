<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 10/5/15
 * Time: 2:18 PM
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('GF_Acf_Widget_Fields')) {
    class GF_Acf_Widget_Fields
    {
        public $field = '';
        public $extra = '';
        public $value = '';
        public $widget = '';
        function __construct($widget, $value)
        {
            $this->widget = $widget;
            $this->field = array_key_exists('fields', $this->widget->settings) ? $this->widget->settings['fields'] : '';
            $this->extra = array_key_exists('extra', $this->widget->settings) ? $this->widget->settings['extra'] : '';
            $this->value = $value;
        }

        public function render()
        {
            $data_section_wrap = uniqid();
            $fields = $this->field;
            $extras = $this->extra;
            $field_values = is_array($this->value) && array_key_exists('fields', $this->value) ? $this->value['fields'] : '';
            $extra_values = is_array($this->value) && array_key_exists('extra', $this->value) ? $this->value['extra'] : '';
            $x = 0;
            $is_edit_mode = (isset($field_values) && is_array($field_values) && count($field_values) > 0) || (isset($extra_values) && is_array($extra_values) && count($extra_values) > 0);
            $allowed_fields = array('checkbox','icon','image','number','select','text','text-area');
	        if ($is_edit_mode) {
                include (ERE_PLUGIN_DIR . '/includes/widgets/acf/templates/edit.php');
	        } else {
                include (ERE_PLUGIN_DIR . '/includes/widgets/acf/templates/new.php');
	        }
        }
    }
}