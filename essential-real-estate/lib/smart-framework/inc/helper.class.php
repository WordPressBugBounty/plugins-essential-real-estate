<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('GSF_Inc_Helper')) {
	class GSF_Inc_Helper
	{
		private static $_instance;

		public static function getInstance() {
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Create field object from field type
		 *
		 * @param $type
		 * @return GSF_Field
		 */
		public function createField($type) {
			$class_name = str_replace('_', ' ', $type);
			$class_name = ucwords($class_name);
			$class_name = str_replace(' ', '_', $class_name);
			$class_name = 'GSF_Field_' . $class_name;
			if (class_exists($class_name)) {
				return new $class_name();
			}
			return null;
		}

		public function setFieldPrefix($prefix) {
			$GLOBALS['gsf_field_prefix'] = $prefix;
		}

		public function getFieldPrefix() {
			return isset($GLOBALS['gsf_field_prefix']) ? $GLOBALS['gsf_field_prefix'] : '';
		}

		/**
		 * Set field layout
		 * @param $layout
		 */
		public function setFieldLayout($layout) {
			if (!in_array($layout, array('inline', 'full'))) {
				$layout = 'inline';
			}
			$GLOBALS['gsf_field_layout'] = $layout;
		}

		/**
		 * Get field layout
		 * @return string
		 */
		public function getFieldLayout() {
			if (!isset($GLOBALS['gsf_field_layout'])) {
				$GLOBALS['gsf_field_layout'] = 'inline';
			}
			return $GLOBALS['gsf_field_layout'];
		}

		/**
		 * Get template
		 * @param $slug
		 * @param $args
		 */
		public function getTemplate($slug, $args = array()) {
			$located = GSF()->pluginDir($slug . '.php');
            $action_args = array(
                'located'       => $located,
            );

			if (!file_exists($action_args['located'])) {
				return;
			}
            if ( ! empty( $args ) && is_array( $args ) ) {
                if ( isset( $args['action_args'] ) ) {
                    unset( $args['action_args'] );
                }
                extract( $args ); // @codingStandardsIgnoreLine
            }

			include($action_args['located']);
		}

		/**
		 * Get plugin assets url
		 * @param $file
		 * @return string
		 */
		public function getAssetUrl($file) {
			if (!file_exists(GSF()->pluginDir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
				$ext = explode('.', $file);
				$ext = end($ext);
				$normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
				if ($normal_file != $file) {
					$normal_file = untrailingslashit($normal_file) . ".{$ext}";
					if (file_exists(GSF()->pluginDir($normal_file))) {
						return GSF()->pluginUrl(untrailingslashit($normal_file));
					}
				}
			}
			return GSF()->pluginUrl(untrailingslashit($file));
		}

		public function renderFields(&$config, &$values, $current_preset = '') {
			$list_section = array();
			if (isset($config['section'])) {
				foreach ($config['section'] as &$section) {
					$list_section[] = array(
						'id'    => $section['id'],
						'title' => $section['title'],
						'icon'  => isset($section['icon']) ? $section['icon'] : 'dashicons-admin-generic',
					);
				}
			}
			$this->getTemplate('admin/templates/meta-start', array(
				'list_section'   => $list_section,
				'current_preset' => $current_preset
			));

			if (!empty($config)) {
				if (isset($config['section'])) {
					?>
					<?php if (GSF()->adminThemeOption()->is_theme_option_page): ?>
						<?php
						$section_current_id = isset($_GET['section']) ? $this->sanitize_text($_GET['section']) : '';
						if ($section_current_id === '') {
							$section_current_id = array_keys($config['section']);
							$section_current_id = $section_current_id[0];
						}
						?>
						<?php foreach ($config['section'] as &$section): ?>
							<?php if ($section_current_id === $section['id']): ?>
								<div id="section_<?php echo esc_attr($section['id']) ?>" class="gsf-section-container">
									<h4 class="gsf-section-title">
										<i class="gsf-section-title-icon <?php echo esc_attr(isset($section['icon']) ? $section['icon'] : 'dashicons dashicons-admin-generic'); ?>"></i>
										<span><?php echo esc_html($section['title']); ?></span>
										<span class="gsf-section-title-toggle"></span>
									</h4>
									<div class="gsf-section-inner">
										<?php if (isset($section['fields'])): ?>
											<?php $this->renderSubFields($section['fields'], $values) ?>
										<?php endif; ?>
									</div>
								</div><!-- /.gsf-section-container  -->
								<?php break; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<?php foreach ($config['section'] as &$section): ?>
							<div id="section_<?php echo esc_attr($section['id']) ?>" class="gsf-section-container">
								<h4 class="gsf-section-title">
									<i class="gsf-section-title-icon <?php echo esc_attr(isset($section['icon']) ? $section['icon'] : 'dashicons dashicons-admin-generic'); ?>"></i>
									<span><?php echo esc_html($section['title']); ?></span>
									<span class="gsf-section-title-toggle"></span>
								</h4>
								<div class="gsf-section-inner">
									<?php if (isset($section['fields'])): ?>
										<?php $this->renderSubFields($section['fields'], $values) ?>
									<?php endif; ?>
								</div>
							</div><!-- /.gsf-section-container  -->
						<?php endforeach; ?>
					<?php endif; ?>
					<?php
				} else {
					$this->renderSubFields($config['fields'], $values);
				}
			}

			$this->getTemplate('admin/templates/meta-end');
		}

		public function renderSubFields(&$fields, &$values) {
			foreach ($fields as &$config) {
				$type = isset($config['type']) ? $config['type'] : '';
				if (empty($type)) {
					continue;
				}
				$id = isset($config['id']) ? $config['id'] : '';
				$field = $this->createField($config['type']);
				$field->_setting = &$config;
				if (in_array($type, array('group', 'row'))) {
					$field->_value = $values;
				} else {
					if (!empty($id)) {
						$field->_value = isset($values[$id]) ? $values[$id] : null;
					} else {
						$field->_value = null;
					}
				}

				$field->render();
			}
		}

		/**
		 * Get Config Keys
		 *
		 * @param $configs
		 * @param $current_section
		 * @return array
		 */
		public function getConfigKeys(&$configs, $current_section = '') {
			$field_keys = array();
			if (isset($configs['section'])) {
				if (!empty($current_section) && isset($configs['section'][$current_section])) {
					$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($configs['section'][$current_section]['fields']));
				} else {
					foreach ($configs['section'] as $section) {
						if (isset($section['fields'])) {
							$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($section['fields']));
						}
					}
				}
			} else {
				if (isset($configs['fields'])) {
					$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($configs['fields']));
				}
			}
			return $field_keys;
		}

		private function getConfigFieldKeys(&$fields) {
			$field_keys = array();
			foreach ($fields as $field) {
				if (!isset($field['type'])) {
					continue;
				}
				$field_type = $field['type'];

				switch ($field_type) {
					case 'row':
					case 'group':
						$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($field['fields']));
						break;
					default:
						if (!isset($field['id'])) {
							break;
						}
						$field_obj = $this->createField($field_type);
						$field_obj->_setting = $field;
						$field_keys[$field['id']] = array(
							'type'        => $field_type,
							'empty_value' => $field_obj->getEmptyValue()
						);
						break;
				}
			}
			return $field_keys;
		}

		public function getConfigDefault(&$configs, $current_section = '') {
			$field_default = array();
			if (!empty($current_section)) {
				if (isset($configs['section'])) {
					foreach ($configs['section'] as $section) {
						if ('section_' . $section['id'] == $current_section) {
							if (isset($section['fields'])) {
								$field_default = array_merge($field_default, $this->getConfigDefaultField($section['fields']));
							}
						}
					}
				}
			} else {
				if (isset($configs['section'])) {
					foreach ($configs['section'] as $section) {
						if (isset($section['fields'])) {
							$field_default = array_merge($field_default, $this->getConfigDefaultField($section['fields']));
						}
					}
				} else {
					if (isset($configs['fields'])) {
						$field_default = array_merge($field_default, $this->getConfigDefaultField($configs['fields']));
					}
				}
			}
			return $field_default;
		}

		private function getConfigDefaultField(&$fields) {
			$field_default = array();
			foreach ($fields as $field) {
				if (!isset($field['type'])) {
					continue;
				}
				$field_type = $field['type'];

				switch ($field_type) {
					case 'row':
					case 'group':
						$field_default = array_merge($field_default, $this->getConfigDefaultField($field['fields']));
						break;
					default:
						if (!isset($field['id'])) {
							break;
						}
						$field_obj = $this->createField($field_type);
						$field_obj->_setting = $field;
						$field_default[$field['id']] = $field_obj->getFieldDefault();
						break;
				}
			}
			return $field_default;
		}

		/**
		 * Get list sidebars
		 *
		 * @return array
		 */
		public function getSidebars() {
			$sidebars = array();
			if (is_array($GLOBALS['wp_registered_sidebars'])) {
				foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
					$sidebars[$sidebar['id']] = ucwords($sidebar['name']);
				}
			}
			return $sidebars;
		}

		/**
		 * Get listing menu
		 *
		 * @return array
		 */
		public function getMenus() {
			$user_menus = get_categories(array(
				'taxonomy'   => 'nav_menu',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC'
			));
			$menus = array();
			foreach ($user_menus as $menu) {
				$menus[$menu->term_id] = $menu->name;
			}

			return $menus;
		}

		/**
		 * Get listing taxonomies
		 *
		 * @param array $params
		 * @return array
		 */
		public function getTaxonomies($params = array()) {
			$args = array(
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => false,
			);
			if (!empty($params)) {
				$args = wp_parse_args($params, $args);
			}

			$categories = get_categories($args);
			$taxs = array();
			foreach ($categories as $cate) {
				$taxs[$cate->term_id] = $cate->name;
			}

			return $taxs;
		}

		/**
		 * Get listing post
		 *
		 * @param array $params
		 * @return array
		 */
		public function getPosts($params = array()) {
			$args = array(
				'numberposts' => 20,
				'orderby'     => 'post_title',
				'order'       => 'ASC',
                'suppress_filters' => false
            );
			if (!empty($params)) {
				$args = array_merge($args, $params);
			}

			$posts = get_posts($args);
			$ret_posts = array();
			foreach ($posts as $post) {
				$ret_posts[$post->ID] = $post->post_title;
			}

			return $ret_posts;
		}

		/**
		 * Render selected attribute
		 *
		 * @param $value
		 * @param $current
		 */
		public function theSelected($value, $current) {
			$this->render_attr_iff((is_array($current) && in_array($value, $current)) || (!is_array($current) && ($value == $current)), 'selected', 'selected');
		}

		/**
		 * Render checked attribute
		 *
		 * @param $value
		 * @param $current
		 */
		public function theChecked($value, $current) {
			$this->render_attr_iff((is_array($current) && in_array($value, $current)) || (!is_array($current) && ($value == $current)), 'checked', 'checked');
		}

		/**
		 * Get attachment id by url
		 *
		 * @param $url
		 * @return int
		 */
		public function getAttachmentIdByUrl($url) {
			global $wpdb;
			$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid=%s;", $url));
			if (!empty($attachment)) {
				return $attachment[0];
			}

			return 0;
		}

		/**
		 * Get framework nonce verify key
		 * @return mixed|void
		 */
		public function getNonceVerifyKey() {
			return apply_filters('gsf_nonce_verify_key', 'GSF_SMART_FRAMEWORK_VERIFY');
		}

		/**
		 * Get framework nonce value
		 * @return string
		 */
		public function getNonceValue() {
			return wp_create_nonce($this->getNonceVerifyKey());
		}

        public function getFontIcons() {
            $data = json_decode(GSF()->file()->getContents(GSF()->pluginDir('assets/vendors/font-awesome/data.json')),true) ;
            return apply_filters('gsf_font_icon_config', array(
                'font-awesome' => array(
                    'label' => esc_html__('Font Awesome', 'smart-framework'),
                    'total' => '7864',
                    'iconGroup' => $data
                ),
            ));
        }

		public function getFontIconsSvg() {
			return apply_filters('gsf_font_icon_svg', array());
		}

		/**
		 * Get field by field id
		 * @param $fields
		 * @param $id (example: name, contact/address, ...)
		 *
		 * @return null | array
		 */
		public function &getFieldById(&$fields, $id) {
			$currentField = null;
			if (strpos($id, '/') === false) {
				if (isset($fields['fields'][$id])) {
					return $fields['fields'][$id];
				}
				return $currentField;
			}
			$arr_id = explode('/', $id);
			$currentField = &$fields;
			foreach ($arr_id as $key => $id) {
				if (!isset($currentField['fields'][$id])) {
					$currentField = null;
					break;
				}
				$currentField = &$currentField['fields'][$id];
			}
			return $currentField;
		}

		/**
		 * @param $field
		 * @param $fields_added
		 * @param $key - -1: Append Top Array, key: Append after key (if key not exists append to last array)
		 *
		 * @return array
		 */
		function &addFields(&$field, $fields_added, $key) {
			if (!isset($field['fields'])) {
				return $field;
			}
			if ($key === -1) {
				$field['fields'] = array_merge($fields_added, $field['fields']);
				return $field;
			}

			$new_fields = array();
			if (!isset($field['fields'][$key])) {
				$field['fields'] = array_merge($field['fields'], $fields_added);
				return $field;
			}
			foreach ($field['fields'] as $k => $v) {
				$new_fields[$k] = $v;
				if ($key === $k) {
					$new_fields = array_merge($new_fields, $fields_added);
				}
			}
			$field['fields'] = &$new_fields;
			return $field;
		}

		function processConfigsFieldID(&$configs, &$new_array) {
			$new_array = array();
			foreach ($configs as $page => &$page_config) {
				$new_array[$page] = array();
				foreach ($page_config as $k => &$v) {
					if ($k === 'section') {
						$new_array[$page][$k] = array();
						foreach ($v as $section_key => &$section_value) {
							$new_array[$page][$k][$section_value['id']] = &$section_value;
						}
					} else {
						$new_array[$page][$k] = &$v;
					}
				}
			}
		}

		/**
		 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
		 * Non-scalar values are ignored.
		 *
		 * @param string|array $var Data to sanitize.
		 * @return string|array
		 */
		function sanitize_text($var) {
			if ( is_array( $var ) ) {
				return array_map( array($this, 'sanitize_text'), $var );
			} else {
				return is_scalar( $var ) ? sanitize_text_field( wp_unslash($var) ) : $var;
			}
		}

        function sanitize_filter_post_kses($var) {
            if ( is_array( $var ) ) {
                return array_map( array($this, 'sanitize_filter_post_kses'), $var );
            } else {
                return is_scalar( $var ) ? wp_filter_post_kses( wp_unslash($var) ) : $var;
            }
        }

		function render_html_attr($attrs) {
			foreach ($attrs as $k => $v) {
                if (is_bool($v)) {
                    echo esc_attr($k) . '="'. ($v ? 'true' : 'false') . '" ';
                }
                else {
                    echo esc_attr($k) . '="'. esc_attr(is_scalar($v) ? $v : wp_json_encode($v)) . '" ';
                }
			}
		}

		function render_attr_iff($condition, $attr, $value) {
		    if ($condition) {
                if (is_bool($value)) {
                    echo esc_attr($attr) . '="'. ($value ? 'true' : 'false') . '" ';
                }
                else {
                    echo esc_attr($attr) . '="' . esc_attr(is_scalar($value) ? $value : wp_json_encode($value)) . '"';
                }
		    }
        }

        function get_current_screen(){
            if ( !function_exists( 'get_current_screen' ) ) {
                require_once ABSPATH . '/wp-admin/includes/screen.php';
            }

            if (!function_exists('get_current_screen')) {
                return null;
            }

            return get_current_screen();
        }
	}
}