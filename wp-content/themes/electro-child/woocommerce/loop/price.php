<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$currency_rate = get_field('currency_rate', 'options');
$currency_symbol = get_field('currency_symbol', 'options');
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
?>

<?php if ( $price_html = $product->get_price_html() ) : ?>
	<span data-currency="<?php echo $sale_price ?>" class="price"><?php echo $price_html; ?></span>
	<?php if ( $currency_rate ) : ?>
		<span class="additional-currency">
			<?php if ($regular_price && $sale_price) {
				//echo '<del class="old-price">' . round($regular_price*$currency_rate, 1) . '&nbsp;' . $currency_symbol . '</del>' . '&nbsp;';
			}
			if ($sale_price) {
				echo '<span class="sale-price">' . round($sale_price*$currency_rate, 1) . '&nbsp;' . $currency_symbol . '</span>';
			}
			elseif ($regular_price) {
				echo round($regular_price*$currency_rate, 1) . '&nbsp;' . $currency_symbol;
			}
			?>
		</span>
	<?php endif; ?>
<?php endif; ?>
