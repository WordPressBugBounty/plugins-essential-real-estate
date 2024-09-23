<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $hide_compare_fields;
$hide_compare_fields = ere_get_option('hide_compare_fields', array());
$additional_fields = ere_render_additional_fields();
if (!is_array($hide_compare_fields)) {
    $hide_compare_fields = array();
}
ERE_Compare::open_session();
$property_ids = $_SESSION['ere_compare_properties'];
$property_ids = array_diff($property_ids, ["0"]);
$args = array(
    'post_type' => 'property',
    'post__in' => $property_ids,
    'post_status' => 'publish',
    'orderby' => 'post__in',
    'posts_per_page' => -1
);
$data = new WP_Query($args);
$type_html = $status_html = $size_html = $land_html = $room_html = $bedroom_html = $bathroom_html = $garage_html = $garage_size_html = $year_html = '';
$has_type = $has_status = $has_size = $has_land = $has_room = $has_bedroom = $has_bathroom = $has_garage = $has_garage_size = $has_year = false;
$empty_field = '<td class="check-no"><i class="fa fa-minus"></i></td>';
$measurement_units = ere_get_measurement_units();
$measurement_units_land_area = ere_get_measurement_units_land_area();
$property_features = get_categories(array(
    'hide_empty' => 0,
    'taxonomy'  => 'property-feature'
));
$compare_terms = array();
foreach ($property_ids as $post_id) {
    $compare_terms[$post_id] = wp_get_post_terms($post_id, 'property-feature', array('fields' => 'ids'));
}
?>
<?php if ($data->have_posts()): ?>
    <div class="table-responsive-xl ere__compare-table-wrap compare-table-wrap ere-property">
    <table class="table ere__compare-tables compare-tables table-striped">
        <thead>
            <tr>
                <th class="title-list-check"></th>
                <?php while ($data->have_posts()):$data->the_post(); ?>
                    <th>
                        <div class="ere__property-compare">
                            <div class="property-inner">
                                <div class="property-image">
                                    <?php
                                    ere_template_loop_property_image();
                                    /**
                                     * Hook: ere_after_loop_compare_property_thumbnail.
                                     *
                                     * @hooked ere_template_loop_property_featured_label - 5
                                     * @hooked ere_template_loop_property_term_status - 10
                                     * @hooked ere_template_loop_property_link - 15
                                     */
                                    do_action('ere_after_loop_compare_property_thumbnail');
                                    ?>
                                </div>
                                <div class="property-item-content">
                                    <div class="property-heading">
                                        <?php
                                        /**
                                         * Hook: ere_loop_compare_property_heading.
                                         *
                                         * @hooked ere_template_loop_property_title - 5
                                         * @hooked ere_template_loop_property_price - 10
                                         */
                                        do_action('ere_loop_compare_property_heading');
                                        ?>
                                    </div>
                                    <?php
                                    /**
                                     * Hook: ere_after_loop_compare_property_heading.
                                     *
                                     * @hooked ere_template_loop_property_location - 5
                                     */
                                    do_action('ere_after_loop_compare_property_heading');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </th>
                    <?php
                    if (!in_array("property_type", $hide_compare_fields)) {
                        $type = get_the_term_list(get_the_ID(),'property-type','',', ','');
                        if (!empty($type)) {
                            $has_type = true;
                            $type_html .= '<td>' . $type . '</td>';
                        } else {
                            $type_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_status", $hide_compare_fields)) {
                        $status =  get_the_term_list(get_the_ID(),'property-status','',', ','');
                        if (!empty($status)) {
                            $has_status = true;
                            $status_html .= '<td>' . $status . '</td>';
                        } else {
                            $status_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_size", $hide_compare_fields)) {
                        $size = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_size', true);
                        if (!empty($size)) {
                            $has_size = true;
                            $size_html .= '<td>' . wp_kses_post(sprintf( '%s %s',ere_get_format_number($size), $measurement_units)) . '</td>';
                        } else {
                            $size_html .= $empty_field;
                        }
                    }


                    if (!in_array("property_land", $hide_compare_fields)) {
                        $land = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_land', true);
                        if (!empty($land)) {
                            $has_land = true;
                            $land_html .= '<td>' . wp_kses_post(sprintf( '%s %s',ere_get_format_number($land), $measurement_units_land_area)) . '</td>';
                        } else {
                            $land_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_rooms", $hide_compare_fields)) {
                        $room = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_rooms', true);
                        if (!empty($room)) {
                            $has_room = true;
                            $room_html .= '<td>' . $room . '</td>';
                        } else {
                            $room_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_bedrooms", $hide_compare_fields)) {
                        $bedroom = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_bedrooms', true);
                        if (!empty($bedroom)) {
                            $has_bedroom = true;
                            $bedroom_html .= '<td>' . $bedroom . '</td>';
                        } else {
                            $room_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_bathrooms", $hide_compare_fields)) {
                        $bathroom = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_bathrooms', true);
                        if (!empty($bathroom)) {
                            $has_bathroom = true;
                            $bathroom_html .= '<td>' . $bathroom . '</td>';
                        } else {
                            $bathroom_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_garage", $hide_compare_fields)) {
                        $garage = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_garage', true);
                        if (!empty($garage)) {
                            $has_garage = true;
                            $garage_html .= '<td>' . $garage . '</td>';
                        } else {
                            $garage_html .= $empty_field;
                        }
                    }

                    if (!in_array("property_garage_size", $hide_compare_fields)) {
                        $garage_size = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_garage_size', true);
                        if (!empty($garage_size)) {
                            $has_garage_size = true;
                            $garage_size_html .= '<td>' . wp_kses_post(sprintf( '%s %s',$garage_size, $measurement_units)) . '</td>';
                        } else {
                            $garage_size_html .= $empty_field;
                        }
                    }



                    if (!in_array("property_year", $hide_compare_fields)) {
                        $year = get_post_meta(get_the_ID(),ERE_METABOX_PREFIX . 'property_year',true);
                        if (!empty($year)) {
                            $has_year = true;
                            $year_html .= '<td>' . $year . '</td>';
                        } else {
                            $year_html .= $empty_field;
                        }
                    }

                    ?>
                <?php endwhile; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ($has_type): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Type', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($type_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_status): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Status', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($status_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_size): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Size', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($size_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_land): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Land Area', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($land_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_room): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Rooms', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($room_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_bedroom): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Bedrooms', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($bedroom_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_bathroom): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Bathrooms', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($bathroom_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_garage): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Garages', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($garage_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_garage_size): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Garages Size', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($garage_size_html)?>
                </tr>
            <?php endif; ?>
            <?php if ($has_year): ?>
                <tr>
                    <td class="title-list-check"><?php echo esc_html__('Year Built', 'essential-real-estate'); ?></td>
                    <?php echo wp_kses_post($year_html)?>
                </tr>
            <?php endif; ?>
            <?php foreach ($property_features as $feature): ?>
            <tr>
                <td class="title-list-check"><?php echo esc_html($feature->name); ?></td>
                <?php foreach ($property_ids as $property_id): ?>
                    <?php if (in_array($feature->term_id, $compare_terms[$property_id])): ?>
                        <td><div class="check-yes"><i class="fa fa-check"></i></div></td>
                    <?php else: ?>
                        <td><div class="check-no"><i class="fa fa-minus"></i></div></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            <?php foreach ($additional_fields as $k => $field): ?>
            <?php
                $field_html = '';
                $field_check = false;
            ?>
            <?php ob_start(); ?>
            <tr>
                <td class="title-list-check"><?php echo esc_html($field['title'])?></td>
                <?php foreach ($property_ids as $property_id): ?>
                <?php $value = get_post_meta($property_id,$field['id'], true); ?>
                <?php if (!empty($value)): ?>
                        <?php
                            $field_check = true;
                            if ($field['type'] == 'checkbox_list') {
                                $text = '';
                                if (count($value) > 0) {
                                    foreach ($value as $v) {
                                        $text .= $v . ', ';
                                    }
                                }
                                $value = rtrim($text, ', ');
                            }
                        ?>
                        <td><?php echo esc_html($value)?></td>
                <?php else: ?>
                        <?php echo wp_kses_post($empty_field); ?>
                <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            <?php $field_html = ob_get_clean(); ?>
            <?php if ($field_check) {
                echo wp_kses_post($field_html);
                } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else: ?>
    <?php ere_get_template('loop/content-none.php'); ?>
<?php endif; ?>
