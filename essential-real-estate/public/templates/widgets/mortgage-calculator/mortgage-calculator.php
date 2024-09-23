<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$currency = ere_get_option('currency_sign');
if (empty($currency)) {
	$currency = esc_html__('$', 'essential-real-estate');
}
$id =  uniqid('ere__mc_');
?>
<div class="ere__mortgage-calculator-wrap">
    <form class="needs-validation ere__mc-form" novalidate>
        <div class="form-group">
            <label for="<?php echo esc_attr($id)?>sale_price"><?php echo esc_html__('Sale Price', 'essential-real-estate'); ?></label>
            <input type="text" class="form-control" id="<?php echo esc_attr($id)?>sale_price" name="sale_price" placeholder="<?php echo esc_attr($currency) ?>" required>
        </div>
        <div class="form-group">
            <label for="<?php echo esc_attr($id)?>down_payment"><?php echo esc_html__('Down Payment', 'essential-real-estate'); ?></label>
            <input type="text" class="form-control" id="<?php echo esc_attr($id)?>down_payment" name="down_payment" placeholder="<?php echo esc_attr($currency) ?>" required>
        </div>
        <div class="form-group">
            <label for="<?php echo esc_attr($id)?>term_years"><?php echo esc_html__('Term[Years]', 'essential-real-estate'); ?></label>
            <input type="text" class="form-control" id="<?php echo esc_attr($id)?>term_years" name="term_years" placeholder="<?php echo esc_attr__('Year', 'essential-real-estate'); ?>" required>
        </div>
        <div class="form-group">
            <label for="<?php echo esc_attr($id)?>interest_rate"><?php echo esc_html__('Interest Rate in %', 'essential-real-estate'); ?></label>
            <input type="text" class="form-control" id="<?php echo esc_attr($id)?>interest_rate" name="interest_rate" placeholder="<?php echo esc_attr__('%', 'essential-real-estate'); ?>" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block ere__btn-submit-mortgage-calculator"><?php echo esc_html__('Calculate', 'essential-real-estate'); ?></button>
        </div>
    </form>
</div>
