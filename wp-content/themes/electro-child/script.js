//TODO: Show / Hide Justin Shipping Method box

jQuery(document).on('click', '#shipping_method input', function () {
    console.log('val', jQuery(this).val());
    if(jQuery(this).val().includes('justin_shipping_method')) {
        if(jQuery('#justin_shipping_method_fields').length) {
            setTimeout(function () {
                jQuery('#justin_shipping_method_fields').addClass('show');
            }, 400)
        }
    }
    else {
        jQuery('#justin_shipping_method_fields').removeClass('show');
    }
});
function checkJustin() {
    if(jQuery('[id*="justin_shipping_method"]:checked').length 
        && jQuery('#justin_shipping_method_fields').length) {
        setTimeout(function () {
            jQuery('#justin_shipping_method_fields').addClass('show');
        }, 400)
    }
}
function currencyMiniCartUpdate(el) {
    let price = jQuery('[data-currency-show]');
    if(price.length) {
        price.each(function() {
            let _self = jQuery(this);
            let cartTotal = _self.find(el);
            let totalVal = cartTotal.text().replace(/[^0-9]/gi, '');
            let currencyRate = _self.data('rate');
            let currencyRound = _self.data('round');
            let currencySymbol = _self.data('symbol');
            let currencyVal = jQuery('<span class="additional-currency">'
             + (totalVal/currencyRate).toFixed(currencyRound) + '&nbsp;' + currencySymbol + '</span>');
            if(cartTotal.length && totalVal) {
                cartTotal.next('.additional-currency').remove();
                currencyVal.insertAfter(cartTotal);
            }
        });
    }
}
checkJustin();

jQuery( window ).on("load", function(){
    currencyMiniCartUpdate('.cart-items-total-price .amount');
});
jQuery( document ).ajaxComplete(function() {
    checkJustin();
    currencyMiniCartUpdate('.amount');
});
