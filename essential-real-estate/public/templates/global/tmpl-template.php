<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-ere-processing-template">
    <div class="ere-processing">
        <div class="loading">
            <i class="{{{data.ico}}}"></i><span>{{{data.text}}}</span>
        </div>
    </div>
</script>
<script type="text/html" id="tmpl-ere-alert-template">
    <div class="ere-alert-popup">
        <div class="content-popup">
            <div class="message">
                <i class="{{{data.ico}}}"></i><span>{{{data.text}}}</span>
            </div>
            <div class="btn-group">
                <a href="javascript:void(0)" class="btn-close"><?php esc_html_e('Close', 'essential-real-estate') ?></a>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="tmpl-ere-dialog-template">
    <div class="ere-dialog-popup" id="ere-dialog-popup">
        <div class="content-popup">
            <div class="message">
                <i class="{{{data.ico}}}"></i><span>{{{data.message}}}</span>
            </div>
        </div>
    </div>
</script>
<script type="text/template" id="tmpl-ere__mc_template">
    <div class="ere__mc-result">
        <div class="ere__loan-amount"><span><?php echo esc_html__('Loan Amount','essential-real-estate') ?>:</span> <strong>{{{data.loan_amount}}}</strong></div>
        <div class="ere__years"><span><?php echo esc_html__('Years','essential-real-estate') ?>:</span> <strong>{{{data.years}}}</strong></div>
        <div class="ere__monthly"><span><?php echo esc_html__('Monthly','essential-real-estate') ?>:</span> <strong>{{{data.monthly_payment}}}</strong></div>
        <div class="ere__bi_weekly"><span><?php echo esc_html__('Bi Weekly','essential-real-estate') ?>:</span> <strong>{{{data.bi_weekly_payment}}}</strong></div>
        <div class="ere__weekly"><span><?php echo esc_html__('Weekly','essential-real-estate') ?>:</span> <strong>{{{data.weekly_payment}}}</strong></div>
    </div>
</script>