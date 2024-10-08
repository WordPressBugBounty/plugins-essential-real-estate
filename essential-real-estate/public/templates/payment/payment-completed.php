<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$ere_ayment = new ERE_Payment();
$payment_method = isset($_GET['payment_method']) ? absint(ere_clean(wp_unslash($_GET['payment_method']))) : -1;
if ($payment_method == 1) {
    $ere_ayment->paypal_payment_completed();
} elseif ($payment_method == 2) {
    $ere_ayment->stripe_payment_completed();
}
?>
<div class="ere-payment-completed-wrap">
    <?php
    do_action('ere_before_payment_completed');
    if (isset($_GET['order_id']) && $_GET['order_id'] != ''):
        $order_id = absint(ere_clean(wp_unslash($_GET['order_id'])));
        $ere_invoice = new ERE_Invoice();
        $invoice_meta = $ere_invoice->get_invoice_meta($order_id);
        ?>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card ere-card">
                    <div class="card-header"><h5 class="card-title m-0"><?php esc_html_e('My Order', 'essential-real-estate'); ?></h5></div>
                    <ul class="list-group p-0">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php esc_html_e('Order Number', 'essential-real-estate'); ?>
                            <strong><?php echo esc_html($order_id); ?></strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"><?php esc_html_e('Date', 'essential-real-estate'); ?>
                            <strong><?php echo get_the_date('', $order_id); ?></strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"><?php esc_html_e('Total', 'essential-real-estate'); ?>
                            <strong><?php echo wp_kses_post(ere_get_format_money($invoice_meta['invoice_item_price'])) ; ?></strong></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"><?php esc_html_e('Payment Method', 'essential-real-estate'); ?>
                            <strong>
                                <?php echo esc_html(ERE_Invoice::get_invoice_payment_method($invoice_meta['invoice_payment_method'])) ;  ?>
                            </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center"><?php esc_html_e('Payment Type', 'essential-real-estate'); ?>
                            <strong>
                                <?php echo esc_html(ERE_Invoice::get_invoice_payment_type($invoice_meta['invoice_payment_type']));  ?>
                            </strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="ere-heading">
                    <h2><?php echo wp_kses_post(ere_get_option('thankyou_title_wire_transfer','')) ; ?></h2>
                </div>
                <div class="ere-thankyou-content">
                    <?php
                    $html_info=ere_get_option('thankyou_content_wire_transfer','');
                    echo wpautop($html_info); ?>
                </div>
                <a href="<?php echo esc_url(ere_get_permalink('my_properties')); ?>"
                   class="btn btn-primary"> <?php esc_html_e('Go to Dashboard', 'essential-real-estate'); ?> </a>
            </div>
        </div>
    <?php else: ?>
        <div class="ere-heading">
            <h2><?php echo wp_kses_post(ere_get_option('thankyou_title','')); ?></h2>
        </div>
        <div class="ere-thankyou-content">
            <?php
            $html_info=ere_get_option('thankyou_content','');
            echo wpautop($html_info); ?>
           </div>
        <a href="<?php echo esc_url(ere_get_permalink('my_properties')) ; ?>"
           class="btn btn-primary"> <?php esc_html_e('Go to Dashboard', 'essential-real-estate'); ?> </a>
    <?php endif;
    do_action('ere_after_payment_completed');
    ?>
</div>