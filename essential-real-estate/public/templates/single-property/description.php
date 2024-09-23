<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$wrapper_classes = array(
    'single-property-element',
    'property-description',
    'ere__single-property-element',
    'ere__single-property-description'
);
$wrapper_class = join(' ', apply_filters('ere_single_property_description_wrapper_classes',$wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class)?>">
    <div class="ere-heading-style2">
        <h2><?php echo esc_html__( 'Description', 'essential-real-estate' ); ?></h2>
    </div>
    <div class="ere-property-element">
        <?php the_content(); ?>
    </div>
</div>
