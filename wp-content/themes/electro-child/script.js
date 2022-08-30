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
checkJustin();
jQuery( document ).ajaxComplete(function() {
    checkJustin();
});