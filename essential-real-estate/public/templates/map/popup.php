<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<script type="text/template" id="tmpl-ere__map_popup_template">
	<div class="ere__map-popup">
		<div class="ere__map-popup-thumb">
			<a href="{{{data.url}}}" target="_blank" title="{{{data.title}}}">
				{{{data.thumb}}}
			</a>
		</div>
		<div class="ere__map-popup-content">
			<h5 class="ere__map-popup-title">
				<a href="{{{data.url}}}" target="_blank">{{{data.title}}}</a>
			</h5>
            {{{data.price}}}
			<span class="ere__map-popup-address">
                <i class="fa fa-map-marker"></i> {{{data.address}}}
            </span>
		</div>
	</div>
</script>
<script type="text/template" id="tmpl-ere__map_popup_simple_template">
    <div class="ere__map-popup">
        {{{data.content}}}
    </div>
</script>

<script type="text/template" id="tmpl-ere__nearby_place_item_template">
    <div class="ere__nearby-place-item">
        <div class="ere__nearby-place-item-content"><span class="ere__name">{{{data.name}}}</span><span class="ere__dot"></span><span class="ere__distant">{{{data.distant}}} {{{data.unit}}}</span></div>
        <div class="ere__nearby-place-item-type">{{{data.type}}}</div>
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




