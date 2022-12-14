<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link https://wordpress.org/plugins/woocommerce-bulk-order-form/
 * @package WooCommerce Bulk Order Form
 * @subpackage WooCommerce Bulk Order Form/FrontEnd
 * @since 3.0
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class WooCommerce_Bulk_Order_Form_Standard_Add_To_Cart_Handler
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @since 1.0
 */
class WooCommerce_Bulk_Order_Form_Standard_Add_To_Cart_Handler {

	/**
	 * WooCommerce_Bulk_Order_Form_Standard_Add_To_Cart_Handler constructor.
	 */
	public function __construct() {
		add_action( 'wc_bof_standard_add_to_cart', array( $this, 'add_to_cart' ), 10, 2 );
		add_action( 'wc_bof_standard_single_add_to_cart', array( $this, 'single_add_to_cart' ), 10, 2 );
	}

	/**
	 * @param $return
	 * @param $args
	 *
	 * @throws \Exception
	 */
	public function single_add_to_cart( &$return, $args ) {
		$this->add_to_cart( $return, $args );
	}

	/**
	 * @param $return
	 * @param $args
	 *
	 * @throws \Exception
	 */
	public function add_to_cart( &$return, $args ) {
		if ( isset( $args['wcbof_products'] ) ) {
			$success  = 0;
			$products = $args['wcbof_products'];
			unset( $products['removeHidden'] );

			foreach ( $products as $product ) {
				$qty          = isset( $product['product_qty'] ) ? $product['product_qty'] : 0;
				$variation_id = '';
				$product_id   = $product['product_id'];
				if ( empty( $product_id ) || empty( $qty ) ) {
					continue;
				}
				$attributes = '';
				if ( 'product_variation' == get_post_type( $product_id ) ) {
					$variation_id = $product_id;
					$product_id   = wp_get_post_parent_id( $variation_id );
					$product      = new WC_Product_Variation( $variation_id );
					$attributes   = $product->get_variation_attributes();
					$attributes   = isset( $attributes ) ? $attributes : '';
				}
				$status = WC()->cart->add_to_cart( $product_id, $qty, $variation_id, $attributes, null );
				if ( $status ) {
					$success++;
				}
			}
			if ( $success > 0 ) {
				$url       = $cart_url = $this->get_cart_url();
				$product_n = _n( 'Your product was successfully added to your cart', 'Your products were successfully added to your cart', $success, 'woocommerce-bulk-order-form' );
				/* translators: 1. URL, 2. product/products */
				$msg       = sprintf( __( '<a class="button wc-forward" href="%1$s">View Cart</a> %2$s.', 'woocommerce-bulk-order-form' ), $url, $product_n );
				$type      = 'success';
			} else {
				$msg  = __( "Looks like there was an error. Please try again.", 'woocommerce-bulk-order-form' );
				$type = 'error';
			}
			wc_add_notice( $msg, $type );
		}
	}

	/**
	 * @return mixed|string|void
	 */
	public function get_cart_url() {
		if ( version_compare( WOOCOMMERCE_VERSION, '2.5.2', '>=' ) ) {
			return wc_get_cart_url();
		} else {
			$cart_page_id = woocommerce_get_page_id( 'cart' );
			if ( $cart_page_id ) {
				return apply_filters( 'woocommerce_get_cart_url', get_permalink( $cart_page_id ) );
			} else {
				return '';
			}
		}
	}
}

return new WooCommerce_Bulk_Order_Form_Standard_Add_To_Cart_Handler;
