<?php
/**
 * Electro Child
 *
 * @package electro-child
 */

/**
 * Currency Additional fn
 */

$show_currency = get_field('show_in_cart_and_checkout', 'options');
$currency_symbol = get_field('currency_symbol', 'options');
$rounding_up_to = get_field('currency_rounding_up_to', 'options');
$currency_rate = get_field('currency_rate', 'options');

function additional_currency_attr() {
	global $show_currency;
	global $currency_symbol;
	global $rounding_up_to;
	global $currency_rate;
	if( in_array('Yes', $show_currency)){
		echo 'data-currency-show' . ' ';
		echo 'data-symbol="' . $currency_symbol . '" ';
		echo 'data-round="' . $rounding_up_to . '" ';
		echo 'data-rate="' . $currency_rate . '" ';
	}
}

function additional_currency_build($regular_price, $sale_price, $is_product) {
	global $show_currency;
	global $currency_symbol;
	global $rounding_up_to;
	global $currency_rate;
	$show_order = in_array('Yes', $show_currency) && $currency_rate;
	$rounding_value = '';
	if ($rounding_up_to == 1) {
		$rounding_value = 1;
	} elseif ($rounding_up_to == 2) {
		$rounding_value = 2;
	}
	$currency_price = round($regular_price / $currency_rate, $rounding_value) . '&nbsp;' . $currency_symbol;
	
	if ( $show_order && !$is_product ) {
		echo '<br><div class="additional-currency">' . $currency_price . '</div>';
	}
	if ( $currency_rate && $is_product) {
		echo '<div class="additional-currency">';
		if ($regular_price && $sale_price) {
			//echo '<del class="old-price">' . $currency_price . '</del>' . '&nbsp;';
		} if ($sale_price) {
			echo '<span class="sale-price">' . round($sale_price / $currency_rate, $rounding_value)  . '&nbsp;' . $currency_symbol . '</span>';
		} elseif ($regular_price) {
			echo $currency_price;
		}
		echo '</div>';
	}
	
}
