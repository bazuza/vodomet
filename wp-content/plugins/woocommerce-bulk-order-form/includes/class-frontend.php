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
 * Class WooCommerce_Bulk_Order_Form_Functions
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 * @since 1.0
 */
class WooCommerce_Bulk_Order_Form_Functions {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if ( $this->load_assets() ) {
			wp_enqueue_style( WC_BOF_NAME . 'frontend_style', WC_BOF_CSS . 'frontend.css', array(), WC_BOF_V, 'all' );
			wp_register_style( WC_BOF_NAME . 'selectize', WC_BOF_CSS . 'selectize.css', array(), WC_BOF_V, 'all' );
			wp_enqueue_style( WC_BOF_NAME . 'selectize' );

			if( $parent_theme = wp_get_theme( get_template() ) ) {
				if ( $parent_theme->get('Name') == 'Flatsome' ) {
					wp_enqueue_style( WC_BOF_NAME . 'frontend_style_flatsome', WC_BOF_CSS . 'frontend-flatsome.css', array(), WC_BOF_V, 'all' );
				}
			}

		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( $this->load_assets() ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_register_script( WC_BOF_NAME . 'frontend_script', WC_BOF_JS . 'frontend.js', array(
				'jquery',
				'wc-add-to-cart-variation',
				WC_BOF_NAME . 'selectize',
				WC_BOF_NAME . 'form_handler',
			), WC_BOF_V, true );

			wp_register_script( WC_BOF_NAME . 'sprintf', WC_BOF_JS . 'wcbof-sprintf.js', null, WC_BOF_V, true );

			wp_register_script( WC_BOF_NAME . 'form_handler', WC_BOF_JS . 'wc_bof_handler.js', array( 'jquery' ), WC_BOF_V, true );
			wp_register_script( WC_BOF_NAME . 'selectize', WC_BOF_JS . 'selectize'.$suffix.'.js', array( 'jquery' ), WC_BOF_V, true );

			$localize_arr = apply_filters( 'wc_bof_localize_script_vars', array(
				'url'                       => admin_url( 'admin-ajax.php' ),
				'noproductsfound'           => __( 'No products found', 'woocommerce-bulk-order-form' ),
				'selectaproduct'            => __( 'Please select a product', 'woocommerce-bulk-order-form' ),
				'enterquantity'             => __( 'Enter quantity', 'woocommerce-bulk-order-form' ),
				'variation_noproductsfound' => __( 'No variations', 'woocommerce-bulk-order-form' ),
				'decimal_sep'               => wc_get_price_decimal_separator(),
				'thousands_sep'             => wc_get_price_thousand_separator(),
				'num_decimals'              => wc_get_price_decimals(),
				'Delay'                     => 500,
				'minLength'                 => 3,
				'checkouttext'              => __( 'Go to checkout', 'woocommerce-bulk-order-form' ),
				'carttext'                  => __( 'View cart', 'woocommerce-bulk-order-form' ),
				'checkouturl'               => $this->get_checkout_url(),
				'carturl'                   => $this->get_cart_url(),
				'price_format'              => get_woocommerce_price_format(),
			) );

			wp_localize_script( WC_BOF_NAME . 'frontend_script', 'WCBulkOrder', $localize_arr );
			wp_localize_script( WC_BOF_NAME . 'form_handler', 'WCBOFHandler', $localize_arr );

			wp_enqueue_script( WC_BOF_NAME . 'sprintf' );
			wp_enqueue_script( WC_BOF_NAME . 'selectize' );
			wp_enqueue_script( WC_BOF_NAME . 'form_handler' );
			wp_enqueue_script( WC_BOF_NAME . 'frontend_script' );
		}
	}

	/**
	 * Check if the scripts and styles should be loaded on the current page
	 *
	 * @since    3.1.2
	 * @return bool
	 */
	public function load_assets() {
		global $post;
		$has_shortcode = is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wcbulkorder' );

		return apply_filters( 'wc_bof_load_assets', $has_shortcode, $post );
	}	

	/**
	 * @return string
	 */
	public function get_checkout_url() {
		if ( version_compare( WOOCOMMERCE_VERSION, '2.5.2', '>=' ) ) {
			return wc_get_checkout_url();
		} else {
			global $woocommerce;
			return $woocommerce->cart->get_checkout_url();
		}
	}

	/**
	 * @return string
	 */
	public function get_cart_url() {
		if ( version_compare( WOOCOMMERCE_VERSION, '2.5.2', '>=' ) ) {
			return wc_get_cart_url();
		} else {
			global $woocommerce;
			return $woocommerce->cart->get_cart_url();
		}
	}
}
